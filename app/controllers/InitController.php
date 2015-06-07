<?php

class InitController extends \BaseController {


//    public function AutoPraise()
//    {
//        $all = DB::table('music')->lists('id');
//        $count = DB::table('music')->count();
//        $randNum = rand(0, $count);
//        $praise = new Praise;
//        $praise->user_id = "0";
//        $praise->bepraise_id = $randNum;
//        $praise->time = time();
//        $praise->save();
//        $goods = DB::table('music')->where('id', '=', $randNum)->pluck('goods');
//        $goods = $goods + 1;
//        $update = DB::table('music')->where('id', '=', $randNum)->update(array('goods' => $goods, 'operate_time' => time()));
//    }

}