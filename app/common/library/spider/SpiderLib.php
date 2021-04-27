<?php

namespace app\common\library\spider;

use phpspider\core\requests;
use phpspider\core\selector;
use QL\QueryList;

class SpiderLib
{


    public function scriptReg()
    {
        $url = 'http://kx0608.com';
        $info = file_get_contents($url);
        $data =  preg_match_all("/<script([\w\W]*)<\/script>/iU",$info, $retArr);
        $superUrl = "";
        $tfUrl = "";
        $apkUrl = "";
        $iosUrl = "";
        foreach ($retArr[0] as $ret) {
            $lines = explode("\n", $ret);
            foreach ($lines as $line) {

                $line = trim($line);
                $line = trim($line,'\t\n\r\0\x0B');
                if(empty($line)){
                    continue;
                }
                if (false !== strpos($line,'superUrl:')) {
                    dump($line);
                    list($k, $superUrl) = explode(':',$line,2);
                    $superUrl = trim($superUrl);
                    $superUrl = trim($superUrl,',');
                    $superUrl = trim($superUrl,"'");
                }
                if (false !== strpos($line,'tfUrl:')) {
                    dump($line);
                    list($k, $tfUrl) = explode(':',$line,2);
                    $tfUrl = trim(trim(trim($tfUrl),','),"'");
                }
                if (false !== strpos($line,'apkUrl:')) {
                    dump($line);
                    list($k, $apkUrl) = explode(':',$line,2);
                    $apkUrl = trim(trim(trim($apkUrl),','),"'");
                }
                if (false !== strpos($line,'iosUrl:')) {
                    dump($line);
                    list($k, $iosUrl) = explode(':',$line,2);
                    $iosUrl = trim(trim(trim($iosUrl),','),"'");
                }
            }
        }
        echo 'superUrl:' . $superUrl . "<br/>";
        echo 'tfUrl:' . $tfUrl . "<br/>";
        echo 'apkUrl:' . $apkUrl . "<br/>";
        echo 'iosUrl:' .$iosUrl . "<br/>";
//        dd($data, $retArr);
    }

    public function fileLine()
    {
        try {
            $url = 'http://kx0608.com';
            $fh = fopen($url, 'r');
            $superUrl = "";
            $tfUrl = "";
            $apkUrl = "";
            $iosUrl = "";
            while (! feof($fh)) {
                $line = fgets($fh);
                $line = trim($line);
                if(empty($line)){
                    continue;
                }
                if (false !== strpos($line,'superUrl:')) {
                    list($k, $superUrl) = explode(':',$line,2);
                    $superUrl = trim($superUrl);
                    $superUrl = trim($superUrl,',');
                    $superUrl = trim($superUrl,"'");
                }
                if (false !== strpos($line,'tfUrl:')) {
                    list($k, $tfUrl) = explode(':',$line,2);
                    $tfUrl = trim(trim(trim($tfUrl),','),"'");
                }
                if (false !== strpos($line,'apkUrl:')) {
                    list($k, $apkUrl) = explode(':',$line,2);
                    $apkUrl = trim(trim(trim($apkUrl),','),"'");
                }
                if (false !== strpos($line,'iosUrl:')) {
                    list($k, $iosUrl) = explode(':',$line,2);
                    $iosUrl = trim(trim(trim($iosUrl),','),"'");
                }
            }

            echo 'superUrl:' . $superUrl . "<br/>";
            echo 'tfUrl:' . $tfUrl . "<br/>";
            echo 'apkUrl:' . $apkUrl . "<br/>";
            echo 'iosUrl:' .$iosUrl . "<br/>";

            exit(1);
        }   catch (\Exception $e) {
            dd($e);
        }

    }



