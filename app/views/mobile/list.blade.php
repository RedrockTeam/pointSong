<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.4, user-scalable=no">
<title>快来为朋友点歌吧! ^_^</title>
	<script type="text/javascript" src="{{__PUBLIC__.'/js/jquery-2.1.3.min.js'}}"></script>
    <link  href="{{__PUBLIC__.'/css/swiper.min.css'}}" rel="stylesheet" type="text/css">
    <link href="{{__PUBLIC__.'/css/mobile/user.css'}}" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        <span>电台点歌</span>
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
        <a href="{{action('ListController@getAdd')}}">点歌</a>
    </div>
</body>
<script src="{{__PUBLIC__.'/js/mobile/swiper.jquery.min.js'}}"></script>
<script src="{{__PUBLIC__.'/js/mobile/user.js'}}"></script>
<script>
        var  listShow="{{action('ListController@getShow')}}";
        var  listPraise="{{action('ListController@getPraise')}}";
        var imgUrl="{{__PUBLIC__.'/img'}}";
</script>
</html>
