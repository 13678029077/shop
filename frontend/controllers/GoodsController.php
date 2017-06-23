<?php
namespace frontend\controllers;


use backend\models\Goods_pictures;
use frontend\models\Address;
use frontend\models\Goods;
use yii\data\Pagination;
use yii\web\Controller;
header('Content-type:text/html ; charset=utf-8');
//商品
class GoodsController extends Controller{
    public $layout ='goods';

    //用户地址页,新增地址
    public function actionAddress(){
        $model = new Address();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
                //保存地址
                if($model->saveaddress()){
                    echo '<script>alert("保存成功");</script>';
                }
        }
        //$province = $model->getProvince();

        return $this->render('address',['model'=>$model]);
    }

    //用户删除地址
    public function  actionDelAddress($id){
        Address::findOne(['id'=>$id])->delete();
        $model = new Address();
        $this->redirect(['address','model'=>$model]);
    }

    //设置为默认地址
    public function actionSetAddress($id){
            $addressall = Address::findAll(['user_id'=>\Yii::$app->user->id]);//找到所有
            foreach ($addressall as $address){
                $address->status = 0 ;//取消默认地址
                $address->save(false);
            }
            $address = Address::findOne(['id'=>$id]);
            $address->status = 1 ;//设置新的默认地址
            $address->save(false);
            //echo '<script>alert("设置成功");</script>';
            $this->redirect(['address'/*,'model'=>$model,'province'=>$province]*/]);
    }


    //用户修改,收货地址
    public function actionEidtAddress($id){
        $model = Address::findOne(['id'=>$id]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //保存地址
            if($model->saveaddress()){
                echo '<script>alert("保存成功");</script>';
            }
        }
        return $this->render('address',['model'=>$model]);
    }



    //商品list列表
    public function actionList($cate){
        //根据分类名查找
        //分页,按条件询查所有商品
        $query = Goods::find()->where(['goods_category_id'=>$cate]);
        $count = $query->count();
        $page=new Pagination([
            'totalCount'=>$count,
            'defaultPageSize'=>4,// 每页显示3条
        ]);
        $goods  = $query->offset($page->offset)->limit($page->limit)->all();

        return $this->render('list',['cate'=>$cate,'goods'=>$goods,'page'=>$page]);
    }


    public function actionGoods($id){
        //1.查出商品信息
        $goods_info = Goods::findOne(['id'=>$id]);
        //2.查出商品图片
        $goods_pic = Goods_pictures::find()->asArray()->where(['goods_id'=>$id])->limit(8)->all();
        $model = new Goods();
      //  var_dump($model->cate);exit;
        return $this->render('goods',['model'=>$model,'goods_info'=>$goods_info,'goods_pic'=>$goods_pic]);
    }



    //订单页
    public function actionOrder(){

        return $this->render('order');
    }



    //用户中心
    public function actionUser(){
        return $this->render('user');
    }

    //首页
    public function actionIndex(){
        $this->layout = 'goodsindex';
        return $this->render('index');
    }


    //获取省份
    /**
     * @return string
     */
    public function actionGetLocation($pid){
      return ( json_encode(\frontend\models\Locations::find()->asArray()->where(['parent_id'=>$pid])->all()));
    }


}