/**
 * Created by Grallen on 2015/6/1.
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
    var del = $("<div>",{
        "class":"button",
        html:"删除"
    }).appendTo(center);
    del.hammer().on("tap",function(){
        var Obj = $(this).parents(".music");
        var id = Obj.data("id");
        var data = {};
        data.id = id;
        data.Obj = Obj;
        delect(data);
    });
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
var acceptedObj = $(".accepted");
var indexObj = mainObj;

var swiper = new Swiper('.swiper-container', {
    spaceBetween: 60,
    speed:500,
    touchMoveStopPropagation : false,
    resistanceRatio:0.7,
    onSlideChangeStart: function(){
        change(swiper.progress);
    },
    onSlideChangeEnd: function(){
        $('html, body').scrollTop(500);
    }
});
var nowNum = 0;
var titleObj = $(".title span");
function change(data){
    titleObj.removeClass("click");
    switch (data){
        case 0:
            nowNum=0;
            indexObj = mainObj;
            $(titleObj[0]).addClass("click");
            break;
        case 1:
            nowNum=1;
            indexObj = acceptedObj;
            $(titleObj[1]).addClass("click");
            break;
    }
}

$(document).on("touchmove",function(){
    if($(indexObj.children(".music")[indexObj.children(".music").length-1]).offset().top-(document.body.scrollTop+window.screen.height*3)<500 && boolen){
        boolen = 0;
        ajax();
    }
});

$(".pull").on("click mouseover",function(){
    ajax();
});

$(".title span").on("mouseover",function(){
    var num = +$(this).attr("num");
    swiper.slideTo(num, 500, false);
    change(num);
    setTimeout(function(){
        $('html, body').scrollTop(500);
    },500);
});
function getDate(tm){
    var tt=new Date(parseInt(tm) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ")
    return tt;
}
function greatFun(data){
    data.Obj.addClass("great").off("touchend");
    $.ajax({
        url:perPraise,
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
        }        },
        error: function (xhr) {
            data.Obj.removeClass("great");
            err(dat);
        }
    });
}

function delect(data){
    if(confirm("你确定要删除此条点歌吗？")){
        data.Obj.css("display","none");
        //console.log(data.id);
        $.ajax({
            url: perDelete,
            type: "get",
            data:{id:data.id},
            dataType: "json",
            contentType: "application/json;charset=utf-8",
            success: function (msg) {
                data.Obj.remove();
                var have={};
                have.text="删除成功！";
                err(have);
            },
            error: function (xhr) {
                err(dat);
                data.Obj.css("display","block");
            }
        });
    }
}
var mainNum = 1;
var acceptedNum = 1;
var newNum = 1;

function ajax(){
    switch (nowNum){
        case 0:
            newNum = mainNum;
            break;
        case 1:
            newNum = acceptedNum;
            break;
    }
    $.ajax({
        url: perDisplay,
        type: "get",
        data:{perNum:newNum,nowNum:nowNum},
        dataType: "json",
        contentType: "application/json;charset=utf-8",
        success: function (msg) {
            if(msg.length != 0){
                for(w=0;w<msg.length;w++) {
                    music(indexObj, {
                        "id": msg[w].id,
                        "img": msg[w].head_image,
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
            }else{
                indexObj.children(".pull").html("没有更多了...");
            }
            switch (nowNum){
                case 0:
                    mainNum++;
                    break;
                case 1:
                    acceptedNum++;
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

