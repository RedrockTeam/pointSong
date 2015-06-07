//
//$('.form_date').datetimepicker({
//    language:  'fr',
//    weekStart: 1,
//    todayBtn:  1,
//    autoclose: 1,
//    todayHighlight: 1,
//    startView: 2,
//    minView: 2,
//    forceParse: 0
//});

$(".main section").css("min-height",($(window).height()-275)+"px");
$(document).ready(function() {
    function getmusic(){   /*获取歌曲信息的方法 在后面根据下拉框的改变调用这个方法*/
        var time=$("#time").val();      /*time=时间选择  status=类型筛选 way=排序筛选*/
        var status=$("#status").val();
        var way=$("#way").val();
        $.ajax({
            url: musicOrder,
            type: "get",
            data:{time:time,way:way,status:status,page:0},
            dataType: "json",
            success: function (msg) {
                $(".music .list").remove();
                for (var j = 0; j < msg.length; j++) {
                    music(musicobj, {
                        "id": msg[j].id,
                        "musicName": msg[j].music.split("|")[0],
                        "singer": msg[j].music.split("|")[1],
                        "you": msg[j].recieve_name,
                        "contain": msg[j].content,
                        "me": msg[j].send_name,
                        "time": msg[j].datetime,
                        "excellent": msg[j].goods,
                        "operation": msg[j].status,
                        "musicid":msg[j].id
                    });
                }

                musicNum=1;

            },
            error: function (xhr) {
                alert("连接服务器失败");
            }
        });
    }
    $("#time").on("change",function(){         /*判断某些下拉框发生了改变*/
        getmusic();
    });
    $("#way").on("change",function(){
        getmusic();
    });
    $("#status").on("change",function(){
        getmusic();
    });
    $("#music").on("click",function () {
        getmusic();
    });



});

var  musicNum=1;
    function musicAjax(){

    if ($(".main").height() - (document.body.scrollTop + window.screen.height) < 500) {
        var time = $("#time").val();
        /*time=时间选择  status=类型筛选 way=排序筛选*/
        var status = $("#status").val();
        var way = $("#way").val();
        $.ajax({
            url: musicOrder,
            type: "get",
            data: {time: time, way: way, status: status, page: musicNum},
            dataType: "json",
            success: function (msg) {
                //        $(".music .list").remove();
                for (var j = 0; j < msg.length; j++) {
                    music(musicobj, {
                        "id": msg[j].id,
                        "musicName": msg[j].music.split("|")[0],
                        "singer": msg[j].music.split("|")[1],
                        "you": msg[j].recieve_name,
                        "contain": msg[j].content,
                        "me": msg[j].send_name,
                        "time": msg[j].datetime,
                        "excellent": msg[j].goods,
                        "operation": msg[j].status,
                        "musicid": msg[j].id
                    });
                }
                musicNum++;
            },
            error: function (xhr) {
                alert("连接服务器失败");
            }
        });
    }
}
$(document).ready(function(){
    function getstatistics(){
        var time2=$("#time2").val();
        var order2=$("#order2").val();
        $.ajax({
            url: musicStatistics,
            type: "get",
            data:{time:time2,order:order2,saNum:0},
            dataType: "json",
            //   contentType: "application/json;charset=utf-8",
            success: function (msg) {
                $(".statistics .list").remove();
                for (var j = 0; j < msg.length; j++) {
                    statistics(statisticsobj,{
                        "num":msg[j].id,
                        "music":msg[j].music.split("|")[0],
                        "singer":msg[j].music.split("|")[1],
                        "musicTime":msg[j].musicTime,
                        "excellentNum":msg[j].excellentNum,
                        "comprehensive":msg[j].comprehensive
                    });
                }
                saNum=1;
            },
            error: function (xhr) {
                alert("连接服务器失败");
            }
        });
    }
    $("#time2").on("change",function(){
        getstatistics();
    });
    $("#order2").on("change",function(){
        getstatistics();
    });
    $("#statistics").on("click",function () {
        getstatistics();
    });
});
var saNum=1;
 function statisticsAjax(){
 //    console.log(1);

     if($(".statistics").height()-(document.body.scrollTop+window.screen.height)<500){
         var time2=$("#time2").val();
         var order2=$("#order2").val();
        $.ajax({
            url:musicStatistics,
            type: "get",
            data:{time:time2,order:order2,saNum:saNum},
            dataType: "json",
            //   contentType: "application/json;charset=utf-8",
            success: function (msg) {
                //     $(".statistics .list").remove();
                for (var j = 0; j < msg.length; j++) {
                    statistics(statisticsobj,{
                        "num":msg[j].id,
                        "music":msg[j].music.split("|")[0],
                        "singer":msg[j].music.split("|")[1],
                        "musicTime":msg[j].musicTime,
                        "excellentNum":msg[j].excellentNum,
                        "comprehensive":msg[j].comprehensive
                    });

                }
                saNum++;

            },
            error: function (xhr) {
                alert("连接服务器失败");
            }
        });
    }
}
$(document).ready(function(){
    $.ajax({
        url: announcementIndex,
        type: "get",
        data:{anNum:0},
        dataType: "json",
        //contentType: "application/json;charset=utf-8",
        success: function(msg) {
            notice(presentobj,{
                "title":msg[0].title,
                "content": msg[0].content,
                "time":msg[0].datetime
            });
            for(var i=0;i<msg.length;i++)
                notice(historyobj,{"title":msg[i].title,
                    "content": msg[i].content,
                    "time":msg[i].datetime
                });

        },
        error: function(xhr) {
            alert("there is something wrong");
        }
    });
});
var anNum=1;
function announcementAjax(){
    if($(".notice").height()-(document.body.scrollTop+window.screen.height)<500) {
        $.ajax({
            url:announcementIndex,
            type: "get",
            data:{anNum:anNum},
            dataType: "json",
            //contentType: "application/json;charset=utf-8",
            success: function(msg) {
                for(var i=0;i<msg.length;i++)
                    notice(historyobj,{"title":msg[i].title,
                        "content": msg[i].content,
                        "time":msg[i].datetime
                    });
                   anNum++;
            },
            error: function(xhr) {
                alert("服务器连接失败");
            }
        });
    }
    }
