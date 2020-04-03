<?php

namespace App\Repositories\Admin;

use App\Repositories\CoreRepository;
use App\Models\Admin\Product as Model;
use File;
use Session;

class ProductRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getLastProducts($perpage)
    {
        $get = $this->startConditions()
            ->orderBy('id', 'desc')
            ->limit($perpage)
            ->paginate($perpage);

        return $get;
    }

    public function getAllProducts($perPage)
    {
        $getAll = $this->startConditions()
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.title AS cat')
            ->orderBy(\DB::raw('LENGTH(products.title)', 'products.title'))
            ->paginate($perPage);

        return $getAll;
    }

    public function getCountProducts()
    {
        $count = $this->startConditions()->count();

        return $count;
    }

    public function getProducts($q)
    {
        $products = \DB::table('products')
            ->select('id', 'title')
            ->where('title', 'LIKE', ["%{$q}%"])
            ->limit(8)
            ->get();

        return $products;
    }

    public function uploadImg($name, $wmax, $hmax)
    {
        $uploaddir = 'uploads/single/';
        $ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $name));
        $uploadfile = $uploaddir.$name;
        Session::put('single', $name);
        self::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);

    }

    /** Resize Images
     * @param string $target путь к оригинальному файлу
     * @param string $dest путь сохранения обработанного файла
     * @param string $wmax максимальная ширина
     * @param string $hmax максимальная высота
     * @param string $ext расширение файла
     */

    public static function resize($target, $dest, $wmax, $hmax, $ext)
    {
        list($w_orig, $h_orig) = getimagesize($target);
        $ratio = $w_orig / $h_orig; // =1 - квадрат, <1 - альбомная, >1 - книжная

        if (($wmax / $hmax) > $ratio) {
            $wmax = $hmax * $ratio;
        } else {
            $hmax = $wmax / $ratio;
        }

        $img = "";
        // imagecreatefromjpeg | imagecreatefromgif | imagecreatefrompng
        switch ($ext) {
            case("gif"):
                $img = imagecreatefromgif($target);
                break;
            case("png"):
                $img = imagecreatefrompng($target);
                break;
            default:
                $img = imagecreatefromjpeg($target);
        }
        $newImg = imagecreatetruecolor($wmax, $hmax); // создаем оболочку для новой картинки

        if ($ext == "png") {
            imagesavealpha($newImg, true); // сохранение альфа канала
            $transPng = imagecolorallocatealpha($newImg, 0, 0, 0, 127); // добавляем прозрачность
            imagefill($newImg, 0, 0, $transPng); // заливка
        }

        imagecopyresampled($newImg, $img, 0, 0, 0, 0, $wmax, $hmax, $w_orig,
            $h_orig); // копируем и ресайзим изображение
        switch ($ext) {
            case("gif"):
                imagegif($newImg, $dest);
                break;
            case("png"):
                imagepng($newImg, $dest);
                break;
            default:
                imagejpeg($newImg, $dest);
        }

        imagedestroy($newImg);
    }

    public function uploadGallery($name, $wmax, $hmax)
    {
        $uploaddir = 'uploads/gallery/';
        $ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES[$name]['name']));

//        $new_name = md5(time()).".$ext";
        $new_name = 'img-' . time().".$ext";
        $uploadfile = $uploaddir.$new_name;

        Session::push('gallery', $new_name);

        if (@move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile)) {
            self::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);
            $res = array("file" => $new_name);
