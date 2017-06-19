<?php

$form = \yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name')->textInput();
echo $form->field($model,'description')->textarea();

//角色的权限
echo $form->field($model,'permissions',['inline'=>true])->checkboxList(\backend\models\RoleForm::getPermissionlist());
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();
?>