<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $sort
 * @property integer $status
 * @property string $is_help
 */
class Article_Category extends \yii\db\ActiveRecord
{

    static public $status = [-1=>'删除',1=>'正常',0=>'隐藏'];

    public static function tableName()
    {
        return 'article_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name','required'],
            [['intro'], 'string'],
            [['sort', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['is_help'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分类名称',
            'intro' => '简介',
            'sort' => '排序号',
            'status' => '状态',
            'is_help' => '类型',
        ];
    }
}
