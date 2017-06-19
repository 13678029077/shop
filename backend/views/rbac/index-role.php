<?=\yii\bootstrap\Html::a('添加角色',['rbac/add-role'],['class'=>'btn btn-info btn-sm'])?><br/><br/>
<table class="table table-bordered table-hover table-striped">
    <tr>
        <th>角色名称</th>
        <th>简介</th>
        <th>拥有权限</th>
        <th>操作</th>
    </tr>
    <?php  foreach ($models as $model): ?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->description?></td>
            <td style="width:800px"><?php
                    foreach (Yii::$app->authManager->getPermissionsByRole($model->name) as $p){
                        echo $p->description;
                        echo ' / ';
                    }

                ?></td>
            <td>
                <?=\yii\bootstrap\Html::a('',['rbac/edit-role','name'=>$model->name],['class'=>'glyphicon glyphicon-pencil btn btn-primary btn-xs'])?>&nbsp&nbsp
                <?=\yii\bootstrap\Html::a('',['rbac/del-role','name'=>$model->name],['class'=>'glyphicon glyphicon-trash btn btn-danger btn-xs'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
