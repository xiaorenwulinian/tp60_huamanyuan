<?php

namespace app\controller\test;




use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class Common extends TestBase
{
    public function testValidate()
    {

    }

    public function test() {
      // 192.168.31.149
        $this->elasticSearch();
    }

    // 搜索
    public function elasticSearch()
    {
        $configs = [
            'hosts' => 'http://127.0.0.1:9200'
        ];
        $api = ClientBuilder::create()->setHosts($configs)->build();
        $elastic = new Client();
        $index['index'] = 'huamanyuan'; //索引名称
        $index['type'] = 'goods'; //类型名称
        $index['body']['query']['match']['is_pormote'] = '1';
        $index['size'] = 5;
        $index['from'] = 1;
        $ret = $elastic->search($index);
        dd($ret);
    }


}
