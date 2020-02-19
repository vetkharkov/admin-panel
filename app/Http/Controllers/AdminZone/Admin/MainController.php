<?php

namespace App\Http\Controllers\AdminZone\Admin;

use App\Http\Controllers\AdminZone\Admin\AdminBaseController;
use Illuminate\Http\Request;

class MainController extends AdminBaseController
{
    public function index(){
        return view('admin-panel.admin.main.index');
    }
}
