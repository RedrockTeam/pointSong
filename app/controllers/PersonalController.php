<?php

class PersonalController extends \BaseController {

	/**
	 * 个人中心
	 */
	public function getIndex()
	{
        $send_name=Session::get('nickname');
        $img=Session::get('headurlimage');
        $praise=DB::table('praise')->where('user_id',$send_name)->count(); //显示用户点赞数
        $push=DB::table('music')->where('send_name',$send_name)->count(); //显示用户发表过点歌数量
        $used=DB::table('music')->where('send_name',$send_name)->where('status','1')->count();//用户发表的已经被采纳的点歌数量
		return View::make('mobile.personal')->with(array('name'=>$send_name,'img'=>$img,'used'=>$used,'push'=>$push,'praise'=>$praise));
	}




	/**个人中心
     * 已采纳
	 * 显示预加载的已播放的点播歌曲
	 */
	public function getShow()
    {
        $send_name=Session::get('nickname');
        $page=strip_tags($_GET['perNum']);
        //$page=0;
        $page=$page*5;
        $listPush = DB::table('music')->where('send_name', $send_name)->where('status', '1')->orderby('time', 'desc')->skip($page)->take(5)->get();
        foreach($listPush as $k){
            $isPraise = Praise::where('bepraise_id', '=', $k->id)->where('user_id', '=', $send_name)->pluck('id');
            if($isPraise)
            {
                $k->isPraise=1;
            }else{
                $k->isPraise=0;
            }
            if($k->is_sayname==1){
                $k->nickname="匿名";
                $k->img=  __PUBLIC__.'/img/nickname.png';
            }else{
                $k->nickname=$k->send_name;
                $k->img=$k->head_image;
            }
        $k->datetime=date("Y-m-d",$k->time);
        }
        return json_encode($listPush);

    }
/**个人中心
 * 已发布
 * 预加载5条
 */
    public function getSay()
    {
        $send_name=Session::get('nickname');
        $page=strip_tags($_GET['perNum']);
//        $page=0;
        $page=$page*5;
        $listPush = DB::table('music')->where('send_name',$send_name)->where('status','<','3')->orderby('time', 'desc')->skip($page)->take(5)->get();
       // $praised=DB::table('praise')->select('bepraise_id')->where('user_id','123')->get();
        foreach($listPush as $k){
        $isPraise = Praise::where('bepraise_id', '=', $k->id)->where('user_id', '=', $send_name)->pluck('id');
         if($isPraise)
         {
             $k->isPraise=1;
         }else{
             $k->isPraise=0;
         }
          if($k->status==1){
              $k->accept=1;
          }else{
              $k->accept=0;
          }
            if($k->is_sayname==1){
                $k->img= __PUBLIC__.'/img/nickname.png';
                $k->nickname="匿名";
            }else{
                $k->nickname=$k->send_name;
                $k->img=$k->head_image;

            }
            $k->datetime=date("Y-m-d",$k->time);

        }
        return json_encode($listPush);

    }

    /**个人中心
     * 加载新的信息每次5条
     *
     */
    public  function getDisplay(){
        $send_name=Session::get('nickname');
        $page=strip_tags( $_GET['perNum']);
        $now=strip_tags($_GET['nowNum']);//当前所在页面
        $page=$page*5;
        if($now==0) {
            $listPush = DB::table('music')->where('send_name',  $send_name)->where('status','<','3')->orderby('time', 'desc')->skip($page)->take(5)->get();
        }else{
            $listPush = DB::table('music')->where('send_name',  $send_name)->where('status','1')->orderby('time', 'desc')->skip($page)->take(5)->get();
        }
        foreach($listPush as $k){
            $isPraise = Praise::where('bepraise_id', '=', $k->id)->where('user_id',  $send_name)->pluck('id');
            if($isPraise)
            {
                $k->isPraise=1;
            }else{
                $k->isPraise=0;
            }
            if($k->status==1){
                $k->accept=1;
            }else{
                $k->accept=0;
            }
            if($k->is_sayname==1){
                $k->nickname="匿名";
                $k->img= __PUBLIC__.'/img/nickname.png';
            }else{
                $k->nickname=$k->send_name;
                $k->img=$k->head_image;

            }
            $k->datetime=date("Y-m-d",$k->time);

        }
            return json_encode($listPush);
    }

	/**
	 * 个人中心
     * 用户删除歌曲、
     * 并没有从数据库删除，只是状态status'变为了3就不会在页面显示了
	 */
	public function getDelete()
	{
		$id=strip_tags($_GET['id']);
        $update = DB::table('music')->where('id', '=',$id)->update(array('status' =>3));
        return json_encode(200);
	}

}
