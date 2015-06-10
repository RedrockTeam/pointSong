<?php

class MusicController extends \BaseController {


    /**
	 * 歌曲管理
	 *获取所有点歌信息
	 * @return Response
	 */
	public function getIndex()
	{
       // $list=DB::table('music')->skip(5)->take(5)->get();
       // $list=DB::table('music')->limit(0,5);
        //$list=json_encode($list);
	    $status = DB::table('status')->orderby('time', 'desc')->pluck('status');
        if($status==null){
            $status=0;
        }
		return View::make("admin.index")->with('status',$status);
	}




	/**
	 * 歌曲搜索
     * 获取搜索框的搜索结果并显示在歌曲管理页面
	 *
	 * @return Response
	 */
	public function postSearch()
	{
		$search=strip_tags($_POST['search']);
     // $search="dsf";
        $list = DB::table('music')->where('music', 'Like', '%' . $search . '%')->where("status","<","3")->orderBy('time', 'desc')->get();
        foreach($list as $k){
            $k->datetime=date("Y-m-d",$k->time);}
        if($list==null){
            return   $list=json_encode(100);          /*如果搜索结果为空则返回100*/
        }else {
            return $list = json_encode($list);
        }

    }

    /**
     * 数据搜索
     * 获取搜索框的搜索结果并显示在歌曲管理页面
     *
     * @return Response
     */
    public function postFind()
    {
        $search=strip_tags($_POST['searches']);
       //  $search="1";
        $list = DB::table('music')->where('music', 'Like', '%' . $search . '%')->select("id","music", DB::raw('sum(goods) as excellentNum'),DB::raw('count(*) as musicTime' ),DB::raw('sum(goods) *0.4+count(*)*0.6 as comprehensive'))->groupby('music')->get();

        //$list = DB::table('music')->where('music', 'Like', '%' . $search . '%')->where("status","<","3")->orderBy('time', 'desc')->get();
        if($list==null){
            return   $list=json_encode(100);          /*如果搜索结果为空则返回100*/
        }else {
            return $list = json_encode($list);
        }

    }
	/**
	 * 歌曲管理
     * 默认显示页面(无排序)
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getShow()
	{
        $list=DB::table('music')->skip(10)->take(5)->get();
        foreach($list as $k){
            $k->datetime=date("Y-m-d",$k->time);
        }
       return  $list=json_encode($list);	}


    /**
     * 歌曲管理
     * 采纳音乐功能
     */

public function getUse(){
    $musicid=strip_tags($_GET['musicid']);
    $now=DB::table('music')->where("id",$musicid)->pluck('status');
    if($now==2){     /*只有歌曲是未处理状态时才可以采纳*/
        $m = Music::find($musicid);
        $m->status = 1;
        $a = $m->save();
         return json_encode($a);
}else{
        $b=100;  /*错误则返回100*/
        return json_encode($b);
}



}

    /**
     * 歌曲管理
     * 忽略音乐（事实上并没有删除，是在数据库使起状态变为3）
     */
    public function getIgnore(){
        $musicid=strip_tags($_GET['musicid']);
        $now=DB::table('music')->where("id",$musicid)->pluck('status');
        if($now==2){
            $m = Music::find($musicid);
            $m->status = 3;
            $a = $m->save();
            return json_encode($a);
        }else{
            $b=100;
            return json_encode($b);
        }



    }


