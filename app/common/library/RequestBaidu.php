<?php

namespace app\common\library;


use GuzzleHttp\Client;

class RequestBaidu
{

    const BAIDU_AK = "ce07ICxBkoKnfXaEDsvMFrktDLbekPyr";

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

    public static function get($reqRoute, $formRequest = [])
    {
        $domain = "http://api.map.baidu.com";

        $client = new Client([
            'base_uri' => $domain,
            'verify'   => false
        ]);


        $reqParams = [
            'form_params' => $formRequest
        ];

//        $response = $client->request('GET', $reqRoute, $reqParams);
        $response = $client->request('GET', $reqRoute, $reqParams);
        $body     = $response->getBody();
        $contents = $body->getContents();
        $data     = json_decode($contents, true);
        return $data;
    }

    public static function getLocationByAddress($address)
    {
        $ak = self::BAIDU_AK;
        $url = "/geocoding/v3/?address={$address}&output=json&ak={$ak}";
        $result = RequestBaidu::get($url);
        if ($result['status'] == 0) {
            $ret = [
                'result' => $result['result']
            ];
            return result_successed($ret);
        } else {
            return result_failed('获取经纬度失败，联系管理员');
        }

    }

    public static function getAddressByLocation($lat, $lng)
    {
        $ak = self::BAIDU_AK;
        $url = "/reverse_geocoding/v3/?coordtype=wgs84ll&output=json&ak={$ak}&location={$lat},{$lng}";

        $result = RequestBaidu::get($url);
        if ($result['status'] == 0) {
            $ret = [
                'result' => $result['result']
            ];
            return result_successed($ret);
        } else {
            return result_failed('获取地址，联系管理员');
        }

    }

    public static function getDirectionliteByDrive($origin_lat, $origin_lng,$destination_lat, $destination_lng)
    {
        $ak = self::BAIDU_AK;

        $url ="/directionlite/v1/driving?origin={$origin_lat},{$origin_lng}&destination={$destination_lat},{$destination_lng}&ak={$ak}";


        try {
            $result = RequestBaidu::get($url);
            if ($result['status'] == 0) {
                $ret = [
                    'result' => $result['result']
                ];
                return result_successed($ret);
            } else {
                return result_failed('获取地址，联系管理员');
            }
        } catch (\Exception $e) {
            return result_failed($e->getMessage());

        }


    }




}
