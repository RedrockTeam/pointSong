<?php

class WordController extends \BaseController {

	/**
	 * 违规字管理
     * 默认显示
	 */
	public function getIndex()
	{
        $word=DB::table('word')->orderby('add_time','desc')->get();
        return $all=json_encode($word);

    }


	/**
     * 违规字管理
	 * 添加新的违规字
	 */
	public function postCreate()
	{
        $word=strip_tags($_POST['illegal']);
        if($word!=null){
            $new=new Word;
            $new->word=$word;
            $new->add_time=time();
            $new->save();
            $word=DB::table('word')->orderby('add_time','desc')->get();
            return $all=json_encode($word);
        }else{
            return $a=json_encode(100);
        }

    }


	/**
	 * 违规字管理
     * 删除违规字
	 */
	public function getDelete()
	{
		$id=strip_tags($_GET['id']);
        $words = Word::find($id);
         $words->delete();
        $word=DB::table('word')->orderby('add_time','desc')->get();
        return $all=json_encode($word);

    }


}
