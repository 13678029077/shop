<style>
    body{background: lightgoldenrodyellow}
    select,input{height:28px;}
    #search{height:30px;font:14px/1px 微软雅黑;}
    #min,#max{width:150px;}
</style>
<?=\yii\bootstrap\Html::a('添加商品',['goods/add'],['class'=>'btn btn-info btn-sm','style'=>'float:left;'])?><br/><br/><br/>
<!--商品名收索-->
<!--
<form action="index" method="get" class="form-inline">
     名称：<input type="search" name="name" placeholder="商品名称" class="form-control" >
     SN: <input type="search" name="sn" placeholder="SN" class="form-control" >
     品牌：  <select name="brand" class="form-control" >-->
               <!-- <option value="0"><----按品牌查找----></option>
              <!--  <?php /*foreach($brands as $brand):*/?>
                    <option value="<?/*=$brand->id*/?>">--<?/*=$brand->name*/?>--</option>
                <?/* endforeach;*/?>
         </select>
     价格：<input type="search" name="min_price" id="min" class="form-control" placeholder="down"> —
         <input type="search" name="max_price" id="max"  class="form-control" placeholder="up" >
    <button type="submit" class="btn btn-info " id="search"">收索</button>
</form><br/><br/>
-->


<!--商品列表展示-->
<table class="table table-hover table-border" id="sample-table">
    <thead>
    <tr>
        <th>ID</th>
        <th>name</th>
        <th>SN</th>
        <th>logo</th>
        <th>所属分类</th>
        <th>品牌</th>
        <th>市场价</th>
        <th>商城价</th>
        <th>库存</th>
        <th>是否在售</th>
        <th>状态</th>
        <th>排序号</th>
        <th>添加时间</th>

        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php  foreach($goods as $good){ ?>
        <tr>
            <td><?=$good->id?></td>
            <td> <?=\yii\bootstrap\Html::a($good->name,['goods/content','id'=>$good->id])?></td>
            <td><?=$good->sn?></td>
            <td><?=$good->logo ? "<img src='{$good->logo}' style='width:60px;height:35px;'>" : '1' ;?></td>
            <td><?=$good->goods_category_id ? $good->goods_category->name :'';?></td>
            <td><?=$good->brand_id ? $good->brand->name : ''?></td>
            <td><?=$good->market_price.'￥'?></td>
            <td><?=$good->shop_price.'￥'?></td>
            <td><?=$good->stock?></td>
            <td><?=$good->is_on_sale?'<span class="glyphicon glyphicon-ok"></span>': '<span class="glyphicon glyphicon-remove"></span>';?></td>
            <td><?=\backend\models\Goods::$status[$good->status]?></td>
            <td><?=$good->sort?></td>
            <td><?=date('Y-m-d',$good->create_time)?></td>
            <td>
                <?php if (Yii::$app->user->can('goods/edit')) echo \yii\bootstrap\Html::a('',['goods/edit','id'=>$good->id],['class'=>'glyphicon glyphicon-pencil btn btn-info btn-xs'])?>
                <?php if (Yii::$app->user->can('goods/delete')) echo \yii\bootstrap\Html::a('',['goods/delete','id'=>$good->id],['class'=>'glyphicon glyphicon-trash btn btn-danger btn-xs'])?>
                <?php if (Yii::$app->user->can('goods/pic_index')) echo \yii\bootstrap\Html::a('相册',['goods/pic_index','id'=>$good->id],['class'=>'btn btn-info btn-xs'])?>
            </td>
        </tr>
    <?php };?>
    </tbody>
</table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);
?>


<?php
/**
 * @var $this \yii\web\View
 */
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile('http://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$(".table").DataTable({});');

?>
