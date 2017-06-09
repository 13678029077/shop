<?=\yii\bootstrap\Html::a('添加文章分类',['article_category/add'],['class'=>'btn btn-info btn-sm','style'=>'float:left;'])?><br/><br/>
<?=\yii\bootstrap\Html::a('回收站',['article_category/removed'],['class'=>'btn btn-info btn-sm btn-warning','style'=>'float:right'])?><br/><br/>

    <table class="table table-bordered table-hover table-striped">
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>简介</th>
            <th>排序号</th>
            <th>状态</th>
            <th>类型</th>
            <th>操作</th>
        </tr>
        <?php  foreach ($cates as $cate): ?>
            <tr>
                <td><?=$cate->id?></td>
                <td><?=$cate->name?></td>
                <td><?=$cate->intro?></td>
                <td><?=$cate->sort?></td>
                <td><?=\backend\models\Article_Category::$status[$cate->status]?></td>
                <td><?=$cate->is_help ? '帮助' : '其他'?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('',['article_category/edit','id'=>$cate->id],['class'=>'glyphicon glyphicon-pencil btn btn-primary btn-xs'])?>&nbsp&nbsp
                    <?=\yii\bootstrap\Html::a('',['article_category/delete','id'=>$cate->id],['class'=>'glyphicon glyphicon-trash btn btn-danger btn-xs'])?>

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