//            $response = \Response::json($res, 200);
//            return response()->json($res);
//            echo json_encode($res);
            return $res;
        }
    }

    public function getImg($product)
    {
        clearstatcache();
        if (!empty(\Session::get('single'))) {
            $name = \Session::get('single');
            $product->img = $name;
            \Session::forget('single');
            return;
        }

        if (empty(\Session::get('single')) && !is_file(WWW . '/uploads/single/' . $product->img)) {
            $product->img = null;
        }

        return;
    }

    public function editFilter($id, $data)
    {
        $filter = \DB::table('attribute_products')
            ->where('product_id', $id)
            ->pluck('attr_id')
            ->toArray();

        /** Если убрали фильтры */
        if (empty($data['attrs']) && !empty($filter)) {
            \DB::table('attribute_products')
                ->where('product_id', $id)
                ->delete();
            return;
        }

        /** Если добавили фильтры */
        if (!empty($data['attrs']) && empty($filter)) {
            $sql_part = '';
            foreach ($data['attrs'] as $v) {
                $sql_part .= "($v, $id),";
            }
            $sql_part = rtrim($sql_part, ',');
            \DB::insert("INSERT INTO attribute_products (attr_id, product_id) VALUES $sql_part");
            return;
        }

        /** Если меняем фильтры */
        if (!empty($data['attrs'])) {
            $result = array_diff($filter, $data['attrs']);
            if ($result) {
                \DB::table('attribute_products')
                    ->where('product_id', $id)
                    ->delete();
                $sql_part = '';
                foreach ($data['attrs'] as $v) {
                    $sql_part .= "($v, $id),";
                }
                $sql_part = rtrim($sql_part, ',');
                \DB::insert("INSERT INTO attribute_products (attr_id, product_id) VALUES $sql_part");
            }
            return;
        }
    }


    public function editRelatedProduct($id, $data)
    {
        $related_product = \DB::table('related_products')
            ->select('related_id')
            ->where('product_id', $id)
            ->pluck('related_id')
            ->toArray();

        /** Если убрали связанные товары */
        if (empty($data['related']) && !empty($related_product)) {
            \DB::table('related_products')
                ->where('product_id', $id)
                ->delete();
            return;
        }

        /** Если добавили связанные товары */
        if (!empty($data['related']) && empty($related_product)) {
            $sql_part = '';

            foreach ($data['related'] as $v) {
                $v = (int)$v;
                $sql_part .= "($id, $v),";
            }
            $sql_part = rtrim($sql_part, ',');

            \DB::insert("INSERT INTO related_products (product_id, related_id) VALUES $sql_part");
            return;
        }

        /** Если изменили связанные товары */
        if (!empty($data['related'])) {
            $result = array_diff($related_product, $data['related']);

            if (!(empty($result)) || count($related_product) != count($data['related'])) {
                \DB::table('related_products')
                    ->where('product_id', $id)
                    ->delete();
                $sql_part = '';
                foreach ($data['related'] as $v) {
                    $sql_part .= "($id, $v),";
                }
                $sql_part = rtrim($sql_part, ',');
                \DB::insert("INSERT INTO related_products (product_id, related_id) VALUES $sql_part");
            }
            return;
        }
    }

    /** Save images gallery to database */
    public function saveGallery($id)
    {
        if (!empty(\Session::get('gallery'))) {
            $sql_part = '';
            foreach (\Session::get('gallery') as $v) {
                $sql_part .= "('$v', $id),";
            }

            $sql_part = rtrim($sql_part, ',');
            \DB::insert("INSERT INTO galleries (img, product_id) VALUES $sql_part");
            \Session::forget('gallery');
        }
    }

    /** Get All info about one product */
    public function getInfoProduct($id)
    {
        $product = $this->startConditions()->find($id);
        return $product;
    }

    /** Get Filters one product */
    public function getFiltersProduct($id)
    {
        $filters = \DB::table('attribute_products')
            ->select('attr_id')
            ->where('product_id', $id)
            ->pluck('attr_id')
            ->all();
        return $filters;
    }

    /** Get Related products one product */
    public function getRelatedProducts($id)
    {
        $related_products =$this->startConditions()
            ->join('related_products', 'products.id', '=', 'related_products.related_id')
            ->select('products.title', 'related_products.related_id')
            ->where('related_products.product_id', $id)
            ->get();
        return $related_products;
    }

    /** Get gallery one product */
    public function getGallery($id)
    {
        $gallery = \DB::table('galleries')
            ->where('product_id', $id)
            ->pluck('img')
            ->all();
        return $gallery;
    }

    /** Turn status = On */
    public function returnStatusOne($id)
    {
        if(isset($id)){
            $st = \DB::update("UPDATE products SET status='1' WHERE id = ?", [$id]);
            if($st){
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /** Turn status = Off */
    public function deleteStatusOne($id)
    {
        if(isset($id)){
            $st = \DB::update("UPDATE products SET status='0' WHERE id = ?", [$id]);
            if($st){
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /** Delete images after del one product */
    public function deleteImgFromPath($id)
    {
        $galleryImg = \DB::table('galleries')
            ->select('img')
            ->where('product_id', $id)
            ->pluck('img')
            ->all();
        
        $singleImg = \DB::table('products')
            ->select('img')
            ->where('id', $id)
            ->pluck('img')
            ->all();

        if(!empty($galleryImg)){
            foreach ($galleryImg as $img) {
                $image_path = public_path("uploads/single/".$img);
                if(file_exists($image_path)){
                    File::delete($image_path);
                }
            }
        }

        if(!empty($singleImg)){
                $image_path = public_path("uploads/single/".$singleImg[0]);
                if(file_exists($image_path)){
                    File::delete($image_path);
                }
        }

    }

    /** Delete one product from DB */
    public function deleteFromDb($id)
    {
        if(isset($id)){
            $related_products = \DB::delete('DELETE FROM related_products WHERE product_id = ?', [$id]);
            $atr_products = \DB::delete('DELETE FROM attribute_products WHERE product_id = ?', [$id]);
            $gallery = \DB::delete('DELETE FROM galleries WHERE product_id = ?', [$id]);
            $product = \DB::delete('DELETE FROM products WHERE id = ?', [$id]);

            if($product){
                return true;
            } else {
                return false;
            }
        }
    }


}