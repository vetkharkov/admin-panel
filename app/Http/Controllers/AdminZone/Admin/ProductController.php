<?php

namespace App\Http\Controllers\AdminZone\Admin;

use App\Admin\Core\AdminApp;
use App\Http\Requests\AdminProductCreateRequest;
use App\Models\Admin\Product;
use App\Repositories\Admin\ProductRepository;
use Auth;
use File;
use Illuminate\Http\Request;
use MetaTag;
use App\Models\Admin\Category;
use Session;


class ProductController extends AdminBaseController
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = 10;
        $getAllProducts = $this->productRepository->getAllProducts($perPage);
        $count = $this->productRepository->getCountProducts();

        MetaTag::setTags(['title' => "Список товаров"]);

        return view('admin-panel.admin.product.index', compact('getAllProducts', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /**
         * CHECK LARAVEL USER AUTH
         */

        $isAuthorized = Auth::user()->isAdministrator();

        if ($isAuthorized) {
            session_start();
            $_SESSION['KCFINDER'] = array();
            $_SESSION['KCFINDER']['disabled'] = false;

        } else {
            if (isset($_SESSION['KCFINDER'])) {
                unset($_SESSION['KCFINDER']);
            }
        }

        $item = new Category();
        $categories = Category::with('children')->where('parent_id', '0')->get();
        $delimiter = '-';

        MetaTag::setTags(['title' => "Создание нового товара"]);

        return view('admin-panel.admin.product.create', compact('item', 'categories', 'delimiter'));
    }


    public function store(AdminProductCreateRequest $request)
    {
        $data = $request->input();
        $product = (new Product())->create($data);
        $id = $product->id;
        $product->status = $request->status ? '1' : '0';
        $product->hit = $request->hit ? '1' : '0';
        $product->category_id = $request->parent_id ?? 0;
        $this->productRepository->getImg($product);
        $save = $product->save();

        if ($save) {
            $this->productRepository->editFilter($id, $data);
            $this->productRepository->editRelatedProduct($id, $data);
            $this->productRepository->saveGallery($id);
            return redirect()
                ->route('adminzone.admin.products.create', [$product->id])
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->productRepository->getInfoProduct($id);
//        $id = $product->id;
        AdminApp::get_instance()->setProperty('parent_id', $product->category_id);

        $filter = $this->productRepository->getFiltersProduct($id);
        $related_products = $this->productRepository->getRelatedProducts($id);
        $images = $this->productRepository->getGallery($id);

//        dd($related_products);

        $categories = Category::with('children')->where('parent_id', '0')->get();
        $delimiter = '-';

        MetaTag::setTags(['title' => "Редактирование товара № $id"]);

        return view('admin-panel.admin.product.edit',
            compact('filter','related_products', 'product', 'categories', 'images', 'delimiter', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminProductCreateRequest $request, $id)
    {
        $product = $this->productRepository->getId($id);
        if(empty($product)){
            return back()
                ->withErrors(['msg' => "Запись = [{$id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();
//        dd($product);
        $result = $product->update($data);
        $product->status = $request->status ? '1' : '0';
        $product->hit = $request->hit ? '1' : '0';
        $product->category_id = $request->parent_id ?? $product->category_id;
        $this->productRepository->getImg($product);
        $save = $product->save();

        if($result && $save) {
            $this->productRepository->editFilter($id, $data);
            $this->productRepository->editRelatedProduct($id, $data);
            $this->productRepository->saveGallery($id);
            return redirect()
                ->route('adminzone.admin.products.edit', [$product->id])
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => "Ошибка сохранения"])
                ->withInput();
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /** Return STATUS = 1 */
    public function returnStatus($id)
    {
        if($id){
            $st = $this->productRepository->returnStatusOne($id);
            if($st){
                return redirect()
                    ->route('adminzone.admin.products.index')
                    ->with(['success' => 'Успешно сохранено']);
            } else {
                return back()
                    ->withErrors(['msg' => "Ошибка сохранения"])
                    ->withInput();
            }
        }

        return back()
            ->withErrors(['msg' => "Нет такого товара"])
            ->withInput();

    }

    /** Return STATUS = 0 */
    public function deleteStatus($id)
    {
        if($id){
            $st = $this->productRepository->deleteStatusOne($id);
            if($st){
                return redirect()
                    ->route('adminzone.admin.products.index')
                    ->with(['success' => 'Успешно сохранено']);
            } else {
                return back()
                    ->withErrors(['msg' => "Ошибка сохранения"])
                    ->withInput();
            }
        }

        return back()
            ->withErrors(['msg' => "Нет такого товара"])
            ->withInput();
    }

    /** Delete One Product from DB */
    public function deleteProduct($id)
    {
        if($id){
            $gallery = $this->productRepository->deleteImgFromPath($id);
            $db = $this->productRepository->deleteFromDb($id);
            if($db){
                return redirect()
                    ->route('adminzone.admin.products.index')
                    ->with(['success' => 'Успешно удалено']);
            } else {
                return back()
                    ->withErrors(['msg' => "Ошибка удаления"])
                    ->withInput();
            }
        }
        return back()
            ->withErrors(['msg' => "Ошибка удаления"])
            ->withInput();
    }


    public function related(Request $request)
    {
        $q = isset($request->q) ? htmlspecialchars(trim($request->q)) : '';
        $data['items'] = [];
        $products = $this->productRepository->getProducts($q);

        if ($products) {
            $i = 0;
            foreach ($products as $id => $title) {
                $data['items'][$i]['id'] = $title->id;
                $data['items'][$i]['text'] = $title->title;
                $i++;
            }
        }
        echo json_encode($data);
        die;
    }

    public function ajaxImage(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin-panel.admin.product.include.image_single_edit');
        } else {
            $validator = \Validator::make($request->all(),
                [
                    'file' => 'image|max:5000',
                ],
                [
                    'file.image' => 'Файл должен быть картинкой (jpg, png, gif, svg)',
                    'file.max' => 'Максимальный размер картинки 5Mb',
                ]);
            if ($validator->fails()) {
                return array('fail' => true, 'errors' => $validator->errors());
            }
        }

        $extension = $request->file('file')->getClientOriginalExtension();
        $dir = 'uploads/single/';
        $filename = uniqid().'_'.time().'.'.$extension;
        $request->file('file')->move($dir, $filename);

        $wmax = AdminApp::get_instance()->getProperty('img_width');
        $hmax = AdminApp::get_instance()->getProperty('img_height');

        $this->productRepository->uploadImg($filename, $wmax, $hmax);

        return $filename;

    }

    public function gallery(Request $request)
    {
        $validator = \Validator::make($request->all(),
            [
                'file' => 'image|max:5000',
            ],
            [
                'file.image' => 'Файл должен быть картинкой (jpg, png, gif, svg)',
                'file.max' => 'Максимальный размер картинки 5Mb',
            ]);
        if ($validator->fails()) {
            return array(
                'fail' => true,
                'errors' => $validator->errors(),
            );
        };

        if (isset($_GET['upload'])) {
            $wmax = AdminApp::get_instance()->getProperty('gallery_width');
            $hmax = AdminApp::get_instance()->getProperty('gallery_height');
            $name = $_POST['name'];

            $res = $this->productRepository->uploadGallery($name, $wmax, $hmax);
            return response()->json($res);

        }

    }


    /**
     * Destroy single image
     * @param $filename
     */
    public function deleteImage($filename)
    {
        $image_path = public_path("uploads/single/".$filename);

        if(file_exists($image_path)){
            File::delete($image_path);
//            return 'file OK '.$image_path;
        }

    }

    /**
     * Destroy gallery image
     */
    public function deleteGallery()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $src = isset($_POST['src']) ? $_POST['src'] : null;
        $image_path = public_path("uploads/gallery/".$src);

        if (!$id || !$src) {
            return false;
        }
//        if (\DB::delete("DELETE FROM galleries WHERE product_id = ? AND img = ?", [$id, $src])) {
//            @unlink("uploads/gallery/$src");
//            exit('1');
//        }

//        File::delete('uploads/gallery'.$filename);
        \DB::delete("DELETE FROM galleries WHERE product_id = ? AND img = ?", [$id, $src]);
        if(file_exists($image_path)){
            File::delete($image_path);
//            return 'File delete path: '.$image_path;
        }
                    exit('1');

//        return $image_path;
    }


}
