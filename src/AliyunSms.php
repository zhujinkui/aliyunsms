<?php
// 短信配置文件
// +----------------------------------------------------------------------
// | PHP version 5.3+
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.myzy.com.cn, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 阶级娃儿 <262877348@qq.com> 群：304104682
// +----------------------------------------------------------------------
namespace think;
use think\Config;
use think\SignatureHelper;

class AliyunSms
{
	/**
	 * @var array 配置信息
	 */
	protected $configs = [
		// AppKey
		'access_key'    => 'LTAIwznWo7Q8pUFC',
		// Secret
		'access_secret' => 'UiI8Hih4OpWAFXTFoWzeifzHzUyx9q',
		// 签名
		'sign_name'     => '铭扬致远'
	];

	/**
	 * 构造函数
	 * @access protected
	 */
	public function __construct()
	{
	    // 判断是否有设置配置项.此配置项为数组，做一个兼容
	    if (Config::has('alisms')) {
	        // 合并,覆盖配置
	        $this->configs = array_merge($this->configs, Config::get('alisms'));
	    } else {
	    	$this->configs;
	    }

	    //$this->configs;
	}

	public function sendSms($mobile = '', $sms_template = '', $sms_param = '')
	{
		if (empty($mobile) || empty($sms_template) || empty($sms_param)) {
			return false;
		}

		$params                      = [];

		// 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
		$accessKeyId                 = $this->configs['access_key'];
		$accessKeySecret             = $this->configs['access_secret'];

		// 必填: 短信接收号码
		$params["PhoneNumbers"]      = $mobile;
		// 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
		$params["SignName"]          = $this->configs['sign_name'];
		// 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
		$params["TemplateCode"]      = $sms_template;
		// 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
		$params['TemplateParam']     = $sms_param;
		// 可选: 设置发送短信流水号
		//$params['OutId']           = "12345";
		// 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
		//$params['SmsUpExtendCode'] = "1234567";

		// 需用户填写部分结束, 以下代码若无必要无需更改
		if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
		    $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
		}

		// 初始化SignatureHelper实例用于设置参数，签名以及发送请求
		$helper = new SignatureHelper();

		// 此处可能会抛出异常，注意catch
		$content = $helper->request(
		    $accessKeyId,
		    $accessKeySecret,
		    "dysmsapi.aliyuncs.com",
		    array_merge($params, [
		        "RegionId" => "cn-hangzhou",
		        "Action" => "SendSms",
		        "Version" => "2017-05-25",
		    ])
		    // fixme 选填: 启用https
		    // ,true
		);

		return $content;
	}
}
