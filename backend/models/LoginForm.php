<?php
namespace  backend\models;
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/6/15
 * Time: 14:29
 */

class LoginForm extends \yii\base\Model{

    public $username;
    public $password;
    public $rememberme;

    public  function rules(){
            return [
                [['username','password'],'required'],
                ['rememberme','boolean']
            ];
    }


    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'rememberme'=>'记住我'
        ];
    }



    //用户登录
    public function login(){
        //1.更具用户名查找用户
        $admin = User::findOne(['username'=>$this->username]);
        if($admin){
            //2.有用户，验证密码
            if(\Yii::$app->security->validatePassword($this->password,$admin->password_hash)){
              //3.登录,自动登录
                if($this->rememberme){
                    \Yii::$app->user->login($admin,3600*7*24);
                }else{
                    \Yii::$app->user->login($admin);
                }
                return true;
            }else{
                $this->addError('password','密码不正确');
            }
        }else{
            $this->addError('username','用户名不存在');
        }
    }

}