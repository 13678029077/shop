<style>
    body{background: lightgoldenrodyellow}
    select,input{height:28px;}
    h2{margin:10px auto;width:200px;}
</style>
<!--商品名收索-->
<h2>订单详情</h2>
<!--商品列表展示-->
<table class="table table-hover table-border" id="sample-table">
    <thead>
    <tr>
        <th>订单号</th>
        <th>商品SN</th>
        <th>商品名称</th>
        <th>Logo</th>
        <th>单价</th>
        <th>数量</th>
        <th>总价</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
<!--  --><?php  foreach($goods as $good){ ?>
        <tr>

            <td><?=$order->trade_no?></td>
            <td><?=$good->goods->sn?></td>
            <td><?=$good->goods_name?></td>
            <td><?=\yii\bootstrap\Html::img('@web'.$good->logo,['style'=>'width:100px;height:60px;'])?></td>
            <td>￥<?=$good->price?></td>
            <td><?=$good->amount?></td>
            <td>￥<?=($good->amount)*($good->price)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('发货',['order/send','id'=>$order->id])?> | |
                <?=\yii\bootstrap\Html::a('确认收款',['order/money','id'=>$order->id])?>
                <?php /*if (Yii::$app->user->can('goods/edit')) echo \yii\bootstrap\Html::a('',['goods/edit','id'=>$good->id],['class'=>'glyphicon glyphicon-pencil btn btn-info btn-xs'])*/?>
                <?php /*if (Yii::$app->user->can('goods/delete')) echo \yii\bootstrap\Html::a('',['goods/delete','id'=>$good->id],['class'=>'glyphicon glyphicon-trash btn btn-danger btn-xs'])*/?>
                <?php /*if (Yii::$app->user->can('goods/pic_index')) echo \yii\bootstrap\Html::a('相册',['goods/pic_index','id'=>$good->id],['class'=>'btn btn-info btn-xs'])*/?>
            </td>
        </tr>
    <?php };?>
    </tbody>
</table>
<?php
/*echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);
*/?>


<?php
/**
 * @var $this \yii\web\View
 */
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile('http://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$(".table").DataTable({});');

?>
