<?php

namespace App\Http\Traits;

use Illuminate\Http\ResponseTrait;

/**
 * Trait JsonResponseTrait
 *
 * @package App\Http\Traits
 */
trait JsonResponseTrait
{
    use ResponseTrait;

    /**
     * @param $params
     *
     * @return array
     */
    public function getResponseByParam($params)
    {
        $response            = [];
        $message             = config("responses.{$params['status']}.{$params['method']}.message");
        $response["status"]  = config("responses.{$params['status']}.{$params['method']}.status");
        $response["message"] = !empty($params['id']) ? sprintf($message, $params['id']) : $message;

        return $response;
    }

    /**
     * @param $params
     * @param $data
     *
     * @return array
     */
    public function handleResponse($params, $data = null)
    {
        $response = $this->getResponseByParam($params);
        if (in_array(null, $response)) {
            $response = $this->getGenericResponse();
        }

        $response["data"] = $data;

        return $response;
    }

    public function getGenericResponse()
    {
        return [
            'status'  => 404,
            'message' => 'no message found for this method please add custom message in response.php file!',
            'data'    => null
        ];
    }
}
