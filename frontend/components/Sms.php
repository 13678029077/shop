<?php
namespace  frontend\components;
//用户注册发短信验证
use yii\base\Component;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;

class Sms extends Component
{

    public $app_key;
    public $app_secret;
    public $sign_name;
    public $temple_code;
    public $_num;//手机号
    public $_para=[];//短息内容

    //设置手机号码
    public function setNum($num){
        $this->_num = $num;
        return $this;
    }
    //设置短信内容
    public function setPara($para){
         $this->_para=$para;
        return $this;
    }
    //设置签名
    public function setSign($sign){
        $this->sign_name = $sign;
        return $this;
    }

    //设置短信模板
    public function setTemple($temple){
        $this->temple_code = $temple;
        return $this;
    }


    //发送短信
    public function send(){
        $client = new Client(new App(['app_key'=>$this->app_key,'app_secret'=>$this->app_secret]));
        $req = new AlibabaAliqinFcSmsNumSend;
        //配置
        $req->setRecNum($this->_num)
            ->setSmsParam($this->_para)
            ->setSmsFreeSignName($this->sign_name)
            ->setSmsTemplateCode($this->temple_code);

        return $client->execute($req);
    }



}