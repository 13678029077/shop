<style>
    body{background: lightgoldenrodyellow}
    select,input{height:28px;}
    h2{margin:10px auto;width:200px;}
</style>
<?/*=\yii\bootstrap\Html::a('添加商品',['goods/add'],['class'=>'btn btn-info btn-sm','style'=>'float:left;'])*/?><!--<br/><br/><br/>
--><!--商品名收索-->
<h2>订单列表</h2>
<!--商品列表展示-->
<table class="table table-hover table-border" id="sample-table">
    <thead>
    <tr>
        <th>ID</th>
        <th>订单号SN</th>
        <th>用户id</th>
        <th>收货人</th>
        <th>省</th>
        <th>市</th>
        <th>区/县</th>
        <th>电话号码</th>
        <th>运送方式</th>
        <th>运费</th>
        <th>支付方式</th>
        <th>订单总价</th>
        <th>状态</th>
        <th>创建时间</th>

        <th>操作</th>
    </tr>
    </thead>
    <tbody>
<!--  --><?php  foreach($orders as $order){ ?>
        <tr>

            <td><?=$order->id?></td>
            <td><a href="order_info?id=<?=$order->id?>"><?=$order->trade_no?></a></td>
            <td><?=$order->member_id?></td>
            <td><?=$order->name?></td>
            <td><?=$order->province?></td>
            <td><?=$order->city?></td>
            <td><?=$order->area?></td>
            <td><?=$order->tel?></td>
            <td><?=$order->delivery_name?></td>
            <td>￥<?=$order->delivery_price?></td>
            <td><?=$order->payment_name?></td>
            <td>￥<?=$order->total?></td>
            <td><?=$order->status?></td>
            <td><?=date('Y-m-d',$order->create_time)?></td>
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
