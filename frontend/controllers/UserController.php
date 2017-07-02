<?php

namespace frontend\controllers;

use frontend\models\Member;
use yii\filters\AccessControl;

header('content:text/html; charset=utf-8');
class UserController extends \yii\web\Controller
{
    public $layout = 'login';//使用login布局文件

    //用户注册功能register
    public function actionRegister(){
        $model = new Member(['scenario'=>Member::SCENARIO_REG]);
        if($model->load(\Yii::$app->request->post()) ){
            if($model->reg()){ //验证成功并保存到数据库
                echo '<script>confirm("注册成功,请返回登录");location.href="login.html";</script>';
                \Yii::$app->session->setFlash('success','注册成功');
                return $this->redirect(['login','model'=>$model]);  //跳转页面
            }
        }
        return $this->render('register',['model'=>$model]);//视图页面
    }



    //用户登录功能
    public function actionLogin(){
        $model = new Member(['scenario'=>Member::SCENARIO_LOGIN]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->login()){//验证登录 信息并登录
                \Yii::$app->session->setFlash('success','登录成功');
                return $this->redirect(['goods/order']);
            }
        }
        return $this->render('login',['model'=>$model]);
    }


    //用户注销
    public function actionLogout(){
        \Yii::$app->user->logout();
        return $this->redirect(['user/login']);
    }


    //用户注册短信发送
    public function actionSendMsg(){
        $tel = \Yii::$app->request->post('tel');
        if(!preg_match('/^1[34578]\d{9}$/',$tel)){
            echo '手机号格式不正确';exit;
        }
        //发送短信
        $code = rand(1000,9999);
        $result =  \Yii::$app->sms->setNum(13678029077)->setPara(['code'=>$code])->send();
        if($result){
            //保存当前验证码 session  mysql  redis  不能保存到cookie
            \Yii::$app->cache->set($tel,$code,600);
            echo 'success';
        }else{
            echo '发送失败';
        }
    }


    //用户中心
    public function actionUser(){
        $this->layout = 'goods';
        return $this->render('user');
    }

    //发送邮件
    public function actionSendEmail(){
      /*  Yii::$app->mailer->compose([//可以指定text。html
            'html' => 'contact-html',
            'text' => 'contact-text',
        ]);
        */
        $result = \Yii::$app->mailer->compose()//此处可以传递视图文件
            ->setFrom('463873431@qq.com')//由谁发出的邮件
            ->setTo('463873431@qq.com')//发给谁
            ->setSubject('Message subject')//邮件主题
            ->setTextBody('哈哈')//邮件text内容
            ->setHtmlBody('<em>我的邮件来了，请不要回复</em>')//邮件html内容
            ->send();
        var_dump($result);
    }


    //验证码
    public function actions(){
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 4,//验证码最小长度
                'maxLength'=>4,//最大长度
            ],
        ];
    }



    public function behaviors()
    {
        return [
            'acf'=>[
                'class'=>AccessControl::className(),
                'rules'=>[
                    [
                        'allow'=>true,//是否允许
                        'actions'=>['login','register','captcha','send-msg'],//指定操作
                        'roles'=>['?'],//？表示未认证用户
                    ],
                    [
                        'allow'=>true,//是否允许
                        'actions'=>['login','register','captcha','logout','send-email','send-msg','user'],//指定操作
                        'roles'=>['@'],
                    ],
                ]
            ],
        ];
    }


}
