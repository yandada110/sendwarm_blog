<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/27
 * Time: 16:04
 */

namespace App\Http\Controllers\Web\Collect;


use App\Http\Controllers\Controller;
use App\Models\Collect\Video\Video;
use App\Repositories\Web\Collect\VideoRepository;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 视频列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
//        dd((43188.69-10000*1.5063)/18488.58);
        return $this->repository->index($request);
    }

    /**
     * 视频详情
     * @param Video $videos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function detail(Video $videos)
    {
        return $this->repository->VideoDetail($videos);
    }
}
