<?php

use yii\db\Migration;
//创建brand品牌表
/**
 * Handles the creation of table `brand`.
 */
class m170608_062156_create_brand_table extends Migration
{
    public function up()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->comment('品牌名称'),
            'intro'=>$this->text()->comment('简介'),
            'logo'=>$this->string(255)->comment('品牌LOGO'),
            'sort'=>$this->integer(11)->comment('排序号'),
            'status'=>$this->integer(3)->comment('状态')//删除-1，隐藏0，正常1
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brand');
    }
}
