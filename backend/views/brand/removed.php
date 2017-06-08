<?=\yii\bootstrap\Html::a('返回首页',['brand/index'],['class'=>'btn btn-info btn-sm'])?><br/><br/>
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
                    <?=\yii\bootstrap\Html::a('还原',['brand/rechange','id'=>$brand->id],['class'=>' btn btn-primary btn-xs'])?>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
