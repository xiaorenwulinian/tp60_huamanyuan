<?php

namespace app\common\library\wechat;

/**
 * 小程序用户提现
 * Class XcxPay
 * @package app\libs\wechat
 */
class XcxPay{
    protected $appid;    //appid
    protected $mch_id;   //商户id
    protected $string;   //随机字符串
    protected $sign;     //签名
    protected $partner_trade_no;// 订单号
    protected $openid;    //openid
    protected $check_name; //是否校验用户姓名
    protected $amount;       //金额
    protected $desc;       //备注
    protected $spbill_create_ip;   //ip地址

    protected $config;


    public function __construct($partner_trade_no, $openid, $amount,$desc)
    {

        $this->config =[
            'mch_appid'         => env('APP_ID'),
            'mchid'             => env('MCH_ID'),
            'nonce_str'         => $this->randomCode(),
            'desc'              => $desc,
            'partner_trade_no'  => $partner_trade_no,
            'check_name'        => 'NO_CHECK',
            'amount'            => $amount * 100,
            'openid'            => $openid,
            'spbill_create_ip'  => $_SERVER['REMOTE_ADDR'],
//            'spbill_create_ip' =>'47.98.221.16',
        ];

        $this->sign = $this->get_sign();
        $this->config['sign'] = $this->sign;

    }

    /*
     * 微信支付
     */
    public function wxPay(){
        // 用户提现
        $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";

        $xmlData = self::arrayToXml($this->config);

        $return = self::xmlToArray($this->curl_post_ssl($xmlData, $url, 60));
        return $return;

    }

    /*
     * xml 转成数组
     */
    public static function xmlToArray($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }


    /*
     * 随机字符串
     */
    private function randomCode(){
        return md5(md5(microtime(true)).uniqid(rand(), true));
    }

    /*
     * 获取签名
     */
    private  function  get_sign(){
        ksort($this->config);

        $str = '';
        foreach ($this->config as $key => $val) {
            $str .= $key . '=' . $val . '&';
        }
        $str = rtrim($str, '&');


        $String = $str . "&key=" . env('SHOP_KEY');


        $String = strtoupper(md5($String));




        return $String;
    }

    /*
     * 数组转xml
     */
    public static function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= "<" . $key . ">" . self::arrayToXml($val) . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
        }
        $xml .= "</xml>";


        return $xml;
    }

    /*
     * curl post 请求
     *
     */
    function curl_post_ssl( $xml,$url, $second = 30, $aHeader = array())    {


        $ch = curl_init();
        $params[CURLOPT_URL] = $url;    //请求url地址
        $params[CURLOPT_HEADER] = false; //是否返回响应头信息
        $params[CURLOPT_RETURNTRANSFER] = true; //是否将结果返回
        $params[CURLOPT_FOLLOWLOCATION] = true; //是否重定向
        $params[CURLOPT_POST] = true;
        $params[CURLOPT_POSTFIELDS] = $xml;
        $params[CURLOPT_SSL_VERIFYPEER] = false;
        $params[CURLOPT_SSL_VERIFYHOST] = false;
        //以下是证书相关代码

        $params[CURLOPT_SSLKEYTYPE] = 'PEM';
        $params[CURLOPT_SSLKEY] = env('CERT_PATH').'apiclient_key.pem';
        $params[CURLOPT_SSLCERTTYPE] = 'PEM';
        $params[CURLOPT_SSLCERT] = env('CERT_PATH'). 'apiclient_cert.pem';

        curl_setopt_array($ch, $params); //传入curl参数
        $content = curl_exec($ch); //执行
        return $content;





    }
}
