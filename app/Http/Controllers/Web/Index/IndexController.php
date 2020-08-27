<?php

namespace App\Http\Controllers\Web\Index;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //进入网站首页
    public function index()
    {
        return view('web.index.index');
    }
}
