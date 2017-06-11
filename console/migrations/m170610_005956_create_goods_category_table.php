<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_category`.
 */
class m170610_005956_create_goods_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey(),
            'tree'=>$this->integer(10)->comment('树ID'),
            'lft'=>$this->integer(10)->comment('左值'),
            'rgt'=>$this->integer(10)->comment('右值'),
            'depth'=>$this->integer(10)->comment('层级'),
            'name'=>$this->string(100)->comment('名称'),
            'parent_id'=>$this->integer(10)->comment('上级分类ID'),
            'intro'=>$this->text()->comment('简介'),


        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_category');
    }
}
