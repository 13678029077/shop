<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m170620_074153_create_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(30)->comment('收货人'),
            'province'=>$this->string()->comment('省份'),
            'city'=>$this->string()->comment('城市'),
            'area'=>$this->string()->comment('区县'),
            'detail'=>$this->string()->comment('详细地址'),
            'tel'=>$this->char(11)->comment('手机号码'),
            'status'=>$this->integer(1)->comment('设为默认地址'),
            'user_id'=>$this->integer()->comment('所属用户ID'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('address');
    }
}
