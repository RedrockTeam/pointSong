/**
 * Created by Grallen on 2015/5/27.
 */
$(window).on("beforeunload",function(){
    return "你有没有保存的点歌信息，"
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

var wordillegal = {};
wordillegal.text = "您的输入包含违规字，请重新输入";

var blank={};
blank.text="您填写的信息不完整，请检查";

var error={};
error.text="您的输入有误，请核对";

var su={};
su.text="您已经成功提交";