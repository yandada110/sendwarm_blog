<?php

namespace App\Http\Controllers\Web\Share;

use App\Http\Controllers\Controller;

use App\Repositories\Web\Share\ShareRepository;
use Illuminate\Http\Request;

class ShareController extends Controller
{

    public function __construct(ShareRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 文章首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return $data = $this->repository->list($request);
    }
}
