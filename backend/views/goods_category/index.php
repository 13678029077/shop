<?=\yii\bootstrap\Html::a('添加商品分类',['goods_category/add'],['class'=>'btn btn-info btn-sm'])?><br/><br/>
    <table class="table table-bordered table-hover table-striped">
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>父id</th>
            <th>操作</th>
        </tr>
        <?php  foreach ($cates as $v): ?>
            <tr>
                <td><?=$v['id']?></td>
                <td><?=$v['name']?></td>
                <td><?=$v['parent_id']?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('',['goods_category/edit','id'=>$v['id']],['class'=>'glyphicon glyphicon-pencil btn btn-primary btn-xs'])?>&nbsp&nbsp
                    <?=\yii\bootstrap\Html::a('',['goods_category/delete','id'=>$v['id']],['class'=>'glyphicon glyphicon-trash btn btn-danger btn-xs'])?>
                </td>
            </tr>
        <?php endforeach;?>
    </table>

<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);
