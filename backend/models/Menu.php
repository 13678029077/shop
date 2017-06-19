<?php
namespace backend\models;

use yii\db\ActiveRecord;

class Menu extends ActiveRecord{


    public $menuName;

    public function rules()
    {
        return [
            [['url','parent_id','sort'],'required'],
           // ['menuName','unique'],
            ['menuName','safe'],
            [['parent_id', 'sort'], 'integer'],
            [['label'], 'string', 'max' => 40],
            [['label'],'unique'],
            [['url'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'label'=>'菜单名称',
            'url'=>'路由/地址',
            'parent_id'=>'上级菜单',
            'sort'=>'排序号'
        ];
    }


    public function getChildren(){
       return  $this->hasMany(self::className(),['parent_id'=>'id']);
    }

  /*  //找子菜单，排序
    public function getMenulist($parent_id=0,$deep=1){
        $childrens = [];
        foreach (Menu::find()->asArray()->all() as $child){
                if($child['parent_id']== $parent_id){
                    $child['label']= str_repeat('—',5*$deep).$child['label'];
                    $childrens[] = $child;

                }
            self::getMenulist($child['id'],$deep+1);
        }
        return $childrens;
    }*/
}

/*datatables----分页表*/