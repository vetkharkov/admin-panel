<?php

namespace App\Http\Controllers\AdminZone\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminAttrFilterAddRequest;
use App\Http\Requests\AdminGroupFilterAddRequest;
use App\Models\Admin\AttributeGroup;
use App\Models\Admin\AttributeValue;
use App\Repositories\Admin\FilterAttrRepository;
use App\Repositories\Admin\FilterGroupRepository;
use Illuminate\Http\Request;
use MetaTag;

class FilterController extends AdminBaseController
{

    private $filterGroupRepository;
    private $filterAttrRepository;

    public function __construct(
        FilterAttrRepository $filterAttrRepository,
        FilterGroupRepository $filterGroupRepository
    ) {
        parent::__construct();
        $this->filterAttrRepository = $filterAttrRepository;
        $this->filterGroupRepository = $filterGroupRepository;
    }

    /** Show all groups of filter table->attribute_group */
    public function attributeGroup()
    {
        $attrs_group = $this->filterGroupRepository->getAllGroupsFilter();

        MetaTag::setTags(['title' => 'Группы фильтров']);

        return view('admin-panel.admin.filter.attribute-group', compact('attrs_group'));
    }

    public function groupCreate()
    {
        MetaTag::setTags(['title' => 'Новая группа фильтров']);

        return view('admin-panel.admin.filter.group-add-group');
    }

    /** Add group for filter table->attribute_group
     * @param AdminGroupFilterAddRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function groupAdd(AdminGroupFilterAddRequest $request)
    {
        $data = $request->input();

        $group = (new AttributeGroup())->create($data);
        $group->save();

        if ($group) {
            return redirect()
                ->route('adminzone.admin.filters.group-create')
                ->with(['success' => 'Добавлена новая группа']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка создания новой группы'])
                ->withInput();
        }

    }

    /** Edit group filter */
    public function groupEdit($id)
    {
        if (empty($id)) {
            return back()->withErrors(['msg' => "Запись с id = [{$id}] не найдена!"]);
        }

        $group = $this->filterGroupRepository->getInfoProduct($id);

        MetaTag::setTags(['title' => 'Редактирование группы фильтров']);

        return view('admin-panel.admin.filter.group-edit', compact('group'));

    }

    public function groupUpdate(AdminGroupFilterAddRequest $request, $id)
    {
        if (empty($id)) {
            return back()->withErrors(['msg' => "Запись с id = [{$id}] не найдена!"]);
        }

        $group = AttributeGroup::find($id);
        $group->title = $request->title;
        $group->save();
        if ($group) {
            return redirect()
                ->route('adminzone.admin.filters.group-filter')
                ->with(['success' => 'Успешно изменено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка редактирования группы'])
                ->withInput();
        }
    }

    /** Destroy group of filter table->attribute_group */
    public function groupDelete($id)
    {
        if (empty($id)) {
            return back()->withErrors(['msg' => "Запись с id = [{$id}] не найдена!"]);
        }

        $count = $this->filterAttrRepository->getCountFilterAttrsById($id);

        if ($count) {
            return back()
                ->withErrors(['msg' => 'Удаление невозможно в группе есть атрибуты - ' . "[$count]"]);
        }

        $delete = $this->filterGroupRepository->deleteGroupFilter($id);

        if ($delete) {
            return back()
                ->with(['success' => 'Успешно удалено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка удаления группы']);
        }

    }

    /** Show all attribute for filter table->attribute_values  */
    public function attributeFilter()
    {
        $attrs = $this->filterAttrRepository->getAllAttrsFilter();
        $count = $this->filterGroupRepository->getCountGroupFilter();

        MetaTag::setTags(['title' => 'Фильтры']);

        return view('admin-panel.admin.filter.attribute', compact('attrs', 'count'));
    }

    /** Create attribute for filter */
    public function attributeAdd()
    {
        $group = $this->filterGroupRepository->getAllGroupsFilter();

        MetaTag::setTags(['title' => 'Новый атрибут для фильтра']);

        return view('admin-panel.admin.filter.attribute-add', compact('group'));

    }

    /**
     * Create attribute for filter
     */
    public function attributeStore(AdminAttrFilterAddRequest $request)
    {
        $uniqueName = $this->filterAttrRepository->checkUnique($request->value);

        if ($uniqueName) {
            return redirect()
                ->route('adminzone.admin.filters.attr-add')
                ->withErrors(['msg' => 'Такое название уже есть'])
                ->withInput();
        }

        $data = $request->input();

        $attr = (new AttributeValue())->create($data);
        $attr->save();

        if ($attr) {
            return redirect()
                ->route('adminzone.admin.filters.attr-add')
                ->with(['success' => 'Добавлен новый фильтр']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка создания фильтра'])
                ->withInput();
        }

    }

    /**
     * Edit attribute for filter {GET}
     */
    public function attributeEdit($id)
    {
        if (empty($id)) {
            return back()->withErrors(['msg' => "Запись с id = [{$id}] не найдена!"]);
        }

        $attr =$this->filterAttrRepository->getInfoProduct($id);
        $group = $this->filterGroupRepository->getAllGroupsFilter();

        MetaTag::setTags(['title' => 'Редактирование фильтра']);

        return view('admin-panel.admin.filter.attribute-edit', compact('group', 'attr'));
    }

    /**
     * Edit attribute for filter {POST}
     */
    public function attributeUpdate(AdminAttrFilterAddRequest $request, $id)
    {
        if (empty($id)) {
            return back()->withErrors(['msg' => "Запись с id = [{$id}] не найдена!"]);
        }

        $attr = AttributeValue::find($id);
        $attr->value = $request->value;
        $attr->attr_group_id = $request->attr_group_id;
        $attr->save();

        if ($attr) {
            return redirect()
                ->route('adminzone.admin.filters.attributes-filter')
                ->with(['success' => 'Успешно изменено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка изменения фильтра'])
                ->withInput();
        }
    }

    /**
     * Destroy attribute for filter
     */
    public function attributeDelete($id)
    {
        if (empty($id)) {
            return back()->withErrors(['msg' => "Запись с id = [{$id}] не найдена!"]);
        }

        $delete = $this->filterAttrRepository->deleteAttrFilter($id);

        if ($delete) {
            return back()->with(['success' => 'Успешно удалено']);
        } else {
            return back()->withErrors(['msg' => 'Ошибка удаления фильтра']);
        }
    }

}
