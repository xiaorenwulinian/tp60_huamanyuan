<?php

namespace app\common\library;




use GuzzleHttp\Client;

class RequestLib
{

    protected static $instance ;

    private function __construct(){}

    private function __clone(){}

    /**
     * 获取实例对象，单例模式
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public static function ehsGet()
    {

    }

    public static function ehsRequest($reqRoute, $formRequest = [])
    {
        $domain = "http://testapi.shhka.com";

        $client = new Client([
            'base_uri' => $domain,
            'verify'   => false
        ]);

        $timestamp = microtime(true);
        $salt = "ehs";
        $sign = md5($timestamp . $salt);
        $formRequest['sign'] = $sign;
        $formRequest['timestamp'] = $timestamp;

        $reqParams = [
            'form_params' => $formRequest
        ];

//        $response = $client->request('GET', $reqRoute, $reqParams);
        $response = $client->request('POST', $reqRoute, $reqParams);
        $body     = $response->getBody();
        $contents = $body->getContents();
        $data     = json_decode($contents, true);
        return $data;
    }




}
