<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>
<body >
   <table border="2">
   <th>序号</th><th>歌名</th><th>点歌次数</th><th>累计点赞数</th><th>综合热门度</th>

@foreach($list as $lists)

<tr>
<td>{{$lists->id}}</td>
{{--<td>{{$lists->recieve_name}}</td>--}}
{{--<td>{{$lists->content}}</td>--}}
{{--<td>{{$lists->send_name}}</td>--}}
{{--<td>{{$lists->goods}}</td>--}}

</tr>
@endforeach


   </table>
   <form action="" method="get">
   <input type="text" name="time">
   <input type="text" name="way">
   <input type="text" name="type"><input type="submit" value="ok"></form>
</body>
</html>