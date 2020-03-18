<?php

namespace app\controller\miniprogram;


use app\common\tools\LclJwtTool;
use app\logic\WeChatLogic;
use app\model\Wechat;
use GuzzleHttp\Client;
use think\App;

class Login extends MiniProgramBase
{

    public function __construct(App $app)
    {
       parent::__construct($app);
    }
   
    public function login1()
    {
        $user = [
            'id' => '3'
        ];
        $token = LclJwtTool::getInstance()->generateTokenMiniProgram($user);
        $ret = [
            'userInfo'  => $user,
            'token'     => $token
        ];
        return success_response($ret);
    }


    /**
     * 获取openid
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function login()
    {
        $js_code = input('code');
        $ret = WeChatLogic::getInstance()->jscode2Session($js_code);
//        if ($ret['errcode'] !== 0) {
//           return failed_response($ret['errmsg']);
//        }
        $wechat = Wechat::where(['x_openid' => $ret['openid']])->find();
        $status = 0;
        if (empty($wechat)) {
           $wechat =  Wechat::create(['x_openid' => $ret['openid']]);
        }
        $wechat->xcx_session_key = $ret['session_key'];
        $wechat->save();
        $wxInfo = $wechat->toArray();
        if (empty($wxInfo['user_id'])) {
            $status = 418; // 未填充用户表信息和号码
        }
        if (empty($wxInfo['wx_nickname'])) {
            $status = 417; // 未填充微信信息
        }

        $token = LclJwtTool::getInstance()->generateTokenMiniProgram($wxInfo);
        $result = [
            'status'        => $status,
            'authorization' => $token,
            'openid'        => $ret['openid'],
            'session_key'   => $ret['session_key'],
        ];
        return success_response($result);
    }

    public function fillWeChatInfo()
    {
        $wechat = LclJwtTool::getInstance()->getWeChatInfoMiniProgram();
        $wechatId = $wechat['id'];
        $sessionKey = $wechat['xcx_session_key'];
        $encryptedData = input('encryptedData');
        $iv = input('iv');
        $resData = WeChatLogic::getInstance()->decryptData($encryptedData, $iv, $sessionKey);
        if ($resData['code'] !== 0) {
          return failed_response($resData['code']);
        }
        $data = json_decode($resData['data'], true);
        $wx_data = $data;
        Wechat::where('id', $wechatId)->update([
            'wx_nickname' => $wx_data['nickName'],
            'wx_country' => $wx_data['country'],
            'wx_province' => $wx_data['province'],
            'wx_city' => $wx_data['city'],
            'wx_sex' => $wx_data['gender'],
            'wx_headimgurl' => $wx_data['avatarUrl'],
        ]);
        return success_response();
    }


}