$(document).ready(function() {
/*音乐搜索*/
$("#s1").on("click",function(){
    var search=$("#search").val();
    $.ajax({
        url: musicSearch,
        type: "post",
        data:{search:search},
        //dataType: "json",
        //contentType: "application/json;charset=utf-8",
        success: function (ms) {
            if(ms==100){
                alert("没有相关数据");
            }else{
                $("#search").val("");
                $(".music .list").remove();
                ms=eval(ms);
                for (var m = 0; m< ms.length; m++) {
                    music(musicobj, {
                        "id": ms[m].id,
                        "musicName": ms[m].music.split("|")[0],
                        "singer": ms[m].music.split("|")[1],
                        "you": ms[m].recieve_name,
                        "contain": ms[m].content,
                        "me": ms[m].send_name,
                        "time": ms[m].datetime,
                        "excellent": ms[m].goods,
                        "operation": ms[m].status,
                        "musicid":ms[m].id
                    });
                }
            }
        },
        error: function (xhr) {
            alert("服务器连接失败");
        }
    });
})

/*统计搜索*/
$("#s2").on("click",function(){
    var searches=$("#search2").val();
    $.ajax({
        url: musicFind,
        type: "post",
        data:{searches:searches},
        //dataType: "json",
        //contentType: "application/json;charset=utf-8",
        success: function (msg) {
            if(msg==100){
                alert("没有相关数据")
            }else{
                $(".statistics .list").remove();
                msg=eval(msg);
                for (var j = 0; j < msg.length; j++) {
                    statistics(statisticsobj,{
                        "num":msg[j].id,
                        "music":msg[j].music.split("|")[0],
                        "singer":msg[j].music.split("|")[1],
                        "musicTime":msg[j].musicTime,
                        "excellentNum":msg[j].excellentNum,
                        "comprehensive":msg[j].comprehensive
                    });
                }
            }
        },
        error: function (xhr) {
            alert("服务器连接失败");
        }
    });
});


});

