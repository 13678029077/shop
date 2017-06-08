<?php

namespace backend\controllers;

use backend\models\Article_Category;

class Article_categoryController extends \yii\web\Controller
{
    //添加分类
    public function actionAdd(){
        $model = new Article_Category();
        if($model->load(\Yii::$app->request->post())){
            if($model->validate()){//验证数据有效
                $model->save();//保存到数据库
                \Yii::$app->session->setFlash('success','文章分类添加成功');
                return $this->redirect(['article_category/index']);//跳转页面
            }
        }
        return $this->render('add',['model'=>$model]);
    }

    //显示分类列表
    public function actionIndex(){
        //['!=','status',-1]
        $cates =Article_Category::find()->all();
        return $this->render('index',['cates'=>$cates]);
    }

    //回收站列表
    public function actionRemoved(){
        $cates =Article_Category::find()->where(['status'=>-1])->all();
        return $this->render('removed',['cates'=>$cates]);
    }

    //还原已经删除
    public function actionRechange($id){
        $art = Article_Category::findOne(['id'=>$id]);
        $art->status = 1;//状态改成1还原
        $art->save();//保存
        \Yii::$app->session->setFlash('success','还原成功');
        return $this->redirect(['article_category/index']);
    }


    //删除分类
    public function actionDelete($id){
        $art = Article_Category::findOne(['id'=>$id]);
        $art->status = -1;//状态改成-1
        $art->save();//保存
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['article_category/index']);
    }

    //修改分类
    public function actionEdit($id){
        $model = Article_Category::findOne(['id'=>$id]);
        if($model->load(\Yii::$app->request->post())){
            if($model->validate()){//验证数据有效
                $model->save();//保存到数据库
                \Yii::$app->session->setFlash('success','文章分类修改成功');
                return $this->redirect(['article_category/index']);//跳转页面
            }
        }
        return $this->render('add',['model'=>$model]);
    }

}
