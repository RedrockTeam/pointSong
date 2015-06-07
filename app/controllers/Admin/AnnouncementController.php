<?php

class AnnouncementController extends \BaseController {

	/**
	 * 公告管理
     * 默认显示（时间逆序）
	 */
	public function getIndex()
	{
        $page=strip_tags($_GET['anNum']);
        $page=$page*5;
        $all=DB::table('announcement')->orderby('time','desc')->skip($page)->take(5)->get();
        foreach($all as $k){
            $k->datetime=date("Y-m-d",$k->time);
        }
        return $all=json_encode($all);
	}


	/**
	 * 发布新公告
     *
	 */
	public function postCreate()
	{
        $page=strip_tags($_POST['anNum']);
        $page=$page*5;
        $title=strip_tags($_POST['title']);
        $content=strip_tags($_POST['control']);
        if($title==null||$content==null){
            return $all=json_encode(100);
        }else {
            $addnews = new Announcement;
            $addnews->title = $title;
            $addnews->content = $content;
            $addnews->time = time();
            $addnews->save();
            $all = DB::table('announcement')->orderby('time', 'desc')->skip($page)->take(5)->get();
            return $all = json_encode($all);
        }
    }

}
