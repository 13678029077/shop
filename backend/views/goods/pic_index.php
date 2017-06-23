<style>
    .pic_box{background:lightcyan;width:1200px;margin 0 auto;border:1px solid rgba(243,200,109,0.2);overflow:hidden;}
    .pic_box ul li{list-style: none;width:200px;height:180px;float:left;margin:0px 20px 20px 0}
    .title{color:#a9a4fa;font:26px/20px 微软雅黑;}
    .ag{font:20px/20px 微软雅黑;}
    i{color:#f887ff}
    span a{font:16px/10px 微软雅黑;color:white}
</style>
<div class ="title">
    <span class="glyphicon glyphicon-fast-backward btn btn-info btn-sm"><a href="index"> 首页</a></span>
    <span class="title"><?=$good->name?><span class="ag"> >> <i>相册</i></span></span>
</div>

<?=\yii\bootstrap\Html::a('上传商品图片',['goods/pic_add','id'=>$good->id],['class'=>'btn btn-info btn-sm','style'=>'float:right'])?><br/><br/>

<div class="pic_box">
    <ul>
        <?php  foreach ($pictures as $p): ?>
                <li>
                    <?=\yii\bootstrap\Html::a('',['goods/pic_delete','id'=>$p->id,'goods_id'=>$good->id],['class'=>'btn btn-info btn-xs glyphicon glyphicon-remove  remove','style'=>'position:relative;left:166px;top:32px;background:#aaa'])?>
                    <?="<img src=".$p->img." style='width:200px;height:180px;border:10px solid white'>" ?>
                </li>
        <?php endforeach;?>

    </ul>

</div>
