<?php
header('Content-type:text/html; charset=utf-8');

//1.创建dom对象
//2.加载文件
$xml = simplexml_load_file('weather.xml');
//3.解析
$data = [];
foreach($xml->city as $city){
    if((string)$city['cityname'] == "成都"){
        //获得成都的天气
        $data['cityname']       =   (string)$city['cityname'];
        $data['stateDetailed']  =   (string)$city['stateDetailed'];
        $data['maxtem']         =   (string)$city['tem1'];
        $data['mintem']         =   (string)$city['tem2'];
        $data['nowtem']         =   (string)$city['temNow'];
        $data['windState']      =   (string)$city['windState'];
        $data['windPower']      =   (string)$city['windPower'];
    }
}
?>
<table border="1" width="800px " cellpadding="0" cellspacing="0">
    <tr>
        <th>城市</th>
        <th>天气情况</th>
        <th>最高温度</th>
        <th>最低温度</th>
        <th>当前温度</th>
        <th>风力</th>
    </tr>
    <tr>
        <td><?=$data['cityname']?></td>
        <td><?=$data['stateDetailed']?></td>
        <td><?=$data['maxtem']?>摄氏度</td>
        <td><?=$data['mintem']?>摄氏度</td>
        <td><?=$data['nowtem']?>摄氏度</td>
        <td><?=$data['windState']?><?=$data['windPower']?></td>
    </tr>
</table>
