<?php

class AdminController extends \BaseController {

    public function login(){
        Session::put('admin_is_login',0);

        return View::make('Admin.login');

    }

    public function doLogin(){
        $validator = Validator::make(
            $user = Input::only('username','password'),
            array(
                'username' => 'required',
                'password' => 'required'
            )
        );
        if(! $validator -> fails()){
            //数据填写完整

            $user['password'] = md5($user['password']);
            $result = DB::select("SELECT id FROM admin WHERE username = ? AND password = ?",array($user['username'],$user['password']));
            if($result){
                //登陆成功

                Session::put('admin_is_login',1);
                return Redirect::to('music/index');
            }else{
                //账号或密码错误
                return Redirect::to('admin/login');
            }
        }else{
            //数据填写不完整
            return Redirect::to('admin/login');
        }
    }


}
