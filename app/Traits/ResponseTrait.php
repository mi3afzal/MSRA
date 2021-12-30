<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ResponseTrait
{

    /**
     * response code variable
     *
     * @var string
     */
    public $code = "";

    /**
     * status variable i.e. success, error
     *
     * @var string
     */
    public $status = "";

    /**
     * response message variable
     *
     * @var string
     */
    public $message = "";

    /**
     * token variable
     *
     * @var string
     */
    public $token = "";

    /**
     * cacheKey variable
     *
     * @var string
     */
    public $cacheKey = "";

    /**
     * cacheFlag variable
     *
     * @var string
     */
    public $cacheFlag = "";


    /**
     * scopeSuperadmin function
     *
     * @param Object $query
     * @return void
     */
    public function response($code = "", $status = "", $message = "", $token = "", $data = "", $cacheKey = "", $cacheFlag = "")
    {

        $response = [];

        if (isset($token) && !empty($token)) {
            $response['token'] = $token;
        }

        $response["code"] = $code;
        $response["status"] = $status;
        $response["message"] = $message;
        $response["data"] = $data;

        if ($status == "success") {
            return $return = response()->json($response, 200);
        }

        return $return = response()->json($response, $code);

        // if (!empty($cacheFlag) && isset($cacheFlag)) {
        //     $return = $this->createCache($cacheKey, $return);
        //     return  Cache::pull($cacheKey);
        // }
    }

    /**
     * createCache function
     *
     * @param string $key
     * @param string $cacheFlag
     * @param Json $data
     * @return void
     */
    public function createCache($key = "", $data = null)
    {
        Cache::put($key, $data, $seconds = 60);
    }
}
