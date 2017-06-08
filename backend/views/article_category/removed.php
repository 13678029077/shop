<?=\yii\bootstrap\Html::a('返回首页',['article_category/index'],['class'=>'btn btn-info btn-sm'])?><br/><br/>
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
                    <?=\yii\bootstrap\Html::a('还原',['article_category/rechange','id'=>$cate->id],['class'=>' btn btn-primary btn-xs'])?>
                </td>
            </tr>
        <?php endforeach;?>
    </table>


    <!--
    --><?php /*echo \yii\widgets\LinkPager::widget([
            'pagination'=>$pages,
            'nextPageLabel'=>'下一页',
            'prevPageLabel'=>'上一页',
            ]);
*/?>