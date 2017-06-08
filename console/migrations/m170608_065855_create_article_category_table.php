<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m170608_065855_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->comment('分类名称'),
            'intro'=>$this->text()->comment('简介'),
            'sort'=>$this->integer(11)->comment('排序号'),
            'status'=>$this->integer(3)->comment('状态'),//删除-1，隐藏0，正常1
            'is_help'=>$this->integer(1)->comment('类型'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_category');
    }
}
