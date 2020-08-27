<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/27
 * Time: 16:04
 */

namespace App\Http\Controllers\Web\Collect;


use App\Http\Controllers\Controller;
use App\Models\Collect\Photo\Photo;
use App\Repositories\Web\Collect\PhotoRepository;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function __construct(PhotoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 相册列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return $this->repository->index($request);
    }

    /**
     * z照片列表
     * @param Photo $photos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function list(Photo $photos)
    {
        return $this->repository->photoList($photos);
    }
}
