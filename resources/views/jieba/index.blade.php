<style>
    .ml30 {
        margin-left: 30px;
    }

    .box {
        padding: 15px;
    }

    .fb {
        font-weight: bold !important;
    }

    .add {
        margin-left: 5px;
        color: green;
        font-weight: bold !important;
        /*font-size: 18px!important;*/
        display: none;
    }

    .sub {
        margin-left: 5px;
        color: red;
        font-weight: bold !important;
        /*font-size: 18px!important;*/
        display: none;
    }

    .active {
        background-color: green !important;
    }

    .col-md-12 .dbdata {
        display: inline-block;
        width: 20%;
        margin-top: 5px;
        margin-bottom: 5px;
    }

    .col-md-12 .fb {
        margin-bottom: 10px;
    }

    .duibi, .com {
        display: none;
    }
</style>
<link rel="stylesheet" href="{{ asset('vendor/datatable/css/dataTables.bootstrap.css') }}">
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div role="form">
                    <div class="form-group">
                        <span>开始时间：</span>
                        <input type="text" id="startTime4" name="startTime4" autocomplete="off" size="35"
                               style="display: inline-block;" class="startTime" value="{{ $start_at }}">
                        &nbsp;&nbsp;&nbsp;
                        <span>结束时间：</span>
                        <input type="text" id="endTime4" name="endTime4" autocomplete="off" size="35"
                               style="display: inline-block;" class="endTime" value="{{ $end_at }}">
                        &nbsp;&nbsp;&nbsp;
                        <input type="button" class="btn btn-info btn-sm submit4" value="查询">
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover dataTable" id="dataTable4"
                           style="width: 100%;">
                        <thead>
                        <tr>
                            <th>内容</th>
                            <th>出现次数</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('vendor/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('vendor/layer-v3.3.0/layer/layer.js') }}"></script>
<script>
  $(function () {
    $("#startTime4").datetimepicker({
      format: 'YYYY-MM-DD', locale: 'zh-cn'
    });
    $("#endTime4").datetimepicker({
      format: 'YYYY-MM-DD', locale: 'zh-cn'
    });
    let dataTable4 = $('#dataTable4').DataTable({
      "paging": false,
      "pageLength": 100,
      "lengthChange": false,
      "processing": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "deferRender": false,
      "serverSide": true,
      "destroy": true,
      "pagingType": "simple",
      "ajax": {
        "method": "post", "url": "{{adminUrl('jieba/data')}}", "data": function (d) {
          return $.extend({}, d, {
            "_token": "{{csrf_token()}}", "startTime": $("#startTime4").val(), "endTime": $("#endTime4").val()
          });
        }
      },
      language: {
        emptyTable: "没有数据可以显示",
        infoEmpty: "没有数据可以显示",
        info: "从 _START_ 到 _END_ ，总共 _TOTAL_ 条",
        paginate: {
          previous: "上页&nbsp;", next: "&nbsp;下页"
        }
      },
      "columns": [{"data": "info"}, {"data": "num"},],
    });
    $(".submit4").click(function () {
      dataTable4.ajax.reload();
    });
  });
</script>
