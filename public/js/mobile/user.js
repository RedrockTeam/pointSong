/**
 * Created by Grallen on 2015/5/25.
 */
function music(obj,data){
    var music = $("<div>",{
        "class":"music",
        "data-id":data.id
    }).appendTo(obj);
    var top  = $("<div>",{
        "class":"top"
    }).appendTo(music);
    if(data.accept){
        $("<img>",{
            "src":imgUrl+"/played.png",
            "class":"accept"
        }).appendTo(top);
    }
    $("<img>",{
        "src":data.img,
        "class":"logo"
    }).appendTo(top);
    $("<h1>",{
        text:data.music+"- "+data.singer
    }).appendTo(top);
    $("<span>",{
        "class":"name",
        text:"点歌人："+data.me
    }).appendTo(top);
    $("<span>",{
        "class":"time",
        text:data.time
    }).appendTo(top);
    var center  = $("<div>",{
        "class":"center"
    }).appendTo(music);
    $("<p>",{
        "class":"toSomebody",
        text:"To "+data.you+":"
    }).appendTo(center);
    $("<p>",{
        "class":"content",
        text:data.content
    }).appendTo(center);
    var button = $("<div>",{
        "class":"button",
        html:"<i class='iconfont'>&#xe64d;</i><span>"+data.greatNum+"</span>"
    }).appendTo(center);
    if(data.great){
        button.addClass("great");
    }else{
        button.on("touchend",function(){
            var id = $(this).parents(".music").data("id");
            var Obj = $(this);
            var data = {};
            data.id = id;
            data.Obj = Obj;
            greatFun(data);
        });
    }
}
var mainObj = $(".main");
var rankObj = $(".rank");
var historyObj = $(".history");
var indexObj = mainObj;
var $body = $("body");