$(document).ready(function(){

    /*ajax 违规字管理*/
    $.ajax({
        url: wordIndex,
        type: "get",
        dataType: "json",
        contentType: "application/json;charset=utf-8",
        success: function(msg) {
            for(var p=0;p<msg.length;p++) {
                illegal(illegalobj,{
                    "data":msg[p].word,
                    "titleId":msg[p].id
                });
            }
        },
        error: function(xhr) {
            alert("连接服务器失败");
        }
    });
});
    function music(obj,data) {
        var tr = $("<tr>", {
            "class": "list"
        }).appendTo(obj);

        $("<th>", {
            "text": data.musicName
        }).appendTo(tr);

        $("<th>", {
            "text": data.singer
        }).appendTo(tr);

        $("<th>", {
            "text": data.you
        }).appendTo(tr);

        $("<th>", {
            "text": data.contain,
        }).appendTo(tr);

        $("<th>", {
            "text": data.me
        }).appendTo(tr);

        $("<th>", {
            "html": data.time
        }).appendTo(tr);

        $("<th>", {
            "text": data.excellent
        }).appendTo(tr);

        if (data.operation == 1) {
            $("<th>", {
                "html": "<span class='played' title='该歌曲已经播放'>已采纳</span>",
                // "status":data.status
            }).appendTo(tr);
        } else {
            var th = $("<th>", {
                //   "status":data.status
            }).appendTo(tr);
            var play = $("<span>", {
                "class": "play",
                "title": "播放歌曲，并将消息推送给该用户",
                "html": "采纳",
                "musicid": data.musicid
            }).appendTo(th);
            $("<span>", {
                "html": "/"
            }).appendTo(th);
            var cancel = $("<span>", {
                "class": "cancel",
                "title": "将该条歌曲消息删除",
                "html": "删除",
                "musicid": data.musicid
            }).appendTo(th);
            //歌曲设置
            play.on("click", function () {
                var musicid = $(this).attr('musicid');

                var $this = $(this);
                $.ajax({
                    url:musicUse,
                    type: "get",
                    data: {musicid: musicid},
                    //  dataType: "json",
                    //contentType: "application/json;charset=utf-8",
                    success: function (msg) {
                        if (msg != 100) {
                            $this.parents("th").html("<span class='played' title='该歌曲已经播放'>已采纳</span>");
                        }
                    },
                    error: function () {
                        alert("服务器连接失败");
                    }
                });
            });

            //歌曲忽略
            cancel.on("click", function () {
                var musicid = $(this).attr('musicid');
                var $this = $(this);
                $.ajax({
                    url: musicIgnore,
                    type: "get",
                    data: {musicid: musicid},
                    //  dataType: "json",
                    //contentType: "application/json;charset=utf-8",
                    success: function (msg) {
                        if (msg != 100) {
                            $this.parents(".list").remove();
                        }
                    },
                    error: function () {
                        alert("服务器连接失败");
                    }
                });
            })
        }

    }
    function notice(obj,data){

        var notice = $("<div>",{
            "class":"notice"
        }).appendTo(obj);

        $("<p>",{
            "class":"notice-title",
            "text":data.title
        }).appendTo(notice);

        $("<p>",{
            "class":"notice-content",
            "text":data.content
        }).appendTo(notice);

        $("<p>",{
            "class":"notice-time",
            "text":data.time
        }).appendTo(notice);

    }


    function statistics(obj,data){

        var tr = $("<tr>",{
            "class":"list"

        }).appendTo(obj);

        $("<th>",{
            "text":data.num
        }).appendTo(tr);

        $("<th>",{
            "text":data.music
        }).appendTo(tr);

        $("<th>",{
            "text":data.singer
        }).appendTo(tr);

        $("<th>",{
            "text":data.musicTime
        }).appendTo(tr);

        $("<th>",{
            "text":data.excellentNum
        }).appendTo(tr);

        $("<th>",{
            "text":data.comprehensive
        }).appendTo(tr);

    }

    function illegal(obj,data){

        var button = $("<div>",{
            "type":"submit",
            "text":data.data,
            "class":"btn btn-default",
            "title":"点击删除当前违规字",
            "titleId":data.titleId
        }).appendTo(obj);

        $("<i>",{
            "class":"iconfont",
            "html":"&#xe60a;"
        }).appendTo(button);

        //删除违规字
        button.on('click',function(){
            var titleId=$(this).attr('titleid');
            $.ajax({
                url: wordDelete,
                type: "GET",
                data:{id:titleId},
              //dataType: "json",
              //contentType: "application/json;charset=utf-8",
                success: function (msg) {
                    alert("删除违规字成功！");
                    $(".illegal-word .btn-default").remove();
                    msg=eval(msg);
                    for(var p=0;p<msg.length;p++) {
                        illegal(illegalobj, {"data": msg[p].word,"titleId":msg[p].id});//违规字设置
                    }
                },
                error: function (xhr) {
                    alert(titleId);
                }
            });
        });

    }

    var section = $(".main section");
    var menu = $(".menu tr");
    var i = "0";
    var inputObj =$(".searchdiv");
    menu.on("click",function(){
        $(document).off('scroll');
        var num = $(this).attr("num");
switch(num){
    case "0":
        $(document).on("scroll", function() {
            musicAjax();

        });
        break;
    case "1":
        $(document).on("scroll",function(){
            announcementAjax();
        });
        break;
    case "2":
        $(document).on("scroll",function(){
            statisticsAjax();
        });
        break;
}

        if(num != i){
            i = $(this).attr("num");
            menu.removeClass("onclick");
            $(menu[i]).addClass("onclick");
            section.css("display","none");
            $(section[i]).css("display","block");
            inputObj.css("display","none");
            if(num == 0){
                $(inputObj[0]).css("display","table");
            }
            if(num == 2){
                $(inputObj[1]).css("display","table");
            }
        }
    });
    var musicobj = $(".music tbody");
    var statisticsobj = $(".statistics tbody");
    var presentobj = $(".notice .present");
    var historyobj = $(".notice .history");
    var illegalobj = $(".illegal .illegal-word");
