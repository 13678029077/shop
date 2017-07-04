<?php
/**
 *@var $this \yii\web\View
 */
$this->registerCssFile('@web/style/fillin.css');
$this->registerJsFile('@web/js/cart2.js',['depends'=>\yii\web\JqueryAsset::className()]);

?>

<!-- 主体部分 start -->
<div class="fillin w990 bc mt15">
<form action="cart2.html" method="post">
        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>

    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <div class="address">
            <h3>收货人信息</h3>
            <div class="address_info">
                    <?php foreach ($address as $k=>$ads):?>
                       <!-- --><?php /*var_dump($ads)*/?>
                       <p class="member_address"> <input type="radio"  value="<?=$ads['id']?>" <?=$k==0?'checked':''?> name="address"/>
                           <?=$ads['name'].'&nbsp&nbsp&nbsp'.$ads['tel'].'&nbsp&nbsp&nbsp'.$ads['province'].'&nbsp&nbsp&nbsp'.$ads['city'].'&nbsp&nbsp&nbsp'.$ads['area']?>
                           </p>
                   <?php endforeach ;?>
            </div>
        </div>
        <!-- 收货人信息  end-->

        <!-- 配送方式 start -->
        <div class="delivery">
            <h3>送货方式 </h3>


            <div class="delivery_select">
                <table>
                    <thead>
                    <tr>
                        <th class="col1">送货方式</th>
                        <th class="col2">运费</th>
                        <th class="col3">运费标准</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach (\frontend\models\Order::$delivery_method as $k=>$delivery):?>
                    <tr <?=$k==0?'class="cur"':'' ?> >
                        <td>
                            <input class="delivery_td" type="radio" name="delivery_id" <?=$k==0?'checked':'' ?> value="<?=$delivery['id']?>" /><?=$delivery['method']?>
                        </td>
                        <td><?=number_format($delivery['price'],2,'.','')?>￥</td>
                        <td><?=$delivery['intro']?></td>
                    </tr>
                    <?php endforeach;?>
                 <!-- <tr>
                        <td><input type="radio" name="delivery" />特快专递</td>
                        <td>￥40.00</td>
                        <td>每张订单不满499.00元,运费40.00元, 订单4...</td>
                    </tr>-->
                    </tbody>
                </table>
            </div>
        </div>
        <!-- 配送方式 end -->

        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式 </h3>
            <div class="pay_select">
                <table >
                    <?php foreach (\frontend\models\Order::$payment_method as $k=>$payment):?>
                    <tr <?=$k==0?'class="cur"':'' ?> >
                        <td class="col1"><input type="radio" class="payment_td" <?=$k==0?'checked':'' ?>  name="payment_id" value="<?=$payment['id']?>"/> <?=$payment['method'];?></td>
                        <td class="col2"><?=$payment['intro'];?></td>
                    </tr>
                    <?php endforeach;?>
