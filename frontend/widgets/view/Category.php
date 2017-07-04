<!--一级分类--->
<?php foreach ($category as $k=>$item1):?>
    <div class="cat <?=$k==0?' item1"':'';?>" >
        <h3><a href="list.html?cate=<?=$item1['id']?>"><?=$item1['name']?></a> <b></b></h3>
        <div class="cat_detail">

            <?php foreach ($item1->children as $n=>$item2):?>
                <dl <?=$k==0?'class="dl_1st"':'';?>>
                    <dt><a href="list.html?cate=<?=$item2['id']?>"><?=$item2['name']?></a></dt>
                    <dd>

                        <?php foreach ($item2->children as $m=>$item3):?>
                            <a href="list.html?cate=<?=$item3['id']?>"><?=$item3['name']?></a>
                        <?php endforeach; ?>
                    </dd>
                </dl>
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach;?>