<?php
use yii\web\JsExpression;
use xj\uploadify\Uploadify;

$form = \yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name')->textInput();
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'sort')->textInput();
echo $form->field($model,'logo')->hiddenInput(['id'=>'logo']);
//echo $form->field($model,'logoFile')->fileInput(['id' => 'test']);
echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);


//外部TAG
echo Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
        //上传成功将地址写入img
        $('#img_logo').attr('src',data.fileUrl).show();
        //地址写入logo
        $('#logo').val(data.fileUrl);   
    }
}
EOF
        ),
    ]
]);
if($model->logo){
    echo \yii\bootstrap\Html::img('@web'.$model->logo,['id'=>'img_logo','height'=>'100']);
}else{
    echo \yii\bootstrap\Html::img('',['style'=>'display:none','id'=>'img_logo','height'=>'50']);
}

echo $form->field($model,'status',['inline'=>true])->radioList(['1'=>'正常','0'=>'隐藏']);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();



