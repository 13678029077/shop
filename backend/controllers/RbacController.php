<?php
namespace  backend\controllers;
use backend\components\RbacFilter;
use backend\models\PermissionForm;
use backend\models\RoleForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RbacController extends Controller
{
    //1.添加权限
    public function actionAddPermission(){
        $model = new PermissionForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->AddPermission()){
                \Yii::$app->session->setFlash('success','添加权限成功');
                return $this->redirect('index-permission');
            }
        }
        return $this->render('add-permission',['model'=>$model]);
    }


    //2.权限列表
    public function actionIndexPermission(){
        $models = \Yii::$app->authManager->getPermissions();

        return $this->render('index-permission',['models'=>$models]);
    }



    //3.删除权限
    public function actionDelPermission($name){
        //找到该权限
        $permission = \Yii::$app->authManager->getPermission($name);
        if($permission){
            //执行删除
            \Yii::$app->authManager->remove($permission);
            return $this->redirect('index-permission');
        }else{
            throw new NotFoundHttpException('该权限不存在或已经删除');
        }
    }


    //4.修改权限
    public function actionEditPermission($name){
        //找到权限,判断有没有
        $permission = \Yii::$app->authManager->getPermission($name);
        if($permission == null ){
            throw new NotFoundHttpException('没有该权限');
        }
        $model = new PermissionForm();
        //执行修改
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->EditPermission($name)){
                \Yii::$app->session->setFlash('success','权限修改成功');
                return $this->redirect('index-permission');
            }
        }
        //视图回显
        $model->loadData($permission);
        return $this->render('add-permission',['model'=>$model]);
    }



    //角色的增删改查
    //添加角色
    public function actionAddRole(){
        $model = new RoleForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->addRole()){ //执行添加
                \Yii::$app->session->setFlash('success','添加角色成功');
                return $this->redirect('role-index');
            }
        }
        $model->permissions = $model->getPermissionlist(); //视图，需要显示所有的权限
        return $this->render('add-role',['model'=>$model]);
    }


    //角色显示列表
    public function actionRoleIndex(){
        $models = \Yii::$app->authManager->getRoles();

        return $this->render('index-role',['models'=>$models]);
    }

    //删除角色
    public function actionDelRole($name){
        $authmanager = \Yii::$app->authManager;
        if(!$authmanager->getRole($name)){ //找到该角色，判断是否存在
            throw new NotFoundHttpException('角色不存在，或已经被删除');
        }
        $authmanager->remove($authmanager->getRole($name));  //执行删除
        return $this->redirect(['role-index']);//跳转回index页面
    }

    //修改角色
    public function actionEditRole($name)
    {
        $role = \Yii::$app->authManager->getRole($name);//找到修改的角色
        if($role == null){
            throw new NotFoundHttpException('角色信息不存在或已经删除');
        }
        $model = new RoleForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->EditRole($name)){ //执行修改
                \Yii::$app->session->setFlash('success','修改角色成功');
                return $this->redirect('role-index');
            }
        }
        $model->loadData($role);//加载角色的权限,修改时回显
        return $this->render('add-role',['model'=>$model]);
    }


   /* //过滤器,围墙,老板可以增删改查角色和权限,其他角色可以查看
    public function behaviors()
    {
        return [
            'acf'=>[
                'class'=>AccessControl::className(),
                'rules'=>[
                    [//未认证的用户可以查看角色,查看权限
                        'allow'=>true,//是否允许
                        'actions'=>['index-permission','role-index','goods/index'],//指定操作
                        'roles'=>['?','项目经理'],//？表示未认证用户
                    ],
                    [//老板可以对权限角色增删改查
                        'allow'=>true,//是否允许
                        'actions'=>['add-permission','del-permission','edit-permission','add-role','del-role','edit-role'],//指定操作
                        'roles'=>['老板'],
                    ],
                ]
            ],
        ];
    }*/

    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
            ],
        ];
    }

}