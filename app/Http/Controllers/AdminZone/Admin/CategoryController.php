<?php

namespace App\Http\Controllers\AdminZone\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCategoryUpdateRequest;
use App\Models\Admin\Category;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Http\Request;
use MetaTag;

class CategoryController extends AdminBaseController
{

    private $categoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->categoryRepository = app(CategoryRepository::class);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrMenu = Category::all();
        $menu = $this->categoryRepository->buildMenu($arrMenu);

        MetaTag::setTags(['title' => 'Список категорий']);

        return view('admin-panel.admin.category.index', ['menu' => $menu]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $item = new Category();
        $categoryList = $this->categoryRepository->getComboBosCategories();
        $categories = Category::with('children')->where('parent_id', 0)->get();
        $delimiter = '-';

        MetaTag::setTags(['title' => 'Создание новой категории']);

        return view('admin-panel.admin.category.create',
            compact('categories', 'delimiter', 'item', 'categoryList'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminCategoryUpdateRequest $request)
    {
        $name = $this->categoryRepository->checkUniqueName($request->title, $request->parent_id);

        if ($name) {
            return back()
                ->withErrors(['msg' => 'В одной категории не может быть двух одинаковых. Выбирите другую категорию.'])
                ->withInput();
        }

        $data = $request->except(['_token']);

        $item = new Category();
        $item->fill($data)->save();

        if ($item) {
            return redirect()
                ->route('adminzone.admin.categories.create', $item->id)
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
        $item = $this->categoryRepository->getId($id);
        if (empty($item)) {
            abort('404');
        }

        MetaTag::setTags(['title' => 'Редактирование категории № ' . $id]);

        $categories = Category::with('children')
            ->where('parent_id', '0')
            ->get();

        $delimiter = ' - ';

        return view('admin-panel.admin.category.edit',
            compact('categories', 'delimiter', 'item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminCategoryUpdateRequest $request, $id)
    {
        $item = $this->categoryRepository->getId($id);

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => 'Запись с id = '. $id .' не найдена'])
                ->withInput();
        }

        $data = $request->except(['_token']);

        $result = $item->update($data);

        if ($result) {
            return redirect()
                ->route('adminzone.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
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

    public function myDel(Request $request)
    {
        $id = $this->categoryRepository->getRequestID();

        if (!$id) {
            return back()->withErrors(['msg' => 'Нет такого id']);
        }

        $children = $this->categoryRepository->checkChildren($id);

        if ($children) {
            return back()->withErrors(['msg' => 'Удаление не возможно, в меню есть потомки меню']);
        }

        $parents = $this->categoryRepository->checkParentsProducts($id);

        if ($parents) {
            return back()->withErrors(['msg' => 'Удаление не возможно, в категории есть товары']);
        }

        $delete = $this->categoryRepository->deleteCategory($id);

        if ($delete) {
            return redirect()
                ->route('adminzone.admin.categories.index')
                ->with(['success' => 'Запись с id = ['.$id.'] удалена']);
        } else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
}
