<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.4, user-scalable=no">
	<title></title>
    <script type="text/javascript" src="{{__PUBLIC__.'/js/jquery-2.1.3.min.js'}}"></script>
    <link href="{{__PUBLIC__.'/css/bootstrap.min.css'}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{__PUBLIC__.'/css/mobile/swiper.min.css'}}">
    <link href="{{__PUBLIC__.'/css/mobile/personal.css'}}" rel="stylesheet" type="text/css">
</head>

<body>
<header>
    <a href="{{action('ListController@getIndex')}}"><span>电台点歌</span></a>
</header>
<section class="personal">
    <div class="logo">
        <img src={{$img}} alt="头像"/>
    </div>
    <h1>{{$name}}</h1>
    <p>累积点赞次数：{{$praise}}</p>
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
    </script>
</html>