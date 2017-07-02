<?php

namespace backend\controllers;

use frontend\models\Order;
use frontend\models\OrderGoods;
use yii\db\Exception;

class OrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //查询出数据,显示
        $orders = Order::find()->all();

        return $this->render('index',['orders'=>$orders]);
    }


    public function actionOrder_info($id){
        //订单信息
        $order = Order::findOne(['id'=>$id]);
        if(!$order){
            //找到订单中的商品信息
            throw new Exception('该订单不存在');
        }
        $goods = OrderGoods::find()->where(['order_id'=>$order->id])->all();

        //var_dump($goods);exit;
        return $this->render('order_info',['goods'=>$goods,'order'=>$order]);
    }


    //商品发货
    public function actionSend($id){
           $order =  Order::findOne(['id'=>$id]);
           if(!$order){
               throw new Exception('该订单不存在');
           }
           $order->status=2;
           $order->save();
           return $this->redirect('index');
    }
}
