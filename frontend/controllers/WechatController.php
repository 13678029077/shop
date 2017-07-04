<?php
namespace frontend\controllers;

use frontend\models\Member;
use frontend\models\Order;
use Overtrue\Wechat\Messages\News;
use yii\helpers\Url;
use yii\web\Controller;
use EasyWeChat\Foundation\Application;


class WechatController extends Controller{
    //微信开发依赖的插件  easyWechat
    //关闭csrf验证
    public $enableCsrfValidation = false;

    public function actionIndex(){
        // 使用配置来初始化一个项目。
        $app = new Application(\Yii::$app->params['wechat']);   //option为\Yii::$app->params['wechat']
        // 处理自动回复文本
        $app->server->setMessageHandler(function ($message) {
            // $message->FromUserName // 用户的 openid
            // $message->MsgType // 消息类型：event, text....
            //return "您好！欢迎关注我!";
            switch($message->MsgType){
                case 'text':
                    switch($message->Content){
                        case '成都';
                            $xml = simplexml_load_file('http://flash.weather.com.cn/wmaps/xml/sichuan.xml');
                            foreach($xml as $city){
                                if($city['cityname']=='成都'){
                                    $weather = $city['stateDetailed'];
                                    break;
                                }
                            }
                            return '成都天气为：'.$weather;
                            break;
                        case '注册':
                            $url = Url::to(['user/register'],true);//返回完整的域名HTTP://
                            return '点击注册'.$url;
                            break;
                        case '活动':

                            //回复图文消息 单图文信息
                            $news1 = new News([
                                'title'       => '十一大减价',
                                'description' => '图文信息的描述...',
                                'url'         => 'http://www.baidu.com',//点击的跳转地址
                                'image'       => 'http://pic27.nipic.com/20130131/1773545_150401640000_2.jpg',//图片地址
                            ]);
                            $news2 = new News([
                                'title'       => '十一大减价',
                                'description' => '图文信息的描述...',
                                'url'         => 'http://www.baidu.com',//点击的跳转地址
                                'image'       => 'http://pic27.nipic.com/20130131/1773545_150401640000_2.jpg',
                            ]);
                            $news3 = new News([
                                'title'       => '十一大减价',
                                'description' => '图文信息的描述...',
                                'url'         => 'http://www.baidu.com',//点击的跳转地址
                                'image'       => 'http://pic27.nipic.com/20130131/1773545_150401640000_2.jpg',
                            ]);
                            return [$news1,$news2,$news3];//返回活动
                        break;
                    }
                    return '收到你的消息:'.$message->Content;
                    break;

                case 'event'://事件
                    //事件的类型   $message->Event
                   // $message->Event;
                    //事件的key值  $message->EventKey
                    if($message->Event == 'CLICK'){//菜单点击事件
                        if($message->EventKey == 'zuixinhondong'){//用户输入zuixinhondong,返回活动图文信息
                            $news1 = new News([
                                'title'       => '十一大减价',
                                'description' => '图文信息的描述...',
                                'url'         => 'http://www.baidu.com',
                                'image'       => 'http://pic27.nipic.com/20130131/1773545_150401640000_2.jpg',
                            ]);
                            $news2 = new News([
                                'title'       => '流量5折',
                                'description' => '流量5折...',
                                'url'         => 'http://www.qq.com',
                                'image'       => 'http://pic74.nipic.com/file/20150810/10115763_233338370780_2.jpg',
                            ]);
                            $news3 = new News([
                                'title'       => '无限流量套餐',
                                'description' => '流量5折...',
                                'url'         => 'http://www.jd.com',
                                'image'       => 'http://pic3.16pic.com/00/37/06/16pic_3706700_b.jpg',
                            ]);
                            return [$news1,$news2,$news3];
                        }

                    }
                    return '接受到了'.$message->Event.'事件,key:'.$message->EventKey;
                    break;
                }
        });


        $response = $app->server->serve();
        // 将响应输出
        $response->send(); // Laravel 里请使用：return $response;
    }


