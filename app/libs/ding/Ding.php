<?php

namespace app\libs\ding;

/**
 * 钉钉群预警
 * Class Ding
 * @package app\libs\ding
 */

class Ding
{
    const DING_TALK_DOMAIN  = 'https://oapi.dingtalk.com/';
    const DING_TALK_URL     = 'robot/send?access_token=';
    const DEVELOP_TOKEN_KEY = ''; // 测试环境
    const PRODUCTION_TOKEN_KEY = ''; // 正式环境



    /*
     * 钉钉通知
     * Author liChunlong
     */
    public static function sendText($env = 'local', $message = '')
    {

        if ($env == 'production') {
            $tokenkey = env('ding.ding_token_key_pubic');
        } else {
            $tokenkey = env('ding.ding_token_key_local');
        }
        $webhook = self::DING_TALK_DOMAIN . self::DING_TALK_URL . $tokenkey;
        $data = array (
            'msgtype' => 'text',
            'text' => array ('content' => $message)
        );
        $data_string = json_encode($data);
        $result = static::request_by_curl($webhook, $data_string);
        if ( isset($result['errcode']) && $result['errcode'] != 0) {
            Log::debug('ding_ding_text_message_failure', ['result' => $result]);
        }
        return ;
    }

    public static function request_by_curl($remote_server, $post_string) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // 线下环境不用开启curl证书验证, 未调通情况可尝试添加该代码
        // curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
