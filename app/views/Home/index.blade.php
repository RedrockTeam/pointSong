<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>
<body >
   <table border="2">
   <th>歌名</th><th>对方姓名</th><th>内容</th><th>点歌用户</th><th>时间</th><th>点赞数</th><th>操作</th>

@foreach($list as $lists)

<tr>
<td>{{$lists->music}}</td>
<td>{{$lists->recieve_name}}</td>
<td>{{$lists->content}}</td>
<td>{{$lists->send_name}}</td>
<td>{{date('Y-m-d H:i:s',$lists->time)}}</td>
<td>{{$lists->goods}}</td>
<td>
 <a href="">删除 </a><a href="" >播出</a>

</td>
</tr>
@endforeach


   </table>
   <form action="{{URL::action('MusicController@getOrderbytime')}}" method="get">
   <input type="text" name="time">
   <input type="text" name="way">
   <input type="text" name="type"><input type="submit" value="ok"></form>
</body>
</html>