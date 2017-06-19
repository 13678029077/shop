<?=\yii\bootstrap\Html::a('添加文章分类',['article_category/add'],['class'=>'btn btn-info btn-sm','style'=>'float:left;'])?><br/><br/>

    <table class="table table-bordered table-hover table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>简介</th>
            <th>排序号</th>
            <th>状态</th>
            <th>类型</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
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