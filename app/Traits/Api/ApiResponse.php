<?php
namespace App\Traits\Api;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Response;

trait ApiResponse
{
    /**
     * 状态码
     * @var int
     */
    protected $statusCode = FoundationResponse::HTTP_OK;

    /**
     * 获取状态码
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * 设置状态码
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * 返回json数据
     * @param $data
     * @param array $header
     * @return mixed
     */
    public function respond($data, $header = [])
    {
        return Response::json($data, $this->getStatusCode(), $header);
    }

    /**
     * 状态返回
     * @param $status
     * @param array $data
     * @param null $code
     * @return mixed
     */
    public function status($status, array $data, $code = null)
    {
        if ($code) {
            $this->setStatusCode($code);
        }

        $status = [
            'status' => $status,
            'code' => $this->statusCode
        ];

        $data = array_merge($status, $data);
        return $this->respond($data);

    }

    /**
     * 失败返回
     * @param $message
     * @param int $code
     * @param int $status
     * @return mixed
     */
    public function failed($message, $code = FoundationResponse::HTTP_BAD_REQUEST, $status = 0)
    {
        return $this->setStatusCode($code)->message($message, $status);
    }

    /**
     * 设置返回信息
     * @param $message
     * @param int $status
     * @return mixed
     */
    public function message($message, $status = 1)
    {
        return $this->status($status,[
            'message' => $message
        ]);
    }

    /**
     * 错误返回
     * @param string $message
     * @return mixed
     */
    public function internalError($message = "Internal Error!")
    {
        return $this->failed($message,FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function created($message = "created")
    {
        return $this->setStatusCode(FoundationResponse::HTTP_CREATED)
            ->message($message);
    }

    /**
     * 成功返回
     * @param $data
     * @param int $status
     * @return mixed
     */
    public function success($data, $status = 1)
    {
        return $this->status($status, compact('data'));
    }

    /**
     * 成功返回去掉data
     * @param $data
     * @param int $status
     * @return mixed
     */
    public function listInfo($data, $status = 1)
    {
        return $this->status($status, $data);

    }

    /**
     * @param string $message
     * @return mixed
     */
    public function notFond($message = 'Not Fond!')
    {
        return $this->failed($message,Foundationresponse::HTTP_NOT_FOUND);
    }

}
