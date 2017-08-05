<?php
/**
 * Created by PhpStorm.
 * User: 22121
 * Date: 2017/8/2
 * Time: 19:04
 */
namespace frontend\components;

use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Core\Config;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Core\Profile\DefaultProfile;
use yii\base\Component;
use yii\helpers\Json;

class AliyunSms extends Component
{
        //此处需要替换成自己的AK信息
    public $accessKeyId;//参考本文档步骤2
    public $accessKeySecret;//参考本文档步骤2
    public $signName;//短信签名
    public $templateCode;//短信模板Code
        //短信API产品名（短信产品名固定，无需修改）
    public $product = "Dysmsapi";
        //短信API产品域名（接口地址固定，无需修改）
    public $domain = "dysmsapi.aliyuncs.com";
        //暂时不支持多Region（目前仅支持cn-hangzhou请勿修改）
    public $region = "cn-hangzhou";

    private $_acsClient;
    private $_request;
    public function init()
    {//DefaultProfile
        parent::init(); // TODO: Change the autogenerated stub
        // 加载区域结点配置
        Config::load();
        //初始化访问的acsCleint
        $profile =DefaultProfile::getProfile($this->region, $this->accessKeyId,$this->accessKeySecret);
        DefaultProfile::addEndpoint($this->region, $this->region, $this->product, $this->domain);
        $this->_acsClient= new DefaultAcsClient($profile);
        $this->_request = new SendSmsRequest();
    }

    public function setPhoneNumbers($value)
    {
        $this->_request->setPhoneNumbers($value);
        return $this;
    }
    public function setSignName($value)
    {
        $this->signName($value);
        return $this;
    }
    public function setTemplateCode($value)
    {
        $this->templateCode($value);
        return $this;
    }
    public function setTemplateParam($data)
    {
        $josn=Json::encode($data);
        $this->_request->setTemplateParam($josn);
        return $this;
    }
    public function send()
    {
        $this->_request->setSignName($this->signName);
        $this->_request->setTemplateCode($this->templateCode);
        return $this->_acsClient->getAcsResponse($this->_request);
    }
}