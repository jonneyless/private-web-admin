<style>
    .direct-chat-messages {
        min-height: 680px;
    }

    .ml5 {
        margin-left: 5px;
    }

    .mr5 {
        margin-right: 5px;
    }
    
    .direct-chat-text {
        position: relative;
    }

    .direct-chat-text-left {
        display: inline-block;
        margin-left: 5px !important;
    }

    .direct-chat-text-right {
        display: inline-block;
        float: right;
        margin-right: 0px !important;
    }

    .direct-chat-text {
        background: #f1f2f6;
        border: 1px solid #f1f2f6;
    }

    .file_path {
        height: 100px;
        width: 100px;
    }
    
    .direct-chat-text:after, .direct-chat-text:before {
        display: none;
    }
</style>
<input name="from_id" type="hidden" value="{{ $from['id'] }}">
<div class="box box-primary">
    <div style="margin-left: 15px;margin-top: 15px;">
        <dl style="margin-bottom: 0px;">
            <dd>
                验证状态：
                <div class="form-group" style="display: inline-block;">
                    <label>
                        <input type="radio" name="r1" class="flag" @if($from["flag"] == 1) checked
                               @endif value="1">
                        待验证
                    </label>
                    &nbsp;&nbsp;&nbsp;
                    <label>
                        <input type="radio" name="r1" class="flag" @if($from["flag"] == 2) checked
                               @endif value="2">
                        成功
                    </label>
                    &nbsp;&nbsp;&nbsp;
                    <label>
                        <input type="radio" name="r1" class="flag" @if($from["flag"] == 3) checked
                               @endif value="3">
                        失败
                    </label>
                </div>
            </dd>
        </dl>
        <dl style="margin-bottom: 0px;">
            <dd>
                封禁状态：
                <div class="form-group" style="display: inline-block;">
                    <label>
                        <input type="radio" name="r2" class="status" @if($from["status"] == 1) checked
                               @endif value="1">
                        正常
                    </label>
                    &nbsp;&nbsp;&nbsp;
                    <label>
                        <input type="radio" name="r2" class="status" @if($from["status"] == 2) checked
                               @endif value="2">
                        封禁中
                    </label>
                </div>
            </dd>
        </dl>
    </div>  
    <hr/ style="margin-top: 0;">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $from["fullname"] }}&nbsp;&nbsp;&nbsp;{{ "@" . $from["username"] }}</h3>
    </div>
    <div class="box-body">
        <div class="direct-chat-messages">
            @foreach($messages as $message)
                @if($message["user_id"] == -1)
                    <div class="direct-chat-msg">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-timestamp pull-left ml5">{{ $message["created_at"] }}</span>
                        </div>
                        @if($message["type"] > 1)
                            <img src="{{ $message['file_path'] }}" alt="" class="file_path">
                        @else
                            <div class="direct-chat-text direct-chat-text-left">{{ $message["info"] }}</div>
                        @endif
                    </div>
                @else
                    <div class="direct-chat-msg right">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-right">{{ $fullname }}</span>
                            <span class="direct-chat-timestamp pull-right mr5">{{ $message["created_at"] }}</span>
                        </div>
                        <div class="direct-chat-text direct-chat-text-right">
                            {{ $message["info"] }}
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
<script src="{{ asset('vendor/layer-v3.3.0/layer/layer.js') }}"></script>
<script>
    $(function () {
        $(".flag").click(function () {
            let val = $(this).val();

            let layer1 = layer.load();

            $.ajax({
                type: "post",
                data: {
                    "_token": '{{ csrf_token() }}',
                    "from_id": $("input[name='from_id']").val(),
                    "flag": val,
                },
                "url": "{{adminUrl('from/changeFlag')}}",
                success: function (data) {
                    layer.close(layer1);

                    layer.msg(data["message"]);
                },
                error: function (data) {
                    layer.close(layer1);

                    layer.msg(data["message"]);
                }
            });
        });
        
        $(".status").click(function () {
            let val = $(this).val();

            let layer1 = layer.load();

            $.ajax({
                type: "post",
                data: {
                    "_token": '{{ csrf_token() }}',
                    "from_id": $("input[name='from_id']").val(),
                    "status": val,
                },
                "url": "{{adminUrl('from/changeStatus')}}",
                success: function (data) {
                    layer.close(layer1);

                    layer.msg(data["message"]);
                },
                error: function (data) {
                    layer.close(layer1);

                    layer.msg(data["message"]);
                }
            });
        });
    });
</script>