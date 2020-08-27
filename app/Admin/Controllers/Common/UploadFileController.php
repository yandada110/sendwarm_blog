<?php

namespace App\Admin\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Services\Common\UpdateFileService;
use Illuminate\Http\Request;
use App\Traits\Api\ApiResponse;

class UploadFileController extends Controller
{
    use ApiResponse;

    protected $updateFileService;

    protected $ApiResponse;

    public function __construct(Request $request)
    {
        $this->updateFileService = new UpdateFileService($request, $request->input('file'));
    }

    /**
     * 图片上传
     * @return mixed
     */
    public function store()
    {
        switch (env('UPLOAD_TYPE')) {
            case 'qiniu':
                $res = $this->updateFileService->updateQiNiu();
                break;
            default://默认本地
                $res = $this->updateFileService->updateLocal();
        }
        return $this->respond($res);
    }
}
