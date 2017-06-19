<?php
namespace  backend\models;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class RoleForm extends ActiveRecord{

    public $name;
    public $description;
    public $permissions = [];//存放权限

    public function rules()
    {
        return [
            [['name','description'],'required'],
            ['permissions','safe'],//表示该字段不需要验证
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'=>'角色名',
            'description'=>'角色描述',
            'permissions'=>'角色权限'
        ];
    }
    //1.获取所有的权限
    static public function getPermissionlist(){
        //获取到所有权限
        $permissions = \Yii::$app->authManager->getPermissions();
        return ArrayHelper::map($permissions,'name','description');//key=>value形式
    }


    //2.添加角色
    public function addRole(){
        $manager = \Yii::$app->authManager;
        //先判角色是否存在
        if($manager->getRole($this->name)){
            $this->addError('name','角色已存在');
        }else{
            //创建角色
            $role  = $manager->createRole($this->name);
            $role->description = $this->description;

            if($manager->add($role)){//保存到数据表
                foreach($this->permissions as $permissionNmae){//为角色添加权限，循环添加
                    $permission = $manager->getPermission($permissionNmae);//根据权限名字找到权限对象
                    $manager->addChild($role,$permission);//为角色添加权限
                }
                return true;
            }
        }
        return false;
    }



    //3.角色加载数据,编辑时回显
    public function loadData($role)
    {
        //$role为修改的角色对象
        $this->name = $role->name;
        $this->description = $role->description;
        //获得角色所拥有的权限,['name','name']
        $permissions = \Yii::$app->authManager->getPermissionsByRole($role->name);
        foreach($permissions as $permission){
            $this->permissions[] = $permission->name;
        }
    }


    //3.修改角色
    public function EditRole($name)
    {
        $authmanager = \Yii::$app->authManager;
        $role = $authmanager->getRole($name);
        //3.1先判断修改后的name是否有重复,除了自己
        if($name !=$this->name){
            if(\Yii::$app->authManager->getRole($this->name)){
                $this->addError('角色名已存在');
                return false;
            }
        }
        //3.2将表单中的数据赋值给$role
        $role->name = $this->name;
        $role->description = $this->description;
        //3.3移除$role的所有权限,添加新权限
        if($authmanager->update($name,$role)){
            $authmanager->removeChildren($role);//移除role的所有权限
            foreach ($this->permissions as $permissionName){//添加新权限

                $permission = $authmanager->getPermission($permissionName);//根据接受到的名字获得权限
                if($permission){
                    $authmanager->addChild($role,$permission);
                }

            }
            return true;
        }
       return false;
    }






}