<?php

namespace app\controller\test;




class Interview extends TestBase
{

    public function test() {

        return $this->getControllerAll();
        return $this->sort();
        return $this->method2();
    }

    public static $route = [];

    public function getControllerAll()
    {
        define("APPLICATION_PATH", dirname(dirname(dirname(__FILE__))));

        $controllerPath = APPLICATION_PATH . '/controller';
        $begin = microtime(true);
        $allFile = $this->getTree($controllerPath);
        foreach ($allFile as $file) {
            $classInfo = $this->loadFile($file);
            $classFullPath = '\\' . $classInfo['namespace'] . '\\' . $classInfo['classname'];
            $class =  new \ReflectionClass($classFullPath);
            dd($classFullPath, $class->getMethods());
        }
//        $classInfo =
        $end = microtime(true);
        $gap = bcsub($end, $begin, 4);
        dd($controllerPath, $allFile, $gap);
    }

    public function loadFile($file)
    {
        $content = file_get_contents($file);
        preg_match("/namespace\s(.*)/i" ,$content, $namespaceInfo);
        if (empty($namespaceInfo[1])) {
            throw new \Exception("not match php file!");
        }
        $namespace = str_replace([";"],'',$namespaceInfo[1]);
//        yield $namespace;
        $fileArr = explode('/', $file);
        $fileName = explode('.', end($fileArr))[0];
        $arr = [
            'namespace' => $namespace,
            'classname' => $fileName,
        ];
        return $arr;
    }


    /**
     * 获取当前文件下所有文件（递归）
     * @param $dir
     * @return array
     */
    private function getTree($dir)
    {
        $files = glob($dir . "/*");
        $arr = [];
        foreach ($files as $file) {
            if (is_dir($file)) {
                $arr = array_merge($arr, $this->getTree($file));
            } else {
                if (substr($file , -4) !== '.php') {
                    continue;
                }
                $arr[] = $file;
            }
        }
        return $arr;

    }

    public function loadCurController()
    {

    }

    public function getToken()
    {
        $file = dirname(__FILE__). "/TestBase.php";
        $content = file_get_contents($file);
        preg_match("/namespace\s(.*)/i", $content, $namespace);
        dd($content,$namespace, token_get_all($content));
    }

    public function sort()
    {
        $arr = [3,5,6,9,43,33,25,30,11,8];
        $new = $this->sortSelect($arr);
//        $new = $this->sortBubble($arr);
//        $new = $this->sortQuick($arr);
        dd($new);
    }


    /**
     * 选择排序
     * @param $arr
     * @return mixed
     */
    public function sortSelect($arr)
    {
        $len = count($arr);
        for ($i = 0; $i < $len; $i++) {
            $min = $i;
            for ($j = $i; $j < $len; $j++) {
                if ($arr[$j] < $arr[$min]) {
                    $min = $j;
                }
            }
            $temp  = $arr[$min];
            $arr[$min] = $arr[$i];
            $arr[$i] = $temp;
        }
        return $arr;

    }


    /**
     * 冒泡排序
     * @param $arr
     */
    public function sortBubble($arr)
    {
        $len = count($arr);
        if ($len <= 1) {
            return $arr;
        }
        for ($i = 1; $i < $len; $i++) {
            for ($j = 0; $j < $len - $i; $j++) {
                if ($arr[$j] > $arr[$j+1]) {
                    $temp      = $arr[$j];
                    $arr[$j]   = $arr[$j+1];
                    $arr[$j+1] = $temp;
                }
            }
        }
        return  $arr;
    }


    /**
     * 快速排序
     * @param $arr
     * @return array
     */
    public function sortQuick($arr)
    {
        $len = count($arr);
        if ($len <= 1) {
            return $arr;
        }
        $leftArr  = [];
        $rightArr = [];
        $first    = $arr[0];

        for ($i = 1; $i < $len ; $i++) {
            if ($arr[$i] > $first) {
                $rightArr[] = $arr[$i];
            } else {
                $leftArr[] = $arr[$i];
            }
        }

        $leftArr  = $this->sortQuick($leftArr);
        $rightArr = $this->sortQuick($rightArr);
        return  array_merge($leftArr, [$first], $rightArr);
    }



}
