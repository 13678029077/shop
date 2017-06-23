

<?=\yii\bootstrap\Html::a('添加商品分类',['goods_category/add'],['class'=>'btn btn-info btn-sm'])?><br/><br/>
    <table class="table table-bordered table-hover table-striped">
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>操作</th>
        </tr>
        <?php  foreach ($cates as $v): ?>
            <tr class="cate" data-lft="<?=$v->lft?>" data-rgt="<?=$v->rgt?>" data-tree="<?=$v->tree?>">
                <td><?=$v['id']?></td>
                <td><?=str_repeat('—',$v['depth']*3).$v['name']?>
                    <span class="toggle_cate glyphicon glyphicon-chevron-down" style="float:right"></span>
                </td>
                <td>
                    <?php if (Yii::$app->user->can('goods_category/edit')) echo \yii\bootstrap\Html::a('',['goods_category/edit','id'=>$v['id']],['class'=>'glyphicon glyphicon-pencil btn btn-warning btn-xs'])?>
                    <?php if (Yii::$app->user->can('goods_category/delete')) echo \yii\bootstrap\Html::a('',['goods_category/delete','id'=>$v['id']],['class'=>'glyphicon glyphicon-trash btn btn-danger btn-xs '])?>
                </td>
            </tr>
        <?php endforeach;?>
    </table >
<?PHP
    $JS = <<<JS
    
        $(".toggle_cate").click(function(){
            //查找所有子分类,根据tree
            var tr = $(this).closest('tr')
            var tree = tr.attr('data-tree')-0;
            var lft = tr.attr('data-lft')-0;
            var rgt = tr.attr('data-rgt')-0;
             var show = $(this).hasClass('glyphicon-chevron-up');
            //切换图标
            $(this).toggleClass('glyphicon-chevron-down');
            $(this).toggleClass('glyphicon-chevron-up');

              
               //console.debug($(".cate"));
            $(".cate").each(function(){
                if(parseInt($(this).attr('data-tree'))==tree && parseInt($(this).attr('data-lft'))>lft && parseInt($(this).attr('data-rgt')-0)<rgt){
                      show? $(this).fadeIn() : $(this).fadeOut();
                }
            });
        });

JS;
$this->registerJs($JS);