//begin ajax;
    var formBool = 1;
    $(".notice .btn").on("click",function(){
        var title = $("#title").val();
        var control = $("#control").val();
        var data = {};
        var bool = 1;
        if(title == ""){
            $(".notice .formTitle").addClass("has-error");
            bool = 0;
        }else{
            $(".notice .formTitle").removeClass("has-error");
        }
        if(control == ""){
            $(".notice .formControl").addClass("has-error");
            bool = 0;
        }else{
            $(".notice .formControl").removeClass("has-error");
        }

        if(formBool && bool){
            formBool = 0;
           data.title = title;
           data.control = control;
            $.ajax({
                //地址
                url:announcementCreate,
                type: 'post',
                // data: {title:title},
                data:{title:title,control:control,anNum:0},
            success: function (msg) {
                if(msg==100){
                    alert("输入信息不完整，请仔细检查您的输入！");
                    formBool = 1;
                }else{
                    $("#title").val("");
                    $("#control").val("");
                    alert("发表新公告成功了！");
                    formBool = 1;
                     $("div.notice").remove();
                    msg=eval(msg);
                     notice(presentobj,{
                         "title":msg[0].title,
                         "content": msg[0].content,
                         "time":msg[0].time
                     });
                    for(var o=1;o<msg.length;o++) {
                    notice(historyobj, {
                        "title": msg[o].title,
                        "content": msg[o].content,
                        "time": msg[o].time});
                    }
                }
            },
                error: function(){
                    alert("服务器连接失败！");
                    formBool = 1;
                }
            });
        }
    });

    $(".notice .top span").on("click",function(){
        var title = $(".present .notice-title").html();
        var content = $(".present .notice-content").html();
        $("#title").val(title);
        $("#control").val(content);
        $(".formTitle").removeClass("has-error");
        $(".form-group").removeClass("has-error");

        $("body").scrollTop(170);
    });

    var illegalBool = 1;
    $(".illegal .btn").on("click",function(){
        var illegalvar = $("#illegal").val();
        var data = {};
        if(illegalvar == ""){
            $(".illegal .formTitle").addClass("has-error");
        }else{
            illegalBool = 0;
            $(".illegal .formTitle").removeClass("has-error");
            data.illegalvar = illegalvar;
            $.ajax({
                //地址
                url: wordCreate,
                type: 'POST',
                data: {illegal:illegalvar},
                success: function (msg) {
                    if(msg==100){
                        alert("您的输入有误");
                    }else{
                        $("#illegal").val("");
                        alert("添加违规字成功！");
                        illegalBool = 1;
                        $(".illegal-word .btn-default").remove();
                        msg=eval(msg);
                        for(var p=0;p<msg.length;p++) {
                        illegal(illegalobj, {
                            "data": msg[p].word,
                            "titleId":msg[p].id
                        });//违规字设置
                        }
                    }
                },
                error: function(){
                    alert("服务器连接失败！");
                    illegalBool = 1;
                }
            });
        }
    });
  window.onload=(function(){
    $(menu[0]).click();
  })
