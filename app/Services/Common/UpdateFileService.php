<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/12
 * Time: 16:47
 */

namespace App\Services\Common;

use App\Services\BaseService;
use Illuminate\Http\Request;
use zgldh\QiniuStorage\QiniuStorage;

class UpdateFileService extends BaseService
{
    protected $request;

    protected $fileName;

    protected $file;

    protected $date;

    public function __construct(Request $request, $file)
    {
        $this->request = $request;
        $this->file = $file;
        $this->date = now()->format('Y-m-d');
    }

    /**
     * 插件上传七牛
     * @return array
     */
    public function updateQiNiu()
    {
        $file_data = $this->request->file($this->file);
        // 初始化
        $disk = QiniuStorage::disk('qiniu');
        // 重命名文件
        $fileName = $this->file . '/' . $this->date . '/' . md5($file_data->getClientOriginalName() . rand()) . '.' . $file_data->getClientOriginalExtension();
        // 上传到七牛
        $bool = $disk->put($fileName, file_get_contents($file_data->getRealPath()));
//        $file_data->extension();//图片后缀
//        $request->getClientIp();//图片上传ip;
        return array(
            'success' => $bool ? 1 : 0,
            'message' => $bool ? '上传成功' : '上传失败',
            'url' => $disk->downloadUrl($fileName)
        );
    }

    /**
     * 本地上传
     * @return array
     */
    public function updateLocal()
    {
        $save_src = $this->request->file('editormd-image-file')->store($this->file . '/' . $this->date, 'admin');
//        $file_data->extension();//图片后缀
//        $request->getClientIp();//图片上传ip
        return array(
            'success' => $save_src ? 1 : 0,
            'message' => $save_src ? '上传成功' : '上传失败',
            'url' => asset('uploads/' . $save_src)
        );
    }
}
