<?php
/**
 * @var $this \yii\web\View
 */
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile('http://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$("#table").DataTable({});');

?>

<?=\yii\bootstrap\Html::a('添加菜单',['menu/add-menu'],['class'=>'btn btn-info btn-sm'])?><br/><br/>
    <table class="table table-bordered table-hover table-striped" id="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>路由</th>
            <th>上级菜单</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach ($menus as $menu): ?>
            <tr>
                <td><?=$menu->id?></td>
                <td><?=$menu->label?></td>
                <td><?=$menu->url?></td>
                <td><?=$menu->parent_id?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('',['menu/edit-menu','id'=>$menu->id],['class'=>'glyphicon glyphicon-pencil btn btn-primary btn-xs'])?>&nbsp&nbsp
                    <?=\yii\bootstrap\Html::a('',['menu/delete-menu','id'=>$menu->id],['class'=>'glyphicon glyphicon-trash btn btn-danger btn-xs'])?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