var swiper = new Swiper('.swiper-container', {
    spaceBetween: 60,
    speed:500,
    touchMoveStopPropagation : false,
    resistanceRatio:0.7,
    onSlideChangeStart: function(){
        change(swiper.progress);
    },
    onSlideChangeEnd: function(){
        $('html, body').scrollTop(0);
    }
});
$(".title span").on("mouseover",function(){
    var num = +$(this).attr("num");
    swiper.slideTo(num*2, 500, false);
    change(num);
    setTimeout(function(){
        $('html, body').scrollTop(0);
    },500);
});
var indexNum=0;
var titleObj = $(".title span");
function change(data){
    titleObj.removeClass("click");
    switch (data){
        case 0:
            indexNum=0;
            indexObj = mainObj;
            $(titleObj[0]).addClass("click");
            break;
        case 0.5:
            indexNum=1;
            indexObj = rankObj;
            $(titleObj[1]).addClass("click");
            break;
        case 1:
            indexNum=2;
            indexObj = historyObj;
            $(titleObj[2]).addClass("click");
            break;
    }
}
$(document).ready(function(){
    $.ajax({
        //url: "{{action('ListController@getShow')}}",
        url: listShow,
        type: "get",
        data: {newpage:0, indexNum: 0},
        dataType: "json",
        contentType: "application/json;charset=utf-8",
        success: function (msg) {
            for (var j = 0; j < msg.length; j++) {
                music(mainObj, {
                    "id":msg[j].id,
                    "img":msg[j].img,
                    "music": msg[j].music.split("|")[0],
                    "singer": msg[j].music.split("|")[1],
                    "me": msg[j].nickname,
                    "time": msg[j].datetime,
                    "you": msg[j].recieve_name,
                    "content": msg[j].content,
                    "greatNum": msg[j].goods,
                    "great": msg[j].isPraise,
                    "accept": msg[j].accept
                });
            }
        },
        error: function (xhr) {
            err(dat);
        }
    });
    $.ajax({
        url:listShow,
        //url: "{{action('ListController@getShow')}}",
        type: "get",
        data: {newpage:0, indexNum: 1},
        dataType: "json",
        contentType: "application/json;charset=utf-8",
        success: function (msg) {
            for (var q = 0; q < msg.length; q++) {
                music(rankObj, {
                    "id":msg[q].id,
                    "img": msg[q].img,
                    "music": msg[q].music.split("|")[0],
                    "singer": msg[q].music.split("|")[1],
                    "me": msg[q].nickname,
                    "time":msg[q].datetime,
                    "you": msg[q].recieve_name,
                    "content": msg[q].content,
                    "greatNum": msg[q].goods,
                    "great": msg[q].isPraise,
                    "accept": msg[q].accept
                });
            }
        },
        error: function (xhr) {
            err(dat);
        }
    });
    $.ajax({
        url:listShow,
        //url: "{{action('ListController@getShow')}}",
        type: "get",
        data: {newpage:0, indexNum: 2},
        dataType: "json",
        contentType: "application/json;charset=utf-8",
        success: function (msg) {
            for (var w= 0; w < msg.length; w++) {
                music(historyObj, {
                    "id":msg[w].id,
                    "img": msg[w].img,
                    "music": msg[w].music.split("|")[0],
                    "singer": msg[w].music.split("|")[1],
                    "me": msg[w].nickname,
                    "time":msg[w].datetime,
                    "you": msg[w].recieve_name,
                    "content": msg[w].content,
                    "greatNum": msg[w].goods,
                    "great": msg[w].isPraise,
                    "accept": msg[w].accept                });
            }
        },
        error: function (xhr) {
            err(dat);
        }
    });
});
var mainpage=1;
var rankpage=1;
var historypage=1;
var newpage=1;
function listAjax(){
    switch (indexNum){
        case 0:
            newpage = mainpage;
            break;
        case 1:
            newpage = rankpage;
            break;
        case 2:
            newpage = historypage;
            break;
    }
    $.ajax({
        url:listShow,
        //url: "{{action('ListController@getShow')}}",
        type:"get",
        data:{newpage:newpage,indexNum:indexNum},
        dataType: "json",
        contentType: "application/json;charset=utf-8",
        success: function (msg) {
            if(msg.length != 0){
                for (var j = 0; j < msg.length; j++) {
                    music(indexObj,{
                        "id":msg[j].id,
                        "img": msg[j].img,
                        "music":msg[j].music.split("|")[0],
                        "singer":msg[j].music.split("|")[1],
                        "me":msg[j].nickname,
                        "time":msg[j].datetime,
                        "you":msg[j].recieve_name,
                        "content": msg[j].content,
                        "greatNum":msg[j].goods,
                        "great": msg[j].isPraise,
                        "accept": msg[j].accept
                    });
                }
            }else{
                indexObj.children(".pull").html("没有更多了...");
            }

            switch (indexNum){
                case 0:
                    mainpage++;
                    break;
                case 1:
                    rankpage++;
                    break;
                case 2:
                    historypage++;
                    break;
            }
            boolen = 1
        },
        error: function (xhr) {
            err(dat);
            boolen = 1
        }
    });
}
var boolen = 1;
$(document).on("touchmove",function(){
    if($(indexObj.children(".music")[indexObj.children(".music").length-1]).offset().top-(document.body.scrollTop+window.screen.height*3)<500 && boolen){
        boolen = 0;
        listAjax();
    }
});
$(".pull").on("click mouseover",function(){
    listAjax();
});


function err(data){
    var $err = $(".err");
    if($err.length == 0){
        $err = $("<div>",{
            "class":"err"
        }).appendTo($("body"));
    }else{
        $err.removeClass("animation");
    }
    setTimeout(function(){
        $err.text(data.text).addClass("animation");
    },200);
}
var dat = {};
dat.text = "连接服务器失败";

function getDate(tm){
    var tt=new Date(parseInt(tm) * 1000).toLocaleString();
    return tt;
}



function greatFun(data){
    data.Obj.addClass("great").off("touchend");
    $this = $(this);
    $.ajax({
        url: listPraise,
        type: "get",
        data:{bepraise_id:data.id},
        dataType: "json",
        contentType: "application/json;charset=utf-8",
        success: function (msg) {
            if(msg==100){
                var have={};
                have.text="已经点过的赞就不可以赞了哦";
                err(have);
            }else{
                var begood={};
                begood.text="点赞成功";
                err(begood);
                data.Obj.children("span").html((parseInt(data.Obj.children("span").html()))+1);

            }
        },
        error: function (xhr) {
            data.Obj.removeClass("great");
            err(dat);
        }
    });
}
