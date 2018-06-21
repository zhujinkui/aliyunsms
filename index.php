<?php
// 短信配置文件
// +----------------------------------------------------------------------
// | PHP version 5.3+
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.myzy.com.cn, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 阶级娃儿 <262877348@qq.com> 群：304104682
// +----------------------------------------------------------------------

header("Content-Type: Text/Html;Charset=UTF-8");
require "./vendor/autoload.php";

$obj = new think\AliyunSms();

$smsParam = [
	'yzm' => randCode(6)
];

$sendStatus = $obj->sendSms('15534205051', 'SMS_125805029', $smsParam);

if (is_object($sendStatus)) {
    $sendStatus = object_to_array($sendStatus);
}

if ($sendStatus == false) {
	echo '缺少参数';
} elseif ($sendStatus['Code'] === "OK") {
	echo '发送成功！';
	print_r($sendStatus);
} else {
	echo '发送失败！';
	print_r($sendStatus);
}

