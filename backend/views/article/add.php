<?php
//添加文章
$form = \yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name')->textInput();
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'article_category_id')->dropDownList($cates);
echo $form->field($model,'sort')->textInput();
echo $form->field($model,'status',['inline'=>true])->radioList(['1'=>'正常','0'=>'隐藏']);

echo $form->field($model2,'content')->textarea(['style'=>'height:300px;resize:none']);

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();
?>
