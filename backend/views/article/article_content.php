<?php
echo \yii\bootstrap\Html::a('<< 返 回','index',['class'=>'btn btn-info btn-sm']);
echo '&nbsp&nbsp';
echo \yii\bootstrap\Html::a('<span class="glyphicon glyphicon-pencil"></span> 修 改',['article/edit','id'=>$title->id],['class'=>'btn btn-info btn-sm btn-warning','id'=>$title->id]);

echo \yii\bootstrap\Html::tag('H1',$title->name,['style'=>'text-align:center;color:#f82aa1;font-size:40px;padding-bottom:40px']);
echo \yii\bootstrap\Html::tag('div',$content->content,['style'=>'height:400px;text-indent:40px;color:#55f754;font-size:20px;border:1px solid rgba(27,38,200,0.2)'])

?>


