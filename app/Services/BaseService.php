<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/8/8
 * Time: 12:04
 */

namespace App\Services;


class BaseService
{
    /**
     * 提示消息
     * @var string
     */
    protected $message = '';

    /**
     * 设置错误消息
     * @param $message
     */
    public function setErrorMessage($message){
        $this->message = $message;
    }

    /**
     * 获取错误消息
     * @return string
     */
    public function getErrorMessage(){
        return $this->message;
    }
}