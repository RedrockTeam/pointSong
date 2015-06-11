<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.4, user-scalable=no">
    <title>快来为你的小伙伴点歌吧！</title>
	<script type="text/javascript" src="{{__PUBLIC__.'/js/jquery-2.1.3.min.js'}}"></script>
    <link  href="{{__PUBLIC__.'/css/swiper.min.css'}}" rel="stylesheet" type="text/css">
    <link href="{{__PUBLIC__.'/css/mobile/user.css'}}" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        <span>重邮点歌台</span>
        <a href="{{action('PersonalController@getIndex')}}"><i class="iconfont">&#xe834;</i></a>
    </header>
    <section class="title">
        <span num=0 class="click">最新动态</span>
        <span num=0.5>热门互动</span>
        <span num=1>往期回顾</span>
        {{--<div class="over">--}}
            {{--<div class="in">--}}
                {{--<span>最新动态</span>--}}
                {{--<span>热门互动</span>--}}
                {{--<span>往期回顾</span>--}}
            {{--</div>--}}
        {{--</div>--}}
    </section>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <section class="main swiper-slide">
                <div class="notice">
                    <div class="top">
                        <span class="name"><i class="iconfont">&#xe6a7;</i>公告</span>
                        <span class="time">
                            @if($message!=null)
                                {{date("Y-m-d", $message->time)}}
                            @endif
                        </span>
                    </div>
                    <div class="center">
                        <p class="noticeTitle">
                            @if($message!=null)
                                {{$message->title}}
                             @endif
                        </p>
                        <p class="noticeContent">
                            @if($message!=null)
                                {{$message->content}}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="pull">
                    更多...
                </div>
            </section>
            <section class="rank swiper-slide">

                <div class="pull">
                    更多...
                </div>
            </section>
            <section class="history swiper-slide">

                <div class="pull">
                    更多...
                </div>
            </section>
        </div>
    </div>
    <div class="Song">
        <a onclick="return bindFun()" href="{{action('ListController@getAdd')}}">点歌</a>
    </div>
</body>
<script src="{{__PUBLIC__.'/js/mobile/swiper.jquery.min.js'}}"></script>
<script src="{{__PUBLIC__.'/js/mobile/user.js'}}"></script>
<script src="{{__PUBLIC__.'/js/weixin.js'}}"></script>

<script>
var listShow = "{{action('ListController@getShow')}}";
var listPraise = "{{action('ListController@getPraise')}}";
var imgUrl = "{{__PUBLIC__.'/img'}}";
var bind="{{$bind}}";
function bindFun(){
    alert(bind);
    if(bind!=200){
        alert("亲~你还没有绑定学号，绑定后才可以点歌哦!\n关注重邮小帮手（cyxbswx）,输入关键字绑定学号，即可！");
        $(".Song").remove();
        return false;
    }
}
var status = "{{$status}}";
if(status == 0){
    alert("亲~点歌台现已关闭，开放时间另行通知，详情请看公告哦");
    $(".Song").remove();
}
wx.config({
    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: 'wx81a4a4b77ec98ff4', // 必填，公众号的唯一标识
    timestamp: "{{$Js['timestamp']}}", // 必填，生成签名的时间戳
    nonceStr: "{{$Js['string']}}", // 必填，生成签名的随机串
    signature: "{{$Js['signature']}}",// 必填，签名，见附录1
    jsApiList: [
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
    ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});

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
