<?php

namespace app\controller\test;




use app\common\tools\UploadTool;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use think\facade\Request;

class Upload extends TestBase
{
    public function testValidate()
    {

    }


    public function test() {

        $word = "张";
        $arr = [
            2 => 'abc张三a',
            5 => '张b哎c张四a',
            6 => 'abc李三a',
        ];
        $new = [];
        foreach ($arr as $k =>$v) {
            if (strstr($v, $word)) {
                $new[$k] = $v;
            }
        }
        dump($new);
        return 1;
//        $ret =  $this->upload();
        $ret =  $this->isExists();
//        $ret =  $this->delete();
        return $ret;
    }

    public function upload()
    {
        $request = Request::instance();

        $file = $request->file('common_file');
        $ret = UploadTool::getInstance()->uploadFile($file,'backend/img');
        return success_response($ret);
    }

    public function isExists()
    {
        /*
         {
    "code": 0,
    "msg": "success",
    "timestamp": 1584498008,
    "payload": {
        "originalName": "简历 2.docx",
        "ossRelativePath": "backend/img/f8d4558112e6bc8979b32f9fb3bee9d6.docx",
        "ossAbsolutePath": "http://pdt-beidiao.oss-cn-hangzhou.aliyuncs.com/backend/img/f8d4558112e6bc8979b32f9fb3bee9d6.docx?OSSAccessKeyId=LTAI4FwdbShVJt9rKC2WuJ1p&Expires=1584501608&Signature=e7bqdZ%2BfwATiC9mOv6lMMM3UKw0%3D"
    }
}
         */
        $filename = "backend/img/f8d4558112e6bc8979b32f9fb3bee9d6.docx";
        $upload = UploadTool::getInstance();
        if ($upload->fileExist($filename)) {
            return 1;
        }
        return 2;
    }

    public function delete()
    {
        $filename = "backend/img/f8d4558112e6bc8979b32f9fb3bee9d6.docx";
        $upload = UploadTool::getInstance();
        $ret = $upload->deleteFile($filename);
        return $ret === true ? '删除成功' : 'error';
    }




}
