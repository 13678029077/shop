<?php
/**
 * @var $this \yii\web\View
 */
//添加文章
$form = \yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name')->textInput();//商品名
echo $form->field($model,'imgFile')->fileInput(['id'=>'logo']);//logo图片
//修改时回显图片
echo $model->logo ? "<img src='{$model->logo}' style='width:100px;' >" : '';

echo "<img src='' style='width:100px;display:none' id='box' >";
echo $form->field($model,'goods_category_id')->dropDownList($goods_category);//商品分类下拉
echo $form->field($model,'brand_id')->dropDownList($brands);//品牌下拉
echo $form->field($model,'market_price')->textInput();//市场价
echo $form->field($model,'shop_price')->textInput();//售价
echo $form->field($model,'stock')->textInput();//库存
echo $form->field($model,'is_on_sale',['inline'=>true])->radioList(['1'=>'在售','0'=>'下架']);//是否在售，单选
echo $form->field($model,'status',['inline'=>true])->radioList(['1'=>'正常','0'=>'回收站']);//状态，
echo $form->field($model,'sort')->textInput();//排序

//输出ueditor，设置属性
echo $form->field($model2,'content')->widget('kucha\ueditor\UEditor',['name' => 'content', 'clientOptions' => [
    //编辑区域大小
    'initialFrameHeight' => '200px',
    //设置语言
    'lang' =>'zh-cn', //中文为 zh-cn
    //定制菜单
    'toolbars' => [
        [
            'fullscreen', 'source', 'undo', 'redo', '|',
            'fontsize',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
            'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
            'forecolor', 'backcolor', '|',
            'lineheight', '|',
            'indent', '|'
        ],
    ]
]]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();
