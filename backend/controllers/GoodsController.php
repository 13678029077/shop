<?php
namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\Brand;
use backend\models\Goods;
use backend\models\Goods_Category;
use backend\models\Goods_day_count;
use backend\models\Goods_picture;
use backend\models\Goods_pictures;
use backend\models\GoodsIntro;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\web\UploadedFile;
use xj\uploadify\UploadAction;
class GoodsController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    //商品列表页
    public function actionIndex()
    {
      /*  //模糊查询
        $query = Goods::find();
        if($name = \Yii::$app->request->get('name')){//按那么查询
            $query->andWhere(['like','name',$name]);
        }
        if($sn = \Yii::$app->request->get('sn')){//按sn查询
            $query->andWhere(['like','sn',$sn]);
        }
        if($brand = \Yii::$app->request->get('brand')){//按品牌查询
            $query->andWhere(['brand_id'=>$brand]);
        }
       if($min = \Yii::$app->request->get('min_price')){//按最小价格查询
            $query->andWhere(['>=','shop_price',$min]);
        }
       if($max = \Yii::$app->request->get('max_price')){//按最大价格查询
            $query->andWhere(['<=','shop_price',$max]);
        }
*/ $query = Goods::find();
        //分页,按条件询查所有商品
        $count = $query->count();
        $page=new Pagination([
            'totalCount'=>$count,
            'defaultPageSize'=>3,// 每页显示3条
        ]);
        $goods  = $query->offset($page->offset)->limit($page->limit)->all();
      $goods = Goods::find()->all();
        $model = new Goods();
        //收索下拉商品品牌,商品分类
        $brands = Brand::find()->all();
        $cates = Goods_Category::find()->all();
        return $this->render('index',['goods'=>$goods,'model'=>$model,'brands'=>$brands,'cates'=>$cates,'page'=>$page]);
    }


    //1.商品添加功能
    public function actionAdd(){
        $model = new Goods();//商品信息
        $model2 = new GoodsIntro();//保存商品简介内容
        $request = new Request();
        if($model->load($request->post()) && $model2->load($request->post()) && $model->validate() && $model2->validate()){
            $model->imgFile = UploadedFile::getInstance($model, 'imgFile');//图片对象
            if($model->imgFile) {//判断有没有上传图片
                $filename = '/images/goods/' . uniqid() . '.' . $model->imgFile->getExtension();
                $model->imgFile->saveAs(\Yii::getAlias('@webroot') . $filename, false);
                $model->logo = $filename;//保存图片路径
            }
            $model->create_time = time();
            //查询当天添加了几个商品,生成Sn
                $count = 0;//初始值为0计数，默认当天没有添加商品
                if($day = Goods_day_count::findOne(['day'=> date('Y-m-d')])){//查询到当天如果有商品数据
                    $count += $day->count;//获取到原来的count值
                    $model->sn = date('Ymd').substr($count +100000,-4);//获取到sn
                    $day->count = $count+1;//新的count值
                    $day->save();//更新数据表
                }else{
                    //当天还没有添加商品,开始第一次添加表
                    $goods_day_count = new Goods_day_count();
                    $goods_day_count->day = date('Y-m-d');
                    $goods_day_count->count = $count+1;
                    $goods_day_count->save();//保存每天添加商品的数量信息
                    $model->sn = date('Ymd').substr($count +10000,-4);//获取到sn
                }
            $model->save();//保存商品信息
            $model2->goods_id=$model->getAttribute('id');
            $model2->save(); //保存文章内容
            //添加成功，跳转页面
            \Yii::$app->session->setFlash('success','商品添加成功');
            return $this->redirect(['goods/index']);
        }
        //视图页面，需要显示品牌分类下拉数据
        $goods_category = Goods_Category::find()->asArray()->orderBy('tree,lft')->all();
        foreach ($goods_category as &$v){
            $v['name'] = str_repeat('-',$v['depth']*8).$v['name'];//名字前加-
        }
        //视图页面，需要商品分类下拉数据
        $goods_category = ArrayHelper::map($goods_category,'id','name');
        $brands = Brand::find()->asArray()->all();
        $brands = ArrayHelper::map($brands,'id','name');
        return $this->render('add',['model'=>$model,'model2'=>$model2,'goods_category'=>$goods_category,'brands'=>$brands]);
    }


    //2.删除商品
    public function actionDelete($id){
        $goods = Goods::findOne(['id'=>$id]);//找到删除行
        $goods->status = 0;//修改状态
        $goods->is_on_sale = 0;//是否在售改为0
        $goods->save();
        \Yii::$app->session->setFlash('删除成功');
        //echo "<script>alert('删除成功');</script>";
        return $this->redirect(['goods/index']);
    }


    //3.商品修改
    public function actionEdit($id){
        $model = Goods::findOne(['id'=>$id]);//商品信息
        $model2 = GoodsIntro::findOne(['id'=>$id]);//保存商品简介内容
        $request = new Request();
        if($model->load($request->post()) && $model2->load($request->post()) && $model->validate() && $model2->validate()){
            $model->imgFile = UploadedFile::getInstance($model, 'imgFile');//图片对象
            if($model->imgFile) {//判断有没有上传图片
                $filename = '/images/goods/' . uniqid() . '.' . $model->imgFile->getExtension();
                $model->imgFile->saveAs(\Yii::getAlias('@webroot') . $filename, false);
                $model->logo = $filename;//保存图片路径
            }
            $model->create_time = time();
            //查询当天添加了几个商品,生成Sn
            $count = 0;//初始值为0计数，默认当天没有添加商品
            if($day = Goods_day_count::findOne(['day'=> date('Y-m-d')])){//查询到当天如果有商品数据
                $count += $day->count;//获取到原来的count值
                $model->sn = date('Ymd').substr($count +10000,-4);//获取到sn
                $day->count = $count;//新的count值
                $day->save();//更新数据表
            }else{
                //当天还没有添加商品,开始添加技术表
                $goods_day_count = new Goods_day_count();
                $goods_day_count->day = date('Y-m-d');
                $goods_day_count->count = $count+1;
                $goods_day_count->save();//保存每天添加商品的数量信息
                $model->sn = date('Ymd').substr($count +10000,-4);//获取到sn
            }
            $model->save();//保存商品信息
            $model2->goods_id=$model->getAttribute('id');
            $model2->save(); //保存文章内容
            //添加成功，跳转页面
            \Yii::$app->session->setFlash('success','修改成功');
            return $this->redirect(['goods/index']);
        }
        //视图页面，需要显示品牌分类下拉数据
        $goods_category = Goods_Category::find()->asArray()->orderBy('tree,lft')->all();
        foreach ($goods_category as &$v){
            $v['name'] = str_repeat('-',$v['depth']*8).$v['name'];//名字前加-
        }
        //视图页面，需要商品分类下拉数据
        $goods_category = ArrayHelper::map($goods_category,'id','name');
        $brands = Brand::find()->asArray()->all();
        $brands = ArrayHelper::map($brands,'id','name');
        return $this->render('add',['model'=>$model,'model2'=>$model2,'goods_category'=>$goods_category,'brands'=>$brands]);
    }


    //查看商品详情
    public function actionContent($id){
        $title = Goods::findOne(['id'=>$id]);
        $content=GoodsIntro::findOne(['goods_id'=>$id]);
        return $this->render('content',['title'=>$title,'content'=>$content]);
    }

    //商品相册图片添加页
    public function actionPic_add($id){
        $model =new Goods_pictures();
        if($model->load(\Yii::$app->request->post())){
            if( $model->validate()){
                $model->status=1;
                $model->goods_id=$id;
                $model->save();
                return $this->redirect(['goods/pic_index','id'=>$id]);//跳转页面
            }
        }
        $good_name = Goods::findOne(['id'=>$id]);//添加页面显示为谁添加图片
        return $this->render('pic_add',['model'=>$model,'good_name'=>$good_name]);
    }

    //商品图片相册展示
    public function actionPic_index($id){
        $model = Goods_pictures::find()->where(['goods_id'=>$id,'status'=>1])->all();//获得图片

        $good = Goods::findOne(['id'=>$id]);
        return $this->render('pic_index',['pictures'=>$model,'good'=>$good]);
    }


    //商品图片相册删除
    public function actionPic_delete($id,$goods_id){
        $goods_pic = Goods_pictures::findOne(['id'=>$id]);
        $goods_pic->status = 0;
        $goods_pic->save();
        return $this->redirect(['pic_index','id'=>$goods_id]);
    }

    public function actionPic_delete1(){
        $goods_pic = Goods_pictures::find()->where(['status'=>0])->all();
        foreach ($goods_pic as $n){
            $n->delete();
            //unlink(\Yii::getAlias('@web').$n->img);
        }
        return $this->redirect(['pic_index']);
    }

    //图片回收站页面
    public function actionPic_removed($id){
        $model = Goods_pictures::find()->where(['goods_id'=>$id,'status'=>0])->all();//获得图片
        $good = Goods::findOne(['id'=>$id]);
        return $this->render('pic_removed',['pictures'=>$model,'good'=>$good]);
    }

    //商品图片还原
    public function actionPic_readd($id,$goods_id){
        $goods_pic = Goods_pictures::findOne(['id'=>$id]);
        $goods_pic->status = 1;
        $goods_pic->save();
        return $this->redirect(['pic_removed','id'=>$goods_id]);
    }


    //配置ueditor 参数, 配置用uplodify批量上传图片
    public function actions(){
        return [
                'upload' => [
                        'class' => 'kucha\ueditor\UEditorAction',
                        'config' => [
                            "imageUrlPrefix"  => "http://www.shop.com",//图片访问路径前缀
                            "imagePathFormat" => "/images/", //上传保存路径
                        "imageRoot" => \Yii::getAlias("@webroot"),
                        ],
                ],
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
                       // $action->getFilename(); // "image/yyyymmddtimerand.jpg"
                       // $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                       // $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                        $model = new Goods_pictures();
                        $model->goods_id=\Yii::$app->request->post('goods_id');
                        $model->img = $action->getWebUrl();
                        $model->status=1;
                        $model->save();
                        $action->output['fileUrl'] = $action->getWebUrl();//输出图片地址

                    },
                ],

        ];
    }

    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
            ],
        ];
    }

    /* //过滤器,围墙,老板，项目经理可以增删改查商品，未认证可以查看
     public function behaviors()
     {
         return [
             'acf'=>[
                 'class'=>AccessControl::className(),
                 'rules'=>[
                     [//未认证的用户可以查看
                         'allow'=>true,//是否允许
                         'actions'=>['index','pic_index','content','removed'],//指定操作
                         'roles'=>['?'],//？表示未认证用户
                     ],
                     [//老板,项目经理可以对商品增删改查
                         'allow'=>true,//是否允许
                         'actions'=>['readd','content','pic_add','pic_index','add','index','delete','removed','pic_readd','pic_removed','pic_delete'],//指定操作
                         'roles'=>['老板','项目经理'],
                     ],
                 ]
             ],
         ];
     }*/


}
