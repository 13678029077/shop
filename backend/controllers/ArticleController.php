<?php
namespace backend\controllers;
header('Content-type:text/html;charset=utf-8');
namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\Article;
use backend\models\Article_Category;
use backend\models\Article_detail;
use yii\web\Request;

class ArticleController extends \yii\web\Controller
{

    //添加文章
    public function actionAdd(){
        $model = new Article();//保存文章信息
        $model2 = new Article_detail();
        $request = new Request();
        if($request->isPost){
            $model->load(\Yii::$app->request->post());
            $model2->load(\Yii::$app->request->post());
            if($model->validate() && $model2->validate()){//验证数据有效
                //保存标题等信息
                $model->create_time=time();
                $model->save();
                //保存文章内容
                $model2->article_id = $model->oldAttributes['article_category_id'];
                $model2->id = $model->oldAttributes['id'];
                $model2->save();
                //添加成功跳转
                \Yii::$app->session->setFlash('success','文章分类添加成功');
                return $this->redirect(['article/index']);//跳转页面
            }
        }
        //添加的视图页面
        $data = Article_Category::find()->all();
        $cates = [];//保存分类数据
        foreach ($data as $v ){
                $cates[$v->id] = $v->name ;
        }
      //  var_dump($cates);exit;
        return $this->render('add',['model'=>$model,'cates'=>$cates,'model2'=>$model2]);
    }

    //文章列表页
    public function actionIndex()
    {
        $articles = Article::find()->all();//文章
        return $this->render('index',['articles'=>$articles]);//跳转
    }

    //文章删除
    public function actionDelete($id){
        $art = Article::findOne(['id'=>$id]);
        $art->status = -1;//状态改成-1
        $art->save();//保存
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['article/index']);
    }

    //文章修改
    public function actionEdit($id){
        $model = Article::findOne(['id'=>$id]);
        $model2 = Article_detail::findOne(['id'=>$id]);
        $request = new Request();
        if($request->isPost){
            $model->load(\Yii::$app->request->post());
            $model2->load(\Yii::$app->request->post());
            if($model->validate() && $model2->validate()){//验证数据有效
                //保存标题等信息
                $model->create_time=time();
                $model->save();
                //保存文章内容
                $model2->article_id = $model->oldAttributes['article_category_id'];
                $model2->id = $model->oldAttributes['id'];
                $model2->save();
                //添加成功跳转
                \Yii::$app->session->setFlash('success','文章修改成功');
                return $this->redirect(['article/index']);//跳转页面
            }
        }
        //添加的视图页面
        $data = Article_Category::find()->all();
        $cates = [];//保存分类数据
        foreach ($data as $v ){
            $cates[$v->id] = $v->name ;
        }
        //  var_dump($cates);exit;
        return $this->render('add',['model'=>$model,'cates'=>$cates,'model2'=>$model2]);
    }

    //文章内容
    public function actionArticle_content($id){
        $title = Article::findOne(['id'=>$id]);//查询标题
        $content = Article_detail::findOne(['id'=>$id]);//查询内容
        return $this->render('article_content',['title'=>$title,'content'=>$content]);
    }

    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
            ],
        ];
    }

}