<!--                    <tr>
                        <td class="col1"><input type="radio" name="pay" />在线支付</td>
                        <td class="col2">即时到帐，支持绝大数银行借记卡及部分银行信用卡</td>
                    </tr>-->
                </table>

            </div>
        </div>
        <!-- 支付方式  end-->

        <!-- 发票信息 start-->
        <!--<div class="receipt none">
            <h3>发票信息 </h3>
            <div class="receipt_select ">
                <form action="">
                    <ul>
                        <li>
                            <label for="">发票抬头：</label>
                            <input type="radio" name="type" checked="checked" class="personal" />个人
                            <input type="radio" name="type" class="company"/>单位
                            <input type="text" class="txt company_input" disabled="disabled" />
                        </li>
                        <li>
                            <label for="">发票内容：</label>
                            <input type="radio" name="content" checked="checked" />明细
                            <input type="radio" name="content" />办公用品
                            <input type="radio" name="content" />体育休闲
                            <input type="radio" name="content" />耗材
                        </li>
                    </ul>
                </form>

            </div>
        </div>-->
        <!-- 发票信息 end-->

        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table>
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $count =0;
                $money = 0;
                foreach ($goods as $good):?>
                <tr>
                    <td class="col1"><a href=""><?=\yii\helpers\Html::img('http://admin.shop.com'.$good['logo'])?></a>  <strong><a href=""><?=$good['name']?></a></strong></td>
                    <td class="col3"><?=$good['shop_price']?></td>
                    <td class="col4"><?=$good['amount']?></td>
                    <td class="col5"><span>￥<?=number_format($good['amount']*$good['shop_price'],2,'.','')?></span></td>
                </tr>
                <?php
                $money += $good['shop_price']*$good['amount'];
                $count++;
                endforeach;?>

               <!-- <tr>
                    <td class="col1"><a href=""><?/*=\yii\helpers\Html::img('@web/images/cart_goods2.jpg')*/?></a> <strong><a href="">九牧王王正品新款时尚休闲中长款茄克EK01357200</a></strong></td>
                    <td class="col3">￥1102.00</td>
                    <td class="col4">1</td>
                    <td class="col5"><span>￥1102.00</span></td>
                </tr>-->
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>
                                <span><?=$count?> 件商品，总商品金额：</span>
                                <em>￥<span class="money"><?=number_format($money,2,'.','')?></span></em>
                            </li>-<br/>
                            <li>
                                <span>运费：</span>
                                <em><span class="money">0.00</span></em>
                            </li>
                            <li>
                                <span>应付总额：</span>
                                <input type="hidden" name="total_money" class="total_money_input"/>
                                <em>￥<span class="total_money">0.00</span></em>
                            </li>
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>

    <div class="fillin_ft">
       <button type="submit" class="submit_order" style="width:140px;height:34px;float:right;margin:6px;color:white;background: #da3845;font:16px/0 微软雅黑;"><span>提交订单</span></button>
        <p >应付总额：<span style="color:red">￥<strong class="total_money" >0.00</strong>元</span></p>
    </div>

<!-- 主体部分 end -->
</form>


<script type="text/javascript">
    //头部导航栏JS
    var money=0;
    $(function(){
        $('.flow ul').find('li:eq(0)').attr('class','');
        $('.flow ul').find('li:eq(1)').attr('class','cur');
        $('.cur').closest('div').addClass('flow2');

        //页面加载完成运费自动生成
        tr= $('.delivery_td:checked').closest('tr');
        delivery =$(tr).find('td:eq(1)').html();
        $('.money:eq(1)').html(delivery);

        //商品总价格计算

            money =parseInt($('.money:eq(0)').html()) + parseInt($('.money:eq(1)').html());
            // money.toFixed(2);
             if( parseInt($('.money:eq(0)').html())!=0 ){
                 $('.total_money').html(money.toFixed(2));
                 $('.total_money_input').val(money.toFixed(2));
             };
    });

    //改变时更改运费。从新计算价格
    $('.delivery_td').on('change',function(){
        tr=this.closest('tr');
        delivery =$(tr).find('td:eq(1)').html();
        $('.money:eq(1)').html(delivery);
        //计算运费
        money =parseInt($('.money:eq(0)').html()) + parseInt($('.money:eq(1)').html());
        // money.toFixed(2);
        if( parseInt($('.money:eq(0)').html())!=0 ){
            $('.total_money').html(money.toFixed(2));
            $('.total_money_input').val(money.toFixed(2));
        };

        //表格格式
        all_tr = $(tr).closest('tbody').find('tr');
        all_tr.each(function(){
            $(this).attr('class','');
        })
        $(tr).attr('class','cur');
    });

    //支付方式表格格式
    $('.payment_td').on('change',function(){
        //找到改行
        tr=this.closest('tr');
        //表格格式
        all_tr = $(tr).closest('tbody').find('tr');
        all_tr.each(function(){
            $(this).attr('class','');
        })
        $(tr).attr('class','cur');
    });

</script>