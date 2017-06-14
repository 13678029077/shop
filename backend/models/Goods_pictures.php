<?php
namespace backend\models;

use yii\db\ActiveRecord;

class Goods_pictures extends ActiveRecord{

    //建立与商品表的一对一关系
    public function getgoods(){
        return $this->hasOne(Goods::className(),['id'=>'goods_id']);

    }

    public function rules()
    {
        return [
            ['img','required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'img'=>'上传商品图片'
        ];
    }
}