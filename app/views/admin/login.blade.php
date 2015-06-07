<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="{{__PUBLIC__.'/css/bootstrap.min.css'}}" />
<link rel="stylesheet" type="text/css" href="{{__PUBLIC__.'/css/login.css'}}" />
</head>
<body class="login-body">
    {{Form::open(array('action' => 'AdminController@doLogin','method' => 'post'))}}
		<div class="login-form">
			<div class="form-group">
                {{Form::text('username','',array('class' => 'form-control login-field' , 'placeholder' => '请输入用户名' ,'id' => 'login-name'))}}
			</div>

			<div class="form-group">
                {{Form::password('password',array('class' => 'form-control login-field' , 'placeholder' => '请输入密码' ,'id' => 'login-pass'))}}
			</div>
            {{Form::submit('login',array('class' => 'btn btn-primary btn-lg btn-block'))}}
		</div>
    {{Form::close()}}
</body>
</html>