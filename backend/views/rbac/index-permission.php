<?=\yii\bootstrap\Html::a('添加权限',['rbac/add-permission'],['class'=>'btn btn-info btn-sm'])?><br/><br/>
    <table class="table table-bordered table-hover table-striped">
        <thead>
        <tr>
            <th>权限名称</th>
            <th>简介</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach ($models as $model): ?>
            <tr>
                <td><?=$model->name?></td>
                <td><?=$model->description?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('',['rbac/edit-permission','name'=>$model->name],['class'=>'glyphicon glyphicon-pencil btn btn-primary btn-xs'])?>&nbsp&nbsp
                    <?=\yii\bootstrap\Html::a('',['rbac/del-permission','name'=>$model->name],['class'=>'glyphicon glyphicon-trash btn btn-danger btn-xs'])?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

<?php
/**
 * @var $this \yii\web\View
 */
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile('http://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$(".table").DataTable({});');

?>




    <!--
--><?php
/*echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);*/
