<?php

class ListController extends \BaseController
{
    private $oauth2Url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx81a4a4b77ec98ff4&redirect_uri=http%3A%2F%2Fhongyan.cqupt.edu.cn%2FpointSong%2F&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";

    /**
     * 列表首页
     */
    public function getIndex()
    {
        $code = Input::get('code');
        if(!$code) {
//            $redirect = urlencode($oauth2Url);
            return Redirect::to($this->oauth2Url);
        }
        $openId = $this->Open($code);
        var_dump($code);
        var_dump($openId);
        return;
        if (Session::get('headurlimage') == null) {
//            var_dump($openId);
            $result = $this->Message($openId);
            Session::put('openId',$openId);
            Session::put('nickname', $result['nickname']);
            Session::put('headurlimage', $result['headurlimage']);
            $this->AutoPraise();
        }

        $bind=$this->Bind($openId);
        $follow=$this->Follow($openId);
        if($follow==200){
              if($bind==200){
                $final=200;
            }else {
                $final = 100;
            }
        }else{
             $final=0;
            }
        $address = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data = $this->Share($address);
        $an = DB::table('announcement')->orderby('time', 'desc')->first();//置顶显示的公告
        //return $an;
        //置顶显示的公告
        $content = DB::table('announcement')->orderby('time', 'desc')->pluck('content');
        $status = DB::table('status')->orderby('time', 'desc')->pluck('status');
        return View::make('mobile.list')->with('message', $an)->with('status', $status)->with('content', $content)->with('Js', $data)->with('bind',$final);
//       $a= Session::get('nickname');
//        var_dump($a);
    }

    /**
     * 发表点歌页面
     */
    public function getAdd()
    {
        return View::make('mobile.add');
    }

