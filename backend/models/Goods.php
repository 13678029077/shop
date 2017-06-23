<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $sn
 * @property string $logo
 * @property integer $goods_category_id
 * @property integer $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property integer $stock
 * @property integer $is_on_sale
 * @property integer $status
 * @property integer $sort
 * @property integer $create_time
 */
class Goods extends \yii\db\ActiveRecord
{


    public $imgFile;//保存商品图片
    public static $status= ['0'=>'回收站','1'=>'正常'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }



    //建立商品分类表与商品表的一对一关系，一个商品一个分类
    public function getGoods_category(){
        return $this->hasOne(Goods_Category::className(),['id'=>'goods_category_id']);
    }
    //建立商品表与商品内容表一对一关系
    public function getGoods_intro(){
        return $this->hasOne(GoodsIntro::className(),['goods_id'=>'id']);
    }
    //建立商品与品牌表一对一关系
    public function getBrand(){
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort'], 'required'],
            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort', 'create_time'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name', 'sn'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 255],
            ['name','unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'sn' => '货号',
            'logo' => 'LOGO图片',
            'goods_category_id' => '商品分类id',
            'brand_id' => '品牌分类',
            'market_price' => '市场价格',
            'shop_price' => '商品价格',
            'stock' => '库存',
            'is_on_sale' => '是否在售',
            'status' => '状态',
            'sort' => '排序号',
            'create_time' => '添加时间',
            'imgFile'=>'商品图片'
        ];
    }
}
