<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.4, user-scalable=no">
	<title>快来为你的小伙伴点歌吧！</title>
    <script type="text/javascript" src="{{__PUBLIC__.'/js/jquery-2.1.3.min.js'}}"></script>
    <link href="{{__PUBLIC__.'/css/bootstrap.min.css'}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{__PUBLIC__.'/css/mobile/swiper.min.css'}}">
    <link href="{{__PUBLIC__.'/css/mobile/personal.css'}}" rel="stylesheet" type="text/css">
</head>

<body>
<header>
    <a href="{{action('ListController@getIndex')}}"><img src='{{__PUBLIC__.'/img/back.png'}}' alt="返回"/><span>返回首页</span></a>
</header>
<section class="personal">
    <div class="logo">
        <img src={{$img}} alt="头像"/>
    </div>
    <h1>{{$name}}</h1>
    <p>累积点赞次数：
	@if($praise!=null)
    {{$praise[0]->excellentNum}}
    @else
    0
    @endif
	</p>
</section>
<section class="title">
    <span num="0" class="click">已发布（{{$push}}）</span>
    <span num="1">被采纳（{{$used}}）</span>
</section>

<div class="swiper-container">
    <div class="swiper-wrapper">
        <section class="main swiper-slide">

            <div class="pull">
                更多...
            </div>
        </section>
        <section class="accepted swiper-slide">

            <div class="pull">
                更多...
            </div>
        </section>
    </div>
</div>
</body>
<script src="{{__PUBLIC__.'/js/mobile/swiper.jquery.min.js'}}"></script>
<script src="{{__PUBLIC__.'/js/mobile/personal.js'}}"></script>
<script src="{{__PUBLIC__.'/js/mobile/hammer.js'}}"></script>
<script src="{{__PUBLIC__.'/js/weixin.js'}}"></script>

<script>
$(document).ready(function() {
$.ajax({
    url: " {{action('PersonalController@getShow')}}",
    type: "get",
    data:{perNum:0},
    dataType: "json",
    contentType: "application/json;charset=utf-8",
    success: function (msg) {
        for (var j = 0; j < msg.length; j++) {
            music(acceptedObj, {
                "id": msg[j].id,
                "img": msg[j].img,
                "music": msg[j].music.split("|")[0],
                "singer": msg[j].music.split("|")[1],
                "me": msg[j].nickname,
                "time": msg[j].datetime,
                "you": msg[j].recieve_name,
                "content": msg[j].content,
                "greatNum": msg[j].goods,
                "great": msg[j].isPraise,
                "accept": true
            });
        }
    },
    error: function (xhr) {
        err(dat);
    }
});


$.ajax({
        url: " {{action('PersonalController@getSay')}}",
        type: "get",
        data:{perNum:0},
        dataType: "json",
        contentType: "application/json;charset=utf-8",
        success: function (msg) {
            for (var w = 0; w< msg.length; w++) {
                music(mainObj, {
                    "id": msg[w].id,
                    "img": msg[w].img,
                    "music": msg[w].music.split("|")[0],
                    "singer": msg[w].music.split("|")[1],
                    "me": msg[w].nickname,
                    "time": msg[w].datetime,
                    "you": msg[w].recieve_name,
                    "content": msg[w].content,
                    "greatNum": msg[w].goods,
                    "great": msg[w].isPraise,
                    "accept": msg[w].accept
                });
            }
        },
        error: function (xhr) {
            err(dat);
        }
    });
});
var  perDelete="{{action('PersonalController@getDelete')}}";
var  perPraise="{{action('ListController@getPraise')}}";
var  perDisplay="{{action('PersonalController@getDisplay')}}";
var imgUrl="{{__PUBLIC__.'/img'}}";

wx.ready(function(){
    wx.onMenuShareTimeline({
        title: '重邮点歌台：快来为你的小伙伴点歌吧！', // 分享标题
        link: "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx81a4a4b77ec98ff4&redirect_uri=http%3A%2F%2Fhongyan.cqupt.edu.cn%2FpointSong%2Fpublic%2F&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect",
        imgUrl: "http://hongyan.cqupt.edu.cn/pointSong/public/img/share.png",
        success: function () {
            alert('分享成功!');// 用户确认分享后执行的回调函数
        },
        cancel: function () {// 用户取消分享后执行的回调函数
        }
    });
    wx.onMenuShareAppMessage({
        title: '重邮点歌台', // 分享标题
        desc: '重邮点歌台：快来为你的小伙伴点歌吧！', // 分享描述
        link: "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx81a4a4b77ec98ff4&redirect_uri=http%3A%2F%2Fhongyan.cqupt.edu.cn%2FpointSong%2Fpublic%2F&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect",
        imgUrl: 'http://hongyan.cqupt.edu.cn/pointSong/public/img/share.png', // 分享图标
        type: '', // 分享类型,music、video或link，不填默认为link
        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        success: function () {
            alert('分享成功!');// 用户确认分享后执行的回调函数
        },
        cancel: function () {
            // 用户取消分享后执行的回调函数
        }
    });
    wx.onMenuShareQQ({
        title: '重邮点歌台', // 分享标题
        desc: '重邮点歌台：快来为你的小伙伴点歌吧！', // 分享描述
        link: "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx81a4a4b77ec98ff4&redirect_uri=http%3A%2F%2Fhongyan.cqupt.edu.cn%2FpointSong%2Fpublic%2F&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect",
        imgUrl: 'http://hongyan.cqupt.edu.cn/pointSong/public/img/share.png', // 分享图标
        success: function () {
            alert('分享成功!');// 用户确认分享后执行的回调函数
        },
        cancel: function () {
            // 用户取消分享后执行的回调函数
        }
    });
});
    </script>
</html>
