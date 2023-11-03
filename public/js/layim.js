layui.config({
    layimPath: 'vendor/layim.pro-v3.9.8/src/', layimAssetsPath: 'vendor/layim.pro-v3.9.8/dist/layim-assets/'
}).extend({
    layim: layui.cache.layimPath + 'layim'
}).use('layim', function (layim) {
    let prefix = $('meta[name="prefix"]').attr("content");
    let initUrl = "/" + prefix + "/layim/init";
    let statusUrl = "/" + prefix + "/layim/change/status";
    let sendMessageUrl = "/" + prefix + "/layim/send/message";
    let log = "/" + prefix + "/layim/log";
    let quickUrl = "/" + prefix + "/layim/quick";

    let quickList = [{"id": 1, "title": "你好"}, {"id": 2, "title": "在干什么"}];
    $.ajax({
        url: quickUrl,
        type: "post",
        data: {
            "_token": $('meta[name="csrf-token"]').attr("content"),
            "user_id": $('meta[name="user_id"]').attr("content"),
        }, success: function (result) {
            quickList = result.data
            
            layim.config({
                init: {
                    url: initUrl, type: 'post', data: {
                        "_token": $('meta[name="csrf-token"]').attr("content"),
                        "user_id": $('meta[name="user_id"]').attr("content")
                    }
                },
                brief: false,
                title: '汇旺担保',
                right: '30px',
                minRight: '90px',
                initSkin: '3.jpg',
                isfriend: false,
                isgroup: true,
                min: false,
                notice: true,
                voice: "default.mp3",
                copyright: true,
                quick: quickList,
                // chatLog: layui.cache.layimAssetsPath + 'html/chatlog.html'
            });
            
        }, error: function (data) {
        }
    });

    layim.on('ready', function (res) {
        console.log(res);
    });

    layim.on('sendMessage', function (data) {
        let id = data["to"]["id"];
        let info = data["mine"]["content"];

        $.ajax({
            url: sendMessageUrl, type: "post", data: {
                "_token": $('meta[name="csrf-token"]').attr("content"),
                "user_id": $('meta[name="user_id"]').attr("content"),
                "user_tg_id": id,
                "info": info,
            }, success: function () {
            }, error: function (data) {
            }
        });
    });

    layim.on('online', function (status) {
        $.ajax({
            url: statusUrl, type: "post", data: {
                "_token": $('meta[name="csrf-token"]').attr("content"),
                "user_id": $('meta[name="user_id"]').attr("content"),
                "status": status,
            }, success: function () {
            }, error: function (data) {
            }
        });
    });

    layim.on('chatChange', function (res) {
        let id = res.data.id;
        let id_str = ".layim-group" + id;

        $.ajax({
            url: log,
            type: "post",
            data: {
                "_token": $('meta[name="csrf-token"]').attr("content"),
                "user_id": $('meta[name="user_id"]').attr("content"),
                "user_tg_id": id,
            }, success: function (result) {
                layim.viewServerChatlog(result.data);
                $(id_str).find(".weidu").hide();
            }, error: function (data) {
            }
        });
    });
});

layui.use('layim', function (layim) {
    let prefix = $('meta[name="prefix"]').attr("content");
    let bindIdUrl = "/" + prefix + "/layim/bind";

    let socket = new WebSocket('ws://112.168.11.152:8282');

    socket.onopen = function () {
        socket.send('onopen');
    };

    socket.onmessage = function (res) {
        let data = res["data"];
        data = JSON.parse(data);
        let type = data.type;
        if (type === "group") {
            // layim.init();
            layim.getMessage(data);
        } else if (type === "init") {
            let client_id = data.client_id
            $.ajax({
                url: bindIdUrl, type: "post", data: {
                    "_token": $('meta[name="csrf-token"]').attr("content"),
                    "user_id": $('meta[name="user_id"]').attr("content"),
                    "client_id": client_id,
                }, success: function () {
                }, error: function (data) {
                }
            });
        } else if (type === "weidu") {
            let id_str = ".layim-group" + data["id"];
            console.log(data);
            if (data.num > 0) {
                if ($(".layui-show").find(".top-stlye").data("index") != data["id"]) {
                    $(id_str).find(".weidu").empty().html(data["num"]).show();   
                }
            }
        }
    };
});