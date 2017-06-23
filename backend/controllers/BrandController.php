<?php
namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\Brand;
use yii\data\Pagination;

use xj\uploadify\UploadAction;
use yii\grid\ActionColumn;

class BrandController extends \yii\web\Controller
{
    //添加品牌
    public function actionAdd(){
        $model = new Brand();
            if($model->load(\Yii::$app->request->post())){
                //$model->logoFile = UploadedFile::getInstance($model,'logoFile');
                if($model->validate()){//验证数据有效
                   /* if($model->logoFile){//判断是否上传了logo图片
                        $filename = '/images/'.uniqid().'.'.$model->logoFile->getExtension();//设定图片保存路径
                        $model->logoFile->saveAs(\Yii::getAlias('@webroot').$filename,false);//保存图片到指定路径
                        $model->logo = $filename;
                    }*/
                 //  var_dump($model);exit;
                    $model->save();//保存到数据库
                    \Yii::$app->session->setFlash('success','品牌添加成功');
                    return $this->redirect(['brand/index']);//跳转页面
                }
            }
        return $this->render('add',['model'=>$model]);
    }



    //显示品牌列表
    public function actionIndex(){
        //分页
        $query = Brand::find();
       /* $total = $query->count();//总条数
        $page=new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>3,// 每页显示3条
        ]);*/
        //查询数据
        $brands  = $query->all();
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
           // $model->logoFile = UploadedFile::getInstance($model,'logoFile');
            if($model->validate()){//验证数据有效
              /*  if($model->logoFile){//判断是否上传了logo图片
                    $filename = '/images/'.uniqid().'.'.$model->logoFile->getExtension();//设定图片保存路径
                    $model->logoFile->saveAs(\Yii::getAlias('@webroot').$filename,false);//保存图片到指定路径
                    $model->logo = $filename;
                }*/
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

    //上传插件
    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {

                    $imgurl = $action->getWebUrl();
                    //调用七牛云，将文件上传到七牛云
                    $qiniu = \Yii::$app->qiniu;//七牛对象
                    $qiniu->uploadfile(\Yii::getAlias('@webroot'). $imgurl,$imgurl);
                    $url = $qiniu->getLink($imgurl);//得到文件在七牛云上的地址
                    $action->output['fileUrl'] = $url;//输出文件地址

                },
            ],
        ];
    }
/*
 * //七牛云
    public function actionTest(){
        $ak = '6GX6pflkyaH-jaOJya12fIEhZo6I0TGpl_TQ7wGj';
        $sk = 'qnW_O0gIMmma4PCuDbCOhucxYMoHdMRiN48ROog1';
        $domain = 'http://or9ocwffy.bkt.clouddn.com';//存储的域名
        $bucket = 'myshop';//存储空间名

        $qiniu = new Qiniu($ak, $sk,$domain, $bucket);
        //要上传的文件
        $filename = \Yii::getAlias('@webroot').'/upload/1.jpg';
        $key = '1.jpg';
        $re  = $qiniu->uploadFile($filename,$key);
        $url = $qiniu->getLink($key);//得到文件地址
        var_dump($url);
    }*/

        //过滤器
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
            ],
        ];
    }

}
