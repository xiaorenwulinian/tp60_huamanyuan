<?php
// 应用公共文件

if (!function_exists('success_response')) {
    /**
     * 成功返回json
     * @param array $data
     * @param string $message
     * @param int $code
     * @return \think\response\Json
     */
    function success_response($data = [], $message = 'success', $code = 0)
    {
       $ret = [
           'code'      => $code,
           'msg'       => $message,
           'timestamp' => time(),
           'payload'   => $data
       ];
       $header = [];
        return json($ret, 200, $header);
    }
}

if (!function_exists('failed_response')) {
    /**
     * 失败返回json
     * @param array $data
     * @param string $message
     * @param int $code
     * @return \think\response\Json
     */
    function failed_response($message = '请求失败', $code = 1)
    {
        $ret = [
            'code'      => $code,
            'msg'       => $message,
            'timestamp' => time(),
            'payload'   => []
        ];
        $header = [];
        return json($ret, 200, $header);
    }
}

if (!function_exists('page_size_select')) {
    /**
     * 生成页码跳转
     * @param int $page_size 每页显示条数
     * @return string
     */
    function page_size_select($page_size = 0){
        $str  = '<select class="form-control page_size_select">';
        $all_page  = [
           1, 2,5,10,20,50,100
        ];
        foreach ($all_page as $cur_page) {
            $has_selected = $page_size == $cur_page ? "selected='selected'" : '';
            $str .= "<option value='{$cur_page}' {$has_selected}>{$cur_page}条/页</option>";
        }
        $str .= '</select>';
        return $str;
    }
}

if (!function_exists('show_image')) {
    /**
     * 图片展示
     * @param string $url
     * @param string $width
     * @param string $height
     * @param string $alt
     * @return string
     */
    function show_image($url = '', $width = '', $height ='' , $alt='' ) {
        if (empty($url)) {
            $url = "/favicon.ico";
        } else {
            $url = '/uploads/' . $url;
        }
        if (!empty($width)) {
            $width = "width = '{$width}'";
        }

        if (!empty($width)) {
            $height = "height = '{$height}'";
        }
        if (empty($alt)) {
            $alt  = '图片加载中';
        }
        return "<img src='{$url}' $width $height alt='{$alt}' />";
    }

}

if (!function_exists('is_date_format')) {
    function is_date_format($date)
    {
        $ret = strtotime($date);

        return $ret !== FALSE && $ret != -1;
    }
}

if (!function_exists('ids_transfer_names')) {
    /**
     * ids 抓化成名称， 如 1，2 转化成， a,b
     * @param $data
     * @param $ids
     * @return string
     */
    function ids_transfer_names($data, $ids)
    {
        $arr = [];
        if (!empty($ids)) {
            $arr = explode(',', $ids);
        }
        $retData = [];
        foreach ($arr as $v) {
            $retData[] = $data[$v] ?? '';
        }
        $names = implode(',',$retData);
        return $names;
    }
}


if (!function_exists('is_image_extension')) {

    /*
     * 是否是图片格式
     */
    function is_image_extension($file)
    {
        if (empty($file)) {
            return false;
        }
        $imgExtensionArr = [
            'jpg',
            'jpeg',
            'png',
            'gif',
            'svg',
            'bmp',
            'tif',

        ];
        list($filename, $ext) = explode('.', $file);
        $ext = strtolower($ext);
        if (in_array($ext, $imgExtensionArr)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('date_gap_year')) {
    /*
     * 两个日期差（year）
     */
    function date_gap_year($begin, $end)
    {
        if (empty($begin) || empty($end)) {
            return 0;
        }
        $gap = strtotime($begin) - strtotime($end);
        $gapYear = $gap / 3600 / 24 /365;
        return abs(number_format($gapYear, 2));
    }

}

if (!function_exists('date_y_m_d')) {
    /**
     * @param $data
     * @return float|int
     */
    function date_y_m_d($data)
    {
        if (empty($data)) {
            return $data;
        }
        if (!is_int($data)) {
            $data =  strtotime($data);
        }
        return date('Y-m-d', $data);
    }

}



