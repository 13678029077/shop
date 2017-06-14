<?=\yii\bootstrap\Html::a('<< 返回',['goods/index'],['class'=>'btn btn-info btn-sm','style'=>'float:left;'])?><br/><br/><br/>
<!--商品列表展示-->
<table class="table table-bordered table-hover table-striped">
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
    <?php  foreach ($goods as $good): ?>
        <tr>
            <td><?=$good->id?></td>
            <td><?=$good->name?></td>
            <td><?=$good->sn?></td>
            <td><?=$good->logo ? "<img src='{$good->logo}' style='width:60px;height:35px;'>" : '1' ;?></td>
            <td><?=$good->goods_category->name?></td>
            <td><?=$good->brand->name?></td>
            <td><?=$good->market_price.'￥'?></td>
            <td><?=$good->shop_price.'￥'?></td>
            <td><?=$good->stock?></td>
            <td><?=$good->is_on_sale?'是': '否';?></td>
            <td><?=\backend\models\Goods::$status[$good->status]?></td>
            <td><?=$good->sort?></td>
            <td><?=date('Y-m-d',$good->create_time)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('还原',['goods/readd','id'=>$good->id],['class'=>'btn btn-warning btn-sm'])?>&nbsp&nbsp
            </td>
        </tr>
    <?php endforeach;?>
</table>