<?php
namespace backend\models;

use yii\db\ActiveRecord;

class Article extends ActiveRecord{
    /**
     * This is the model class for table "article".
     *
     * @property integer $id
     * @property string $name
     * @property string $intro
     * @property integer $article_category_id
     * @property integer $sort
     * @property integer $status
     * @property integer $create_time
     */

    static public $status = [-1=>'删除',1=>'正常',0=>'隐藏'];

    public static function tableName()
    {
        return 'article';
    }


    //建立于分类表的关系1对1,一个文章一个分类
    public function getCatename(){
        return $this->hasOne(Article_Category::className(),['id'=>'article_category_id']);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intro'], 'string'],
            [['article_category_id', 'sort', 'status', 'create_time'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '标题',
            'intro' => '简介',
            'article_category_id' => '文章分类',
            'sort' => '排序',
            'status' => '状态',
            'create_time' => '创建时间',
        ];
    }
}