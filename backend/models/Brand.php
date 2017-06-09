<?php

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $logo
 * @property integer $sort
 * @property integer $status
 */
class Brand extends ActiveRecord
{

    public $logoFile;//保存文件上传对象

    static public $status = [-1=>'删除',1=>'正常',0=>'隐藏'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','sort','status'],'required'],
            [['intro'], 'string'],
            [['sort', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 255],
           // ['logoFile','file','extensions'=>['jpg','png','gif']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '品牌名称',
            'intro' => '简介',
            'logo' => '品牌LOGO',
            'sort' => '排序号',
            'status' => '状态',
            'logoFile'=>'LOGO图片'
        ];
    }
}
