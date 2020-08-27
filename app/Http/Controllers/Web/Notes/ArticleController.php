<?php

namespace App\Http\Controllers\Web\Notes;

use App\Http\Controllers\Controller;

use App\Http\Requests\Web\SubscriptionRequest;
use App\Models\Notes\Article;
use App\Repositories\Web\Notes\ArticleRepository;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function __construct(ArticleRepository $repository)
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

    /**
     * 文章详情
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Article $article)
    {
        return $data = $this->repository->detail($article);
    }

    /**
     * 订阅我
     * @param SubscriptionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe(SubscriptionRequest $request)
    {
        $email_name = $request->input('email_name');
        $blogModel = new BlogSubscribe();
        $blogModel->email = $email_name;
        $blogModel->ip = $request->getClientIp();
        $blogModel->is_pass = 1;
        $blogModel->add_mode = 1;
        $blogModel->save();

        $result = array(
            'status' => 1,
            'msg' => '订阅成功',
            'result' => []
        );
        return response()->json($result);
    }
}
