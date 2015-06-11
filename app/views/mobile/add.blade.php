<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.4, user-scalable=no">
    <title>重邮点歌台</title>
	    <script type="text/javascript" src="{{ __PUBLIC__.'/js/mobile/jquery-2.1.3.min.js'}}"></script>
    <link href="{{ __PUBLIC__.'/css/mobile/bootstrap.min.css'}}" rel="stylesheet" type="text/css">
    <link href="{{ __PUBLIC__.'/css/mobile/music.css'}}" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        <a href="{{action('ListController@getIndex')}}"><img src='{{__PUBLIC__.'/img/back.png'}}' alt="返回"/><span>电台点歌</span></a>
        <a href="{{action('PersonalController@getIndex')}}"><i class="iconfont">&#xe834;</i></a>
    </header>
    <section class="title">
        <p>红岩网校工作站&阳光校广·音乐你做主</p>
        <p>告诉我们你最喜爱的歌曲|最思念的人|最想说的话|点出最心仪的赞 </p>
        <p>我们，将在网上、空中传递你最真挚的祝福</p>
    </section>
    <section class="section section-form">
        <div class="form">
            <div class="form-group formTitle">
                <label class="control-label" for="song" >我要点的歌名</label>
                <input class="form-title form-control" id="song" type="text" placeholder="30字以内" size="35" maxlength="24"/>
            </div>
            <div class="form-group formControl">
                <label class="control-label" for="singer">演唱者</label>
                <input class="form-title form-control" id="singer" type="text" placeholder="25个字以内" size="35" maxlength="12"/>
            </div>
            <div class="form-group formControl">
                <label class="control-label" for="toSomeBody">对方名字</label>
                <input class="form-title form-control" id="toSomeBody" type="text" placeholder="6个字以内" size="35" maxlength="12"/>
            </div>
            <div class="form-group formControl">
                <label class="control-label" for="control">我还想说的话</label>
                <textarea class="form-control" id="control" rows="3" maxlength="60" placeholder="60字以内"></textarea>
            </div>
            <button type="button" id="addmusic" class="btn btn-default">发表</button>
            <div class="checkbox">
                <label>
                    <input type="checkbox"  id="is_sayname">匿名
                </label>
            </div>
        </div>
    </section>
</body>
<script type="text/javascript" src="{{__PUBLIC__.'/js/mobile/bootstrap.min.js'}}"></script>
<script type="text/javascript" src="{{__PUBLIC__.'/js/mobile/music.js'}}"></script>
<script src="{{__PUBLIC__.'/js/weixin.js'}}"></script>

<script>

$(document).ready(function(){
    $("#addmusic").on('touchend',function(){
    //alert(1);
    var song=$("#song").val();
    var singer=$("#singer").val();
    var toSomeBody=$("#toSomeBody").val();
    var content=$("#control").val();
    if($('#is_sayname').is(":checked"))
        {var is_sayname=1;}
    else{
        var is_sayname=0;
    }
    $.ajax({
        //地址
        url: "{{action('ListController@postCreate')}}",
        type: 'post',
        // data: {title:title},
        data:{
        song:song,
        singer:singer,
        toSomeBody:toSomeBody,
        content:content,
        is_sayname:is_sayname
        },
    success: function (msg) {
        if(msg==100){
             err(blank);
        }else if(msg==101){
           err(error) ;
        }else if(msg==102){
           err(wordillegal) ;
        }else{
           err(su);
           $(window).off("beforeunload");
            window.location.href="{{action('PersonalController@getIndex')}}";

        }
    },
        error: function(){
            err(dat);
            }
        });
    });
});

wx.ready(function(){
    wx.onMenuShareTimeline({
        title: '我在重邮点歌台为你点了歌，你要来听吗？', // 分享标题
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
        desc: '我在重邮点歌台为你点了歌，你要来听吗？', // 分享描述
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
        desc: '我在重邮点歌台为你点了歌，你要来听吗？', // 分享描述
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
