<?=\yii\bootstrap\Html::a('添加文章',['article/add'],['class'=>'btn btn-info btn-sm','style'=>'float:left;'])?><br/><br/><br/>
    <table class="table table-bordered table-hover table-striped">
        <thead>
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
        </thead>
    <tbody>
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
                    <?php if (Yii::$app->user->can('article/edit')) echo \yii\bootstrap\Html::a('',['article/edit','id'=>$article->id],['class'=>'glyphicon glyphicon-pencil btn btn-info btn-xs'])?>
                    <?php if (Yii::$app->user->can('article/delete')) echo \yii\bootstrap\Html::a('',['article/delete','id'=>$article->id],['class'=>'glyphicon glyphicon-trash btn btn-danger btn-xs'])?>
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

?>