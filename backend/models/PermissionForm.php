<?php
namespace  backend\models;
use yii\db\ActiveRecord;

class PermissionForm extends ActiveRecord{

    public $name;
    public $description;

    public function rules()
    {
        return [
            [['name','description'],'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'=>'权限名称',
            'description'=>'权限描述'
        ];
    }

    //1.添加权限
    public function AddPermission(){
        $manager = \Yii::$app->authManager;
        //先判断权限是否存在
        if($manager->getPermission($this->name)){
            $this->addError('name','权限已存在');
        }else{
            //创建权限
            $permission = $manager->createPermission($this->name);
            $permission->description = $this->description;
            //保存到数据表
            return $manager->add($permission);
        }
        return false;
    }

    //2.从权限中加载数据
    public function loadData($permission){
        $this->name = $permission->name;
        $this->description = $permission->description;
    }

    //3.修改权限
    public function EditPermission($name)
    {
        $authmanager = \Yii::$app->authManager;
        $permission = $authmanager->getPermission($name);
        //3.1先判断修改后的name是否有重复,除了自己
        if($name !=$this->name){
            if(\Yii::$app->authManager->getPermission($this->name)){
                $this->addError('权限名重复');
                return false;
            }
        }
        //3.2将表单中的数据赋值给permission
        $permission->name = $this->name;
        $permission->description = $this->description;
        //3.3更新数据
        return $authmanager->update($name,$permission);//name为旧的名字,permission为修改的权限对象
    }



}