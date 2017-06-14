<!--//显示商品名-->
<h2>商品名：
<input type="text" disabled="disabled" value="<?=$good_name->name?>" style="font:24px/48px 微软雅黑;height:40px;background: lightblue;text-indent: 10px"><br/><br/>
</h2>
<?php
use yii\web\JsExpression;
use xj\uploadify\Uploadify;



$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'img')->hiddenInput(['id'=>'logo']);
echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);

//外部TAG,
echo Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'formData'=>['goods_id'=>$goods->id],
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
        //上传成功将地址写入img显示
        $('#img_logo').attr('src',data.fileUrl).show();
        //地址写入img
        $('#logo').val(data.fileUrl); 
    }
}
EOF
        ),
    ]
]);


if($model->img){
    echo \yii\bootstrap\Html::img('@web'.$model->img,['id'=>'img_logo','height'=>'400']).'<br/><br/>';
}else{
    echo \yii\bootstrap\Html::img('',['style'=>'display:none','id'=>'img_logo','height'=>'200']).'<br/><br/>';
}

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();