    //设置菜单
    public function actionSetMenu(){
        $app = new Application(\Yii::$app->params['wechat']);
        $menu = $app->menu;
        //菜单选项
        $button = [
            [
                "type" => "click",
                "name" => "最新活动",
                "key"  => "zuixinhondong"
            ],
            [
                "name" => "菜单",
                "sub_button" => [
                    [//菜单选项
                        "type" => "view",
                        "name" => "个人中心",
                        "url"  => Url::to(['wechat/user'],true)
                    ],
                    [
                        "type" => "view",
                        "name" => "我的订单",
                        "url"  => Url::to(['wechat/order'],true)
                    ],
                    [
                        "type" => "view",
                        "name" => "绑定账户",
                        "url" => Url::to(['wechat/login'],true)
                    ]
                ]
            ]
        ];

        $menu->add($button);//添加button
        //获取已设置的菜单（查询菜单）
        $menus = $menu->all();
        var_dump($menus);
    }


    public function actionOrder(){
        $openid = \Yii::$app->session->get('openid');
        if($openid == null){
            //获取用户的基本信息（openid），需要通过微信网页授权
            //设置session返回跳转页
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);//uniqueid获得当前方法名
            $app = new Application(\Yii::$app->params['wechat']);
            //发起网页授权
            $response = $app->oauth->scopes(['snsapi_base'])->redirect();
            $response->send();
            //已经获得openid
        }
        var_dump($openid);
        //通过openid获取账号,绑定账号
        $member = Member::findOne(['openid'=>$openid]);
        if($member){
            //该openid没有绑定任何账户，引导用户登录绑定
            return $this->redirect(['wechat/login']);
        }else{
            //绑定了账户，直接获取订单
            $orders = Order::findAll(['id'=>$member->id]);
            return $orders;
        }
    }

    //个人中心,登录并授权
    public function actionUser(){
        $openid = \Yii::$app->session->get('openid');//SESSION中的openid
        if($openid == null){
            //获取用户的基本信息（openid），需要通过微信网页授权
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);
            $app = new Application(\Yii::$app->params['wechat']);
            //发起网页授权
            $response = $app->oauth->scopes(['snsapi_base'])
                ->redirect();
            $response->send();
        }
        var_dump($openid);
    }

    //授权回调页，获得授权后跳回请求页
    public function actionCallBack(){
        $app = new Application(\Yii::$app->params['wechat']);
        //获取已授权用户
        $user = $user = $app->oauth->user();
        // $user 可以用的方法:
        // $user->getId();  // 对应微信的 OPENID
        // $user->getNickname(); // 对应微信的 nickname
        // $user->getName(); // 对应微信的 nickname
        // $user->getAvatar(); // 头像网址
        // $user->getOriginal(); // 原始API返回的结果
        // $user->getToken(); // access_token， 比如用于地址共享时使用

        //将openid放入session
        \Yii::$app->session->set('openid',$user->getId());
        return $this->redirect(\Yii::$app->session->get('redirect'));//跳转回原来的页面
    }

    //绑定oopenid与账户,登录后绑定
    public function actionLogin(){
        $openid = \Yii::$app->session->get('openid');
        if($openid == null){
            //获取用户的基本信息（openid），需要通过微信网页授权
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);
            $app = new Application(\Yii::$app->params['wechat']);
            //发起网页授权
            $response = $app->oauth->scopes(['snsapi_base'])->redirect();
            $response->send();
        }

        //让用户登录，如果登录成功，将openid写入当前登录账户
        $request = \Yii::$app->request;
        if($request->isPost){
            //登录
            $user = Member::findOne(['username'=>$request->post('username')]);
            if($user && \Yii::$app->security->validatePassword($request->post('password'),$user->password_hash)){
                \Yii::$app->user->login($user);
                //如果登录成功，将openid写入当前登录账户
                Member::updateAll(['openid'=>$openid],'id='.$user->id);
                if(\Yii::$app->session->get('redirect')){
                    return $this->redirect([\Yii::$app->session->get('redirect')]);
                }
                echo '绑定成功';
            }else{
                echo '绑定失败';
            }
        }
        return $this->renderPartial('login');//显示登录页面
    }




}


