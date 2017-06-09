<?=\yii\bootstrap\Html::a('添加品牌',['brand/add'],['class'=>'btn btn-info btn-sm'])?><br/><br/>
<?=\yii\bootstrap\Html::a('回收站',['brand/removed'],['class'=>'btn btn-info btn-sm btn-warning','style'=>'float:right'])?><br/><br/>
    <table class="table table-bordered table-hover table-striped">
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>简介</th>
            <th>Logo</th>
            <th>排序号</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        <?php  foreach ($brands as $brand): ?>
            <tr>
                <td><?=$brand->id?></td>
                <td><?=$brand->name?></td>
                <td><?=$brand->intro?></td>
                <td><?="<img src=".$brand->logo." style='width:60px;height:40px;'>" ?></td>
                <td><?=$brand->sort?></td>
                <td><?=\backend\models\Brand::$status[$brand->status]?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('',['brand/edit','id'=>$brand->id],['class'=>'glyphicon glyphicon-pencil btn btn-primary btn-xs'])?>&nbsp&nbsp
                    <?=\yii\bootstrap\Html::a('',['brand/delete','id'=>$brand->id],['class'=>'glyphicon glyphicon-trash btn btn-danger btn-xs'])?>
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
