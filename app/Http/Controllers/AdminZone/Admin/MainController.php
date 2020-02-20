<?php

namespace App\Http\Controllers\AdminZone\Admin;

use App\Http\Controllers\AdminZone\Admin\AdminBaseController;
use Illuminate\Http\Request;
use MetaTag;

class MainController extends AdminBaseController
{

    public function index(){

        MetaTag::setTags(['title' => 'Админ панель']);

        return view('admin-panel.admin.main.index');
    }
}