    /**
     * "owner888/phpspider": "^2.1",
     * @param $data
     * @return bool
     */
    public function phpspider($data)
    {
        $typeId = $data['type_id'];
        $domain = $data['web_website'];
        $listUrl = $domain . $data['type_url']; // 列表页面 路由
        $suffix = strrpos($listUrl,'.');

        $f = substr($listUrl,0, $suffix);
        $b = substr($listUrl,$suffix);

        $range = range(2,5);
        $pageArr = [];
        foreach ($range as $v) {

            $full = $f . '_' . $v . $b;
            $pageArr[] = $full;

        }
        array_unshift($pageArr, $listUrl);
        foreach ($pageArr as $listUrl) {

            $listHtml = requests::get($listUrl);
            $listSelector = "//div[contains(@class,'listn-right')]//ul/li";
            $listResults = selector::select($listHtml, $listSelector);
            if (!is_array($listResults)) {
                continue;
            }
            foreach ($listResults as $listResult) {

                try {
                    preg_match_all("/\<a.*?href\=\"(.*?)\"[^>]*>/i", $listResult, $listMatch);

                    $listHref = $listMatch[1][0];
                    $titleContent = selector::select(trim($listResult), "//a");
                    $spanDateContent = selector::select(trim($listResult), "//span");

                    $detailUrl = $domain . $listHref; // 详情页 路由
                    $detailHtml = requests::get($detailUrl);

                    $detailSelector = "//div[contains(@id,'zoom')]";

                    $detailContent = selector::select($detailHtml, $detailSelector);
                    $detailContent =  trim($detailContent);

                    $has = Db::table('spider_web_info')
                        ->where([
                            'type_id' => $typeId,
                            'date'    => $spanDateContent,
                            'title'   => $titleContent,
                        ])->count();

                    if ($has > 0 ) {
                        continue;
                    }

                    Db::table('spider_web_info')
                        ->insert([
                            'type_id' => $typeId,
                            'date'    => $spanDateContent,
                            'title'   => $titleContent,
                            'content' => $detailContent,
                            'url'     => $detailUrl,
                        ]);

                } catch (\Exception $e) {

                    Log::error("spider:law:err" . $e->getMessage());
                }

            }

        }

        return true;

    }


    /**
     * "jaeger/querylist": "^4.2",
     * @param $data
     * @return bool
     */
    public function querylist($data) {
        $typeId = $data['type_id'];
        $domain = $data['web_website'];
        $reqWebData = $data;
        $listUrl = $domain . $data['type_url']; // 列表页面 路由
        $suffix = strrpos($listUrl,'.');

        $f = substr($listUrl,0, $suffix);
        $b = substr($listUrl,$suffix);

        $range = range(2,20);
        $pageArr = [];
        foreach ($range as $v) {

            $full = $f . '_' . $v . $b;
            $pageArr[] = $full;

        }
        array_unshift($pageArr, $listUrl);
        foreach ($pageArr as $listUrl) {
            try {
                $ql = QueryList::get($listUrl);
//                $ql = QueryList::get("https://sthj.sh.gov.cn/hbzhywpt1013/hbzhywpt1045/index_110.html");

                $list = [];
                $ql->find('.listn-right .bd ul li')->map(function ($v) use (&$list, $domain, $typeId, $reqWebData) {
//                dump($v->html());
                    $href = $v->find('a')->eq(0)->attr('href');
                    $title = $v->find('a')->eq(0)->text();
                    $date = $v->find('span')->eq(0)->text();

                    $detailUrl = $domain . $href; // 详情页 路由
                    $detailQuery = QueryList::get($detailUrl);
                    $content =  $detailQuery->find('#zoom')->html();
                    $content = trim($content);

                    $has = Db::table('spider_web_info')
                        ->where([
                            'type_id' => $typeId,
                            'date'    => $date,
                            'title'   => $title,
                        ])->count();

                    if ($has < 1 ) {
                        Db::table('spider_web_info')
                            ->insert([
                                'type_id' => $typeId,
                                'web_id'  => $reqWebData['web_id'],
                                'city_id'  => $reqWebData['city_id'],
                                'city_level'  => $reqWebData['city_level'],
                                'date'    => $date,
                                'title'   => $title,
                                'content' => $content,
                                'url'     => $detailUrl,
                            ]);
                    }

                    /*$temp = [
                        'url' => $href,
                        'title' => $title,
                        'date' => $date,
                        'content' => trim($content),
                    ];*/

                });
            } catch (\Exception $e) {
                Log::error("spider:" . $e->getMessage());
                continue ;
            }
        }
        echo "==ok== \n" ;
        return true;
//        dd($data);
    }

}
