<?php
namespace backend\widgets;
//管理菜单栏
use backend\models\Menu;
use yii\bootstrap\Html;
use yii\bootstrap\Widget;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use Yii;
class Menuwidgets extends Widget{

    public function init()
    {
        parent::init();//实例化是执行得操作
    }

    public function run()
    {
        parent::run(); // TODO: Change the autogenerated stub
        NavBar::begin([
            // 'brandLabel' => 'My Company',
            'brandLabel' => '爱购网—后台管理',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        /*$menuItems = [
            ['label' => '管理员管理', 'url' => ['/user/index']],
            ['label' => '商品列表', 'url' => ['/goods/index']],
            ['label' => '商品分类', 'url' => ['/goods_category/index']],
            ['label' => '品牌管理', 'url' => ['/brand/index']],
            ['label' => '文章管理', 'url' => ['/article/index']],
        ];*/
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => '登录', 'url' => Yii::$app->user->loginUrl];
        } else {


            //根据权限显示菜单
   /*         $menuItems[] = ['label'=>'商品管理',
                    'items'=>[
                            ['label'=>'商品添加','url'=>['goods/add']],
                            ['label'=>'商品列表','url'=>['goods/index']],
                    ]
            ];*/

            //查询数据库，根据权限显示菜单
            //先找到一级菜单
            $menus = Menu::findAll(['parent_id'=>0]);
            //根据一级菜单，找到子菜单
            foreach ($menus as $menu){
                $Items = ['label'=>$menu->label,'items'=>[]];
                //找到所有的子菜单
                foreach ($menu->children as $child){
                    if(Yii::$app->user->can($child->url)){ //如果用户有该权限，就将该子菜单添加进去
                        $Items['items'][] = ['label'=>$child->label,'url'=>[$child->url]];
                    }
                }
                if(!empty($Items['items'])){//判断一级菜单的子菜单不是空的，才显示出来
                    $menuItems[] = $Items ;
                }
            }
            $menuItems[] = ['label' => '注销('.Yii::$app->user->identity->username.')', 'url' =>['user/logout']];
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
    }


}