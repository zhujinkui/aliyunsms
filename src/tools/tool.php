<?php
/**
 * 生成随机字符串
 * @param int       $length  要生成的随机字符串长度
 * @param string    $type    随机码类型：0，数字+大写字母；1，数字；2，小写字母；3，大写字母；4，特殊字符；-1，数字+大小写字母+特殊字符
 * @return string
 */
if (!function_exists('randCode')) {
    function randCode($length = 6, $type = 1) {
        $arr = array(1 => "0123456789", 2 => "abcdefghijklmnopqrstuvwxyz", 3 => "ABCDEFGHIJKLMNOPQRSTUVWXYZ", 4 => "~@#$%^&*(){}[]|");
        $code='';

        if ($type == 0) {
            array_pop($arr);
            $string = implode("", $arr);
        } else if ($type == "-1") {
            $string = implode("", $arr);
        } else {
            $string = $arr[$type];
        }

        $count = strlen($string) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str[$i] = $string[mt_rand(0, $count)];
            $code .= $str[$i];
        }
        return $code;
    }
}

/**
 * [object_to_array 对象转数组]
 * @param  [type] $obj [对象]
 */
if (!function_exists('object_to_array')) {
    function object_to_array($obj) {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)object_to_array($v);
            }
        }
        return $obj;
    }
}


