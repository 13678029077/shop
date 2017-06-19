<?php
/**
 * @var $this \yii\web\View
 */
$form = \yii\bootstrap\ActiveForm::begin();//表单开始

echo $form->field($model,'name')->textInput();//商品分类名
echo $form->field($model,'parent_id')->hiddenInput()->label('上级分类');
echo '<ul id="treeDemo" class="ztree"></ul>';
echo $form->field($model,'intro')->textarea();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();//表单结束


//加载jS和css文件
$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
//如果是添加，parent_id没有，默认为0
$parent_id = isset($model->parent_id) ? $model->parent_id : 0 ;

//定义js多行字符串
$option = \yii\helpers\Json::encode($cates);
$JS = new \yii\web\JsExpression(
    <<<JS
         var zTreeObj;
    // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
    var setting = {
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parent_id",
                rootPId: 0
            }
        },
        callback:{
            onClick:function(event,treeId,treeNode){
                //将选择的ID赋值给parent_id,表单提交
                $('#goods_category-parent_id').val(treeNode.id);
            }
        }
    };
    
    // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
        var zNodes = {$option};
        zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        zTreeObj.expandAll(true);//展开子节点
        //获取修改的节点
        var node = zTreeObj.getNodeByParam("id",{$parent_id} , null);
        zTreeObj.selectNode(node);//修改时默认选中父节点分类
JS
);
$this->registerJs($JS);



