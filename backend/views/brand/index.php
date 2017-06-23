<?=\yii\bootstrap\Html::a('添加品牌',['brand/add'],['class'=>'btn btn-info btn-sm'])?><br/><br/>
    <table class="table table-bordered table-hover table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>简介</th>
            <th>Logo</th>
            <th>排序号</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach ($brands as $brand): ?>
            <tr>
                <td><?=$brand->id?></td>
                <td><?=$brand->name?></td>
                <td><?=$brand->intro?></td>
                <td><?="<img src=".$brand->logo." style='width:60px;height:40px;'>" ?></td>
                <td><?=$brand->sort?></td>
                <td><?=\backend\models\Brand::$status[$brand->status]?></td>
                <td>
                    <?php if (Yii::$app->user->can('brand/edit')) echo \yii\bootstrap\Html::a('',['brand/edit','id'=>$brand->id],['class'=>'glyphicon glyphicon-pencil btn btn-info btn-xs'])?>
                    <?php if (Yii::$app->user->can('brand/delete')) echo \yii\bootstrap\Html::a('',['brand/delete','id'=>$brand->id],['class'=>'glyphicon glyphicon-trash btn btn-danger btn-xs'])?>

                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

<?php
/*echo \yii\widgets\LinkPager::widget([
        'pagination'=>$page,
        'nextPageLabel'=>'下一页',
        'prevPageLabel'=>'上一页',
]);*/


/**
 * @var $this \yii\web\View
 */
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile('http://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$(".table").DataTable({});');



