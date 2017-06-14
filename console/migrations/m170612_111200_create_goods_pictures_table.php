<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_pictures`.
 */
class m170612_111200_create_goods_pictures_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_pictures', [
            'id' => $this->primaryKey(),
            'img'=>$this->string(255)->comment('商品图片'),
            'goods_id'=>$this->integer(10)->comment('所属商品'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_pictures');
    }
}
