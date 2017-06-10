<?=\yii\bootstrap\Html::a('添加文章',['article/add'],['class'=>'btn btn-info btn-sm','style'=>'float:left;'])?><br/><br/><br/>
    <table class="table table-bordered table-hover table-striped">
        <tr>
            <th>ID</th>
            <th>文章标题</th>
            <th>简介</th>
            <th>分类名</th>
            <th>排序号</th>
            <th>状态</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
        <?php  foreach ($articles as $article): ?>
            <tr>
                <td><?=$article->id?></td>
                <td><?=\yii\bootstrap\Html::a("{$article->name}",["article/article_content",'id'=>$article->id])?></td>
                <td><?=$article->intro?></td>
                <td><?=$article->catename->name?></td>
                <td><?=$article->sort?></td>
                <td><?=\backend\models\Article_Category::$status[$article->status]?></td>
                <td><?=date('Y-m-d h:s',$article->create_time)?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('',['article/edit','id'=>$article->id],['class'=>'glyphicon glyphicon-pencil btn btn-primary btn-xs'])?>&nbsp&nbsp
                    <?=\yii\bootstrap\Html::a('',['article/delete','id'=>$article->id],['class'=>'glyphicon glyphicon-trash btn btn-danger btn-xs'])?>

                </td>
            </tr>
        <?php endforeach;?>
    </table>
<?php
/*echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);*/
