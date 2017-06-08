<?php

$form = \yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name')->textInput();
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'sort')->textInput();
echo $form->field($model,'status',['inline'=>true])->radioList(['1'=>'正常','0'=>'隐藏']);
echo $form->field($model,'logoFile')->fileInput(['id'=>"img"]);
echo \yii\bootstrap\Html::tag('div');
echo isset($model->logo) ? "<div><img src=".$model->logo." style='width:80px;height:50px;'></div><br/>" : '';
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();

?>


