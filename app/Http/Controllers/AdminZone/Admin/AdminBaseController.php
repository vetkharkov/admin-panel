<?php

namespace App\Http\Controllers\AdminZone\Admin;

use App\Http\Controllers\AdminZone\BaseController as MainBaseController;
use Illuminate\Http\Request;

abstract class AdminBaseController extends MainBaseController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('status');
    }


}