    /**
     * 歌曲管理
     * 根据下拉选项框实时对歌曲信息进行排序
     */
     public function getOrder(){
         $page=strip_tags( $_GET['page']);
         $page=$page*10;
        $time =strip_tags( $_GET['time']);//未设置=14
        $way =strip_tags($_GET['way']) ;//未设置=0
        $status =strip_tags($_GET['status']);//未设置=0  采纳为1   未采纳为2  忽略=3
         if($way!=0){
                if($status!=0){
                        $now = time();
                        $range = $now - ($time - 1) * 24 * 60 * 60;
                        $range = strtotime(date('Y-m-d', $range));
                            if($way==1){
                                $way="goods";
                            }else if($way==2){
                                $way="time";
                            }
                        $list = DB::table("music")->where("time", ">=", $range)->where("status","=",$status)->orderby($way,"desc")->skip($page)->take(10)->get();
                 }else{
                        $now = time();
                        $range = $now - ($time - 1) * 24 * 60 * 60;
                        $range = strtotime(date('Y-m-d', $range));
                             if($way==1){
                                 $way="goods";
                             }else if($way==2){
                                 $way="time";
                             }
                        $list = DB::table("music")->where("time", ">=", $range)->where("status","<","3")->orderby($way,"desc")->skip($page)->take(10)->get();
                }
         } else{
            if($status!=0){
                $now = time();
                $range = $now - ($time - 1) * 24 * 60 * 60;
                $range = strtotime(date('Y-m-d', $range));
                $list = DB::table("music")->where("time", ">=", $range)->where("status","=",$status)->skip($page)->take(10)->get();
            }else{
                $now = time();
                $range = $now - ($time - 1) * 24 * 60 * 60;
                $range = strtotime(date('Y-m-d', $range));
                $list = DB::table("music")->where("time", ">=", $range)->where("status","<","3")->skip($page)->take(10)->get();
                }
        }
         foreach($list as $k){
             $k->datetime=date("Y-m-d",$k->time);
         }
         return  $list=json_encode($list);
    }

    /**
     *  数据统计
     * 默认排序
     */
    public function getStatistics(){
        $sapage=strip_tags($_GET['saNum']);
        $sapage=$sapage*10;
        $time=strip_tags($_GET['time']);
        $order=strip_tags($_GET['order']);
        $now = time();
        $range = $now - ($time - 1) * 24 * 60 * 60;
        $range = strtotime(date('Y-m-d', $range));
        if($order==1){           /*该歌曲点击次数*/
            $list = DB::table('music')->select("id","music", DB::raw('sum(goods) as excellentNum'),DB::raw('count(*) as musicTime' ),DB::raw('sum(goods) *0.4+count(*)*0.6 as comprehensive'))->where("time", ">=", $range)->orderby('musicTime', 'DESC')->groupby('music')->skip($sapage)->take(10)->get();
        }
         elseif($order==2) {          /*该歌曲累计点赞数*/
        $list = DB::table('music')->select("id","music", DB::raw('sum(goods) as excellentNum'),DB::raw('count(*) as musicTime' ),DB::raw('sum(goods) *0.4+count(*)*0.6 as comprehensive'))->where("time", ">=", $range)->orderby("excellentNum", "DESC")->groupby('music')->skip($sapage)->take(10)->get();
        }
        elseif($order==3){          /*该歌曲综合热门度*/
        $list = DB::table('music')->select("id","music", DB::raw('sum(goods) as excellentNum'),DB::raw('count(*) as musicTime' ),DB::raw('sum(goods) *0.4+count(*)*0.6 as comprehensive'))->where("time", ">=", $range)->orderby("comprehensive", "DESC")->groupby('music')->skip($sapage)->take(10)->get();
        }
        else{                          /*默认排序*/
        $list = DB::table('music')->select("id","music", DB::raw('sum(goods) as excellentNum'),DB::raw('count(*) as musicTime' ),DB::raw('sum(goods) *0.4+count(*)*0.6 as comprehensive'))->where("time", ">=", $range)->groupby('music')->skip($sapage)->take(10)->get();

          }

    return  $list=json_encode($list);
    }

public function getStatus()
{
      $status=$_GET['status'];
    $change = new Status;
    $change->status = $status;
    $change->time = date('Y-m-d H:i:s', time());
     $change->save();
    if($status==0){
        return json_encode(100);
    }else{
        return json_encode(200);
    }
}
}


