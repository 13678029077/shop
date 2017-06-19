<?php
//添加文章
$form = \yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name')->textInput();
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'article_category_id')->dropDownList($cates);
echo $form->field($model,'sort')->textInput();
echo $form->field($model,'status',['inline'=>true])->radioList(['1'=>'正常','0'=>'隐藏']);

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
?>
