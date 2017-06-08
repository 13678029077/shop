<?php
namespace backend\controllers;

use backend\models\Brand;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{
    //添加品牌
    public function actionAdd(){
        $model = new Brand();
            if($model->load(\Yii::$app->request->post())){
                $model->logoFile = UploadedFile::getInstance($model,'logoFile');
                if($model->validate()){//验证数据有效
                    if($model->logoFile){//判断是否上传了logo图片
                        $filename = '/images/'.uniqid().'.'.$model->logoFile->getExtension();//设定图片保存路径
                        $model->logoFile->saveAs(\Yii::getAlias('@webroot').$filename,false);//保存图片到指定路径
                        $model->logo = $filename;
                    }
                    $model->save();//保存到数据库
                    \Yii::$app->session->setFlash('success','品牌添加成功');
                    return $this->redirect(['brand/index']);//跳转页面
                }
            }
        return $this->render('add',['model'=>$model]);
    }



    //显示品牌列表
    public function actionIndex(){
        $brands = Brand::find()->all();
        return $this->render('index',['brands'=>$brands]);
    }


    //删除
    public function actionDelete($id){
        $brand = Brand::findOne(['id'=>$id]);
        $brand->status = -1;//状态改成-1
        $brand->save();//保存
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['brand/index']);
    }

    //修改
    public function actionEdit($id){
        $model = Brand::findOne(['id'=>$id]);
        if($model->load(\Yii::$app->request->post())){
            $model->logoFile = UploadedFile::getInstance($model,'logoFile');
            if($model->validate()){//验证数据有效
                if($model->logoFile){//判断是否上传了logo图片
                    $filename = '/images/'.uniqid().'.'.$model->logoFile->getExtension();//设定图片保存路径
                    $model->logoFile->saveAs(\Yii::getAlias('@webroot').$filename,false);//保存图片到指定路径
                    $model->logo = $filename;
                }
                $model->save();//保存到数据库
                \Yii::$app->session->setFlash('success','品牌修改成功');
                return $this->redirect(['brand/index']);//跳转页面
            }
        }
        return $this->render('add',['model'=>$model]);
    }

    //回收站列表
    public function actionRemoved(){
        $brands = Brand::find()->where(['status'=>-1])->all();
        return $this->render('removed',['brands'=>$brands]);
    }

    //还原已经删除
    public function actionRechange($id){
        $art = Brand::findOne(['id'=>$id]);
        $art->status = 1;//状态改成1还原
        $art->save();//保存
        \Yii::$app->session->setFlash('success','还原成功');
        return $this->redirect(['article_category/index']);
    }

}
