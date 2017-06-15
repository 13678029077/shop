<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170614_023205_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username'=>$this->string(100)->comment('用户名'),
            'auth_key'=>$this->string(100)->comment('用户秘钥'),
            'password_hash'=>$this->string(100)->comment('密码'),
            'password_reset_token'=>$this->string(200)->comment('密码修改token'),
            'email'=>$this->string(100)->comment('邮箱'),
            'status'=>$this->integer(1)->comment('状态'),
            'create_at'=>$this->integer(12)->comment('注册时间'),
            'updated_at'=>$this->integer(12)->comment('修改时间'),
            'last_login_time'=>$this->integer(12)->comment('最后登录时间'),
            'last_login_ip'=>$this->string(100)->comment('最后登录IP'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
