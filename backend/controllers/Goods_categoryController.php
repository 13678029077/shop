<?php
namespace backend\controllers;
//商品分类
use backend\components\RbacFilter;
use backend\models\Goods_Category;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

header('Content-type:text/html;charset=utf-8');
class Goods_categoryController extends \yii\web\Controller
{
    //1.商品分类列表
    public function actionIndex(){
        //查询出所有分类
        $cates = Goods_Category::find()->orderBy('tree,lft')->all();
        return $this->render('index',['cates'=>$cates]);
    }


    //2.添加商品分类
    public function actionAdd(){
        $model = new Goods_Category();
        if( $model->load(\Yii::$app->request->post()) && $model->validate()){
            //判断是否添加的一级分类
            if($model->parent_id == 0 ){
                //添加一级分类
                $model->makeroot();
            }else{
                //添加子孙分类
                $parent = Goods_Category::findOne(['id'=>$model->parent_id]); //找到父分类
                $model->prependTo($parent);//添加到上一级分类下面
            }
            \Yii::$app->session->setFlash('success','商品分类添加成功');
            return $this->redirect(['goods_category/index']);//跳转页面
        }
        //查询出所有分类
        $cates = Goods_Category::find()->asArray()->all();
        $cates =ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],$cates);
        return $this->render('add',['model'=>$model,'cates'=>$cates]);
    }


    //3.修改商品分类
    public function actionEdit($id){
        $model = Goods_Category::findOne(['id' => $id]);
        //$son = $model->leaves()->all();//找到所有子孙
        //先判断有没有该分类
        if($model == null){
            throw new NotFoundHttpException('分类不存在');
        }
        if( $model->load(\Yii::$app->request->post()) && $model->validate()){
            //判断是否添加的一级分类
            if($model->parent_id == 0 ){
                if($model->getOldAttribute('parent_id')==0){
                    $model->save();
                }else{
                    //添加一级分类
                    $model->makeroot();
                }

            }else{
                //添加子孙分类
                $parent = Goods_Category::findOne(['id'=>$model->parent_id]); //找到父分类
                $re = $model->prependTo($parent);//添加到上一级分类下面
            }
            //添加成功跳转
            \Yii::$app->session->setFlash('success','商品分类添加成功');
            return $this->redirect(['goods_category/index']);
        }
        //查询出所有分类
        $cates = Goods_Category::find()->asArray()->all();
        $cates =ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],$cates);
        return $this->render('add',['model'=>$model,'cates'=>$cates]);
    }



    //4.删除分类
    public function actionDelete($id){
        $cate = Goods_Category::findOne(['id'=>$id]);
        //判断是不是根节点
        if($cate->parent_id == 0){
            \Yii::$app->session->setFlash('error','根节点不能删除');
            return $this->redirect(['goods_category/index']);//跳转页面
        }
        //判断有没有子分类
        $child = Goods_Category::findOne(['parent_id'=>$cate->id]);
        if($child){
            \Yii::$app->session->setFlash('error', '该分类有子分类，不能删除');
        }else{
            $cate->delete();
        }
        return $this->redirect(['goods_category/index']);//跳转页面
    }


    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
            ],
        ];
    }



    //嵌套集合
    public function actionTest(){
        //一级目录
       // $cate = new Goods_Category();
      /* $cate->name="顶级分类";
        $cate->parent_id = 0;
        $cate->makeRoot();

        //二级目录
        //找到父类
        $parent = Goods_Category::findOne(['id'=>13]);
        $cate->name="家电";
        $cate->parent_id = $parent->id;
        $cate->prependTo($parent);

        //获取一级分类
        $root = Goods_Category::find()->roots()->all();
        var_dump($root);*/
        //获取子孙分类
        $parent = Goods_Category::findOne(['id'=>13]);
        $leaves = $parent->leaves()->all();
        var_dump($leaves);
    }

   /* //树tree测试
    public function actionTree(){
        //查询出分类
        $cates = Goods_Category::find()->asArray()->all();
      //  var_dump($cates);exit;
        return $this->renderPartial('tree',['cates'=>$cates]);//设置不加载布局文件
    }*/

}
