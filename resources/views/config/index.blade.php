<style>
    #test1 {
        padding-top: 20px;
        padding-left: 20px;
    }

    .radio {
        display: inline-block;
    }

    .bold {
        font-weight: bold !important;
    }
</style>
<link rel="stylesheet" href="{{ asset('vendor/datatable/css/dataTables.bootstrap.css') }}">
<div class="box box-primary">
    <div class="box-body" id="test1">
        <div role="form">
            <div class="form-group">
                <span>真人验证错误次数（超过自动封禁）：</span>
                &nbsp;
                <span>{{ $verify_error_max_num }}</span>
                &nbsp;
                <button type="button" class="btn btn-sm btn-primary verify_error_max_num"
                        val="{{ $verify_error_max_num }}">修改
                </button>
            </div>
            <div class="form-group">
                <span>真人验证状态：</span>
                <label>
                    <input type="radio" name="rm" class="verify_status" @if($verify_status == 1) checked
                           @endif value="1">
                    开启
                </label>
                &nbsp;&nbsp;&nbsp;
                <label>
                    <input type="radio" name="rm" class="verify_status" @if($verify_status == 2) checked
                           @endif value="2">
                    关闭
                </label>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('vendor/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('vendor/layer-v3.3.0/layer/layer.js') }}"></script>
<script>
    $(function () {
        $(".verify_error_max_num").click(function () {
            layer.prompt({title: '真人验证错误次数'}, function (pass, index) {
                layer.close(index);

                let index_load = layer.load(0, {shade: false});

                $.ajax({
                    url: "{{adminUrl('config/change')}}",
                    type: "post",
                    data: {
                        _token: "{{csrf_token()}}",
                        "key": "verify_error_max_num",
                        "val": pass,
                    },
                    success: function (data) {
                        layer.close(index_load);
                        layer.msg(data["message"], {time: 200});

                        document.location.reload();
                    },
                    error: function (data) {
                        layer.close(index_load);
                        layer.msg(data["message"], {time: 200});
                    }
                });
            });
        });
        
        $(".verify_status").click(function () {
            let val = $(this).val();

            let layer1 = layer.load();

            $.ajax({
                type: "post",
                data: {
                    "_token": '{{ csrf_token() }}',
                    "key": "verify_status",
                    "val": val,
                },
                url: "{{adminUrl('config/change')}}",
                success: function () {
                    layer.close(layer1);

                    layer.msg("操作成功");
                },
                error: function (data) {
                    layer.close(layer1);

                    layer.msg(data["responseJSON"]["message"]);
                }
            });
        });
    });
</script>