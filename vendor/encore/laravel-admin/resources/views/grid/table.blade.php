<div class="box grid-box">
    @if(isset($title))
    <div class="box-header with-border">
        <h3 class="box-title"> {{ $title }}</h3>
    </div>
    @endif

    @if ( $grid->showTools() || $grid->showExportBtn() || $grid->showCreateBtn() )
    <div class="box-header with-border">
        <div class="pull-right">
            {!! $grid->renderColumnSelector() !!}
            {!! $grid->renderExportButton() !!}
            {!! $grid->renderCreateButton() !!}
        </div>
        @if ( $grid->showTools() )
        <div class="pull-left">
            {!! $grid->renderHeaderTools() !!}
        </div>
        @endif
    </div>
    @endif

    {!! $grid->renderFilter() !!}

    {!! $grid->renderHeader() !!}

    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding ">
        <table class="table table-hover grid-table" id="{{ $grid->tableID }}">
            <thead>
                <tr>
                    @foreach($grid->visibleColumns() as $column)
                    <th {!! $column->formatHtmlAttributes() !!}>{!! $column->getLabel() !!}{!! $column->renderHeader() !!}</th>
                    @endforeach
                </tr>
            </thead>

            @if ($grid->hasQuickCreate())
                {!! $grid->renderQuickCreate() !!}
            @endif

            <tbody>

                @if($grid->rows()->isEmpty() && $grid->showDefineEmptyPage())
                    @include('admin::grid.empty-grid')
                @endif

                @foreach($grid->rows() as $row)
                <tr {!! $row->getRowAttributes() !!}>
                    @foreach($grid->visibleColumnNames() as $name)
                    <td {!! $row->getColumnAttributes($name) !!}>
                        {!! $row->column($name) !!}
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>

            {!! $grid->renderTotalRow() !!}

        </table>

    </div>

    {!! $grid->renderFooter() !!}

    <div class="box-footer clearfix">
        {!! $grid->paginator() !!}
    </div>
    <!-- /.box-body -->
</div>

<style>
    .popup-image {
        position: fixed;
        height: 100%;
        width: 100%;
        margin-left: 50px;
        top: 0;
        left: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 10000;
        display: none;
    }

    .popup-image span {
        position: absolute;
        top: 6rem;
        right: 9rem;
        font-size: 40px;
        font-weight: bolder;
        color: #fff;
        cursor: pointer;
        z-index: 100;
    }

    .popup-image img {
        max-width: 960px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
<div class="popup-image">
    <span class="close-popup">&times;</span>
    <img src="" alt="">
</div>

<script src="{{ asset('vendor/layer-v3.3.0/layer/layer.js') }}"></script>

<script>
  $(function () {
    $(document).on('click', '.file_path', function () {
      $('.popup-image').children('img').attr('src', this.src);
      $(".popup-image").show();
    });

    $(document).on('click', '.close-popup', function () {
      $(".popup-image").hide();
    });

    $(document).on('click', '.file-message', function () {
      let url = $(this).children('a').attr('href')
      window.open(url)
    });
  });
</script>
