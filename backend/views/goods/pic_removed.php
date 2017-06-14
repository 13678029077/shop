<style>
    .pic_box{background:aliceblue;margin-top:30px;width:1200px;margin 0 auto;border:1px solid rgba(243,200,109,0.2);min-height: 400px}
    .pic_box ul li{list-style: none;width:120px;height:80px;float:left;margin:20px 20px 20px 0;}
    .title{ color:#a9a4fa ;font:30px/60px 微软雅黑;}
    .ag{font:20px/20px 微软雅黑;}
    i{color:#f887ff}
    span a{font:16px/10px 微软雅黑;color:white}

</style>

<div class ="title_box">
    <span class="glyphicon glyphicon-backward btn btn-info btn-sm"><a href="pic_index?id=<?=$good->id?>"> 返 回</a></span>
    <span class="title"><?=$good->name?><span class="ag"> >> <i>回收站</i></span></span>

<div class="pic_box">
    <ul>
        <?php  foreach ($pictures as $p): ?>
            <li><?="<img src=".$p->img." style='width:100px;height:80px;border:5px solid white'>" ?><br/>
                <?=\yii\bootstrap\Html::a('还原',['goods/pic_readd','id'=>$p->id,'goods_id'=>$good->id],['class'=>' btn btn-info btn-xs','style'=>'margin-left:5px;'])?>
            </li>
        <?php endforeach;?>

    </ul>

</div>