    /**
     * 发表新点歌的方法
     */
    public function postCreate()
    {
        $send_name = Session::get('nickname');
        $head_image = Session::get('headurlimage');
        $music = $_POST['song'];
        //$music=Input::get('song');
        $singer = $_POST['singer'];
        $recieve_name = $_POST['toSomeBody'];
        $content = $_POST['content'];
        $is_sayname = $_POST['is_sayname'];

        if (($music == null || $singer == null) || ($content == null || $recieve_name == null)) {
            return json_encode(100); //如果填写的内容有为空的就返回100；
        } else {
            if (($this->utf8_strlen($music) > 30 || $this->utf8_strlen($singer) > 25) || ($this->utf8_strlen($recieve_name) > 15 || $this->utf8_strlen($content) > 60)) {
                return json_encode(101);//如果填写的内容超过规定字数返回101
            } else {
                if (($this->illegal($music) > 0 || $this->illegal($singer) > 0) || ($this->illegal($recieve_name) > 0 || $this->illegal($content) > 0)) {
                    return json_encode(102);
                } else {
                    $addmusic = new Music;
                    $addmusic->music = $music . '|' . $singer;
                    $addmusic->recieve_name = $recieve_name;
                    $addmusic->content = $content;
                    $addmusic->is_sayname = $is_sayname;
                    $addmusic->send_name = $send_name;
                    $addmusic->goods = 0;
                    $addmusic->time = time();
                    $addmusic->operate_time = time();
                    $addmusic->status = 2;
                    $addmusic->head_image = $head_image;
                    $k = $addmusic->save();
                    if ($k == true) {
                        $openId = Session::get('openId');
                        $this->ok($openId);
                        return $k = json_encode($k);
                    } else {
                        return $k = json_encode(100);
                    }
                }
            }
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * 点赞按钮
     */
    public function getPraise()
    {
        $send_name = Session::get('nickname');
        $bepraise_id = strip_tags($_GET['bepraise_id']);
        //$user_id=Session::get('user_id');
        $a = DB::table('praise')->where('bepraise_id', $bepraise_id)->where('user_id', $send_name)->count();//判断数据库是否点过赞了
        if ($a > 0) {
            return json_encode(100);//如果该用户已经点过赞了，就返回100
        } else {
            /*没有点过赞的话，就在praise增加记录并且在music表里的goods字段加一*/
            $praise = new Praise;
            $praise->user_id = $send_name;
            $praise->bepraise_id = $bepraise_id;
            $praise->time = time();
            $praise->save();
            $goods = DB::table('music')->where('id', '=', $bepraise_id)->pluck('goods');
            $goods = $goods + 1;
            $update = DB::table('music')->where('id', '=', $bepraise_id)->update(array('goods' => $goods, 'operate_time' => time()));
            return json_encode($goods);
        }
    }


    /**
     * 列表
     * 0=最新动态
     * 1=热门互动
     * 2=往期回顾
     */
    public function getShow()
    {
        $send_name = Session::get('nickname');
        $now = strip_tags($_GET['indexNum']);
        $newpage = strip_tags($_GET['newpage']);
        $time = 14;    //显示14天内的信息；
        $nowtime = time();
        $range = $nowtime - ($time) * 24 * 60 * 60;
        $range = strtotime(date('Y-m-d', $range));
        $newpage = $newpage * 5;
        if ($now == 0) {
            $all = DB::table('music')->where("time", ">=", $range)->where('status', '<', '3')->orderby('operate_time', 'desc')->skip($newpage)->take(5)->get();
        } else if ($now == 1) {
            $all = DB::table('music')->where("time", ">=", $range)->where('status', '<', '3')->orderby('goods', 'desc')->skip($newpage)->take(5)->get();
        } else {
            $all = DB::table('music')->where("time", ">=", $range)->where("status", "1")->orderby('time', 'desc')->where('status', '=', '1')->skip($newpage)->take(5)->get();
        }
        /*判断是否点过赞和是否已经播放如果点过赞则isPraise=1 已播放的话accept=1 匿名则Nickname=“匿名”*/
        foreach ($all as $k) {
            $isPraise = Praise::where('bepraise_id', '=', $k->id)->where('user_id', $send_name)->pluck('id');
            if ($isPraise) {
                $k->isPraise = 1;
            } else {
                $k->isPraise = 0;
            }
            if ($k->status == 1) {
                $k->accept = 1;
            } else {
                $k->accept = 0;
            }
            if ($k->is_sayname == 1) {
                $k->nickname = "匿名";
                $k->img = __PUBLIC__ . '/img/nickname.png';


            } else {
                $k->nickname = $k->send_name;
                $k->img = $k->head_image;
            }
            $k->datetime = date("Y-m-d", $k->time);

        }
        return $all = json_encode($all);
    }

    // 计算中文字符串长度
    function utf8_strlen($string = null)
    {
        // 将字符串分解为单元
        preg_match_all("/./us", $string, $match);
        // 返回单元个数
        return count($match[0]);
    }

    /**
     * 通过小帮手的openid获取用户信息，返回用户的微信号和地址
     */
    public function Message($openId)
    {

        $url = "http://Hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/userInfo";
        $timestamp = time();
        $string = "";
        $arr = "abcdefghijklmnopqistuvwxyz0123456789ABCDEFGHIGKLMNOPQISTUVWXYZ";
        for ($i = 0; $i < 16; $i++) {
            $y = rand(0, 41);
            $string .= $arr[$y];
        }
        $secret = sha1(sha1($timestamp) . md5($string) . 'redrock');
        $post_data = array(
            "timestamp" => $timestamp,
            "string" => $string,
            "secret" => $secret,
            "openid" => $openId,
            "token" => "gh_68f0a1ffc303",
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        //打印获得的数据
        $rel = json_decode($output);
        $rel->data->headimgurl = substr($rel->data->headimgurl, 0, -1) . "64";

        //return $rel->data->headimgurl;
        $result = array('nickname' => $rel->data->nickname, "headurlimage" => $rel->data->headimgurl);
//        var_dump($result);
        return $result;

    }

    public function AutoPraise()
    {
        $all = DB::table('music')->lists('id');
        $count = DB::table('music')->count();
        $randNum = rand(0, $count);
        $praise = new Praise;
        $praise->user_id = "0";
        $praise->bepraise_id = $randNum;
        $praise->time = time();
        $praise->save();
        $goods = DB::table('music')->where('id', '=', $randNum)->pluck('goods');
        $goods = $goods + 1;
        $update = DB::table('music')->where('id', '=', $randNum)->update(array('goods' => $goods, 'operate_time' => time()));
    }

    public function illegal($str)
    {
        $word = DB::table('word')->lists('word');
        foreach ($word as $words) {
            $pattern_url = "/^((?!" . $words . ").)*$/is";
            if (!preg_match($pattern_url, $str)) {
                return 1;
            }
        }
        return 0;
        //return $b;

    }

    public function ok($openId)
    {
        $url = "http://hongyan.cqupt.edu.cn/wechatsend/index.php?s=/Home/Api/sendCustomTimeOut";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'openid=' . $openId . '&message=您已成功点歌&time=20');
        curl_exec($ch);
        curl_close($ch);
    }

    public function Share($address)
    {
        $url = "http://Hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/apiJsTicket";
        $timestamp = time();
        $string = "";
        $arr = "abcdefghijklmnopqistuvwxyz0123456789ABCDEFGHIGKLMNOPQISTUVWXYZ";
        for ($i = 0; $i < 16; $i++) {
            $y = rand(0, 41);
            $string .= $arr[$y];
        }
        $secret = sha1(sha1($timestamp) . md5($string) . 'redrock');
        $post_data = array(
            "timestamp" => $timestamp,
            "string" => $string,
            "secret" => $secret,
            "token" => "gh_68f0a1ffc303",
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        //打印获得的数据
        $rel = json_decode($output);
        $ticket = $rel->data;
//    $address="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $key = "jsapi_ticket=$ticket&noncestr=$string&timestap=$timestamp&url=$address";
        $data['ticket'] = $ticket;
        $data['timestamp'] = $timestamp;
        $data['string'] = $string;
        $data['signature'] = sha1($key);
//    var_dump($data['string']);
        return $data;
    }


    public function Open($code)
    {
        $url = "http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/webOAuth";
        $timestamp = time();
        $string = "";
        $arr = "abcdefghijklmnopqistuvwxyz0123456789ABCDEFGHIGKLMNOPQISTUVWXYZ";
        for ($i = 0; $i < 16; $i++) {
            $y = rand(0, 41);
            $string .= $arr[$y];
        }
        $secret = sha1(sha1($timestamp) . md5($string) . 'redrock');
        $post_data = array(
            "timestamp" => $timestamp,
            "string" => $string,
            "secret" => $secret,
            "code" => $code,
            "token" => "gh_68f0a1ffc303",
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        //打印获得的数据
        $rel = json_decode($output);
        //return $rel->data->headimgurl;
        $openid = $rel->data->openid;
//        var_dump($result);
        return $openid;

    }
    public function Bind($openId){
        $url = "http://Hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/bindVerify";
        $timestamp = time();
        $string = "";
        $arr = "abcdefghijklmnopqistuvwxyz0123456789ABCDEFGHIGKLMNOPQISTUVWXYZ";
        for ($i=0; $i<16; $i++) {
            $y = rand(0,41);
            $string .= $arr[$y];
        }
        $secret = sha1(sha1($timestamp).md5($string).'redrock');
        $post_data = array (
            "timestamp" => $timestamp,
            "string" => $string,
            "secret" => $secret,
            "openid" => $openId,
            "token" => "gh_68f0a1ffc303",
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        //打印获得的数据
        $result = json_decode($output);
        $bind=$result->status ;
        return $bind;
    }
    public function Follow($openId){
        $url = "http://Hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/openidVerify";
        $timestamp = time();
        $string = "";
        $arr = "abcdefghijklmnopqistuvwxyz0123456789ABCDEFGHIGKLMNOPQISTUVWXYZ";
        for ($i=0; $i<16; $i++) {
            $y = rand(0,41);
            $string .= $arr[$y];
        }
        $secret = sha1(sha1($timestamp).md5($string).'redrock');
        $post_data = array (
            "timestamp" => $timestamp,
            "string" => $string,
            "secret" => $secret,
            "openid" => $openId,
            "token" => "gh_68f0a1ffc303",
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        //打印获得的数据
        $result = json_decode($output);
        $follow=$result->status ;
        return $follow;
    }
}

