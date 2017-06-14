<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_intro`.
 */
class m170612_033526_create_goods_intro_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_intro', [
            'id' => $this->primaryKey(),
            'goods_id'=>$this->integer(10)->comment('商品id'),
            'content'=>$this->text()->comment('商品描述'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_intro');
    }
}
