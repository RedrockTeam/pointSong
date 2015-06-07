<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>
<body >

@foreach($list as $lists)
   <table border="2">

<tr><td>标题</td><td>{{$lists->title}}</td></tr>
<tr><td>内容</td><td>{{$lists->content}}</td></tr>
{{--<tr><td></td><td>{{$lists->music}}</td></tr>--}}
{{--<tr><td></td><td>{{$lists->music}}</td></tr>--}}
<tr><td>时间</td><td>{{date('Y-m-d H:i:s',$lists->time)}}</td></tr>
   </table>

@endforeach


   <form action="{{URL::action('MusicController@getOrderbytime')}}" method="get">
   <input type="text" name="time">
   <input type="text" name="way">
   <input type="text" name="type"><input type="submit" value="ok"></form>
</body>
</html>