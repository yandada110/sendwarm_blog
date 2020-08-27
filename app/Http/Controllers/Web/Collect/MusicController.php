<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/27
 * Time: 16:04
 */

namespace App\Http\Controllers\Web\Collect;


use App\Http\Controllers\Controller;
use App\Models\Collect\Music\SongList;
use App\Repositories\Web\Collect\MusicRepository;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    public function __construct(MusicRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 歌单列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return $this->repository->index($request);
    }

    /**
     * 音乐列表
     * @param SongList $song
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function list(SongList $song)
    {
        return $this->repository->musicList($song);
    }
}
