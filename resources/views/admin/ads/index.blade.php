@extends('admin._layout.layout')

@section('seo_title', __('Ads'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__("Ads")}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">{{__("Index")}}</a></li>
                    <li class="breadcrumb-item active">{{__("Ads")}}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__("All Ads")}}</h3>
                        <div class="card-tools">
                            <form style="display: none;" id="change-priority-form" class="btn-group" method="post" action="{{route('admin.ads.change_priorities')}}">
                                @csrf
                                <input type="hidden" name="priorities" value="">
                                <button type="submit" class="btn btn-outline-success">
                                    <i class="fas fa-check"></i>
                                    {{__("Save Order")}}
                                </button>
                                <button type="button" data-action='hide-form' class="btn btn-outline-danger">
                                    <i class="fas fa-remove"></i>
                                    {{__("Cancel")}}
                                </button>
                            </form>
                            <button data-action='show-form' class="btn btn-outline-secondary">
                                <i class="fas fa-sort"></i>
                                {{__("Change Order")}}
                            </button>
                            <a href="{{route('admin.ads.add')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                {{__("Add new Ad")}}
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id="row-list-table">
                            <thead>                  
                                <tr>
                                    <th style="width: 10%">#</th>
                                    <th style="width: 20%;">{{__("Title")}}</th>
                                    <th style="width: 10%;">{{__("Button title")}}</th>
                                    <th style="width: 30%;">{{__("URL")}}</th>
                                    <th class="text-center">{{__("Created At")}}</th>
                                    <th class="text-center">{{__("Last Change")}}</th>
                                    <th class="text-center">{{__("Action")}}</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-list">
                                @foreach($ads as $ad)
                                <tr data-id="{{$ad->id}}">
                                    <td>
                                        <span style="display: none;" class="btn btn-outline-secondary handle">
                                            <i class="fas fa-sort"></i>
                                        </span>
                                        #{{$ad->id}}
                                    </td>
                                    <td>
                                        @if($ad->isOnIndexPage())
                                        <strong class="text-success">{{$ad->title}}</strong>
                                        @else
                                        <strong class="text-danger">{{$ad->title}}</strong>
                                        @endif
                                    </td>
                                    <td>
                                        {{$ad->button_title}}
                                    </td>
                                    <td>
                                        {{Str::limit($ad->url, 20, ' ...')}}
                                    </td>
                                    <td class="text-center">{{$ad->created_at}}</td>
                                    <td class="text-center">{{$ad->updated_at}}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{route('admin.ads.edit', ['ad' => $ad->id])}}" class="btn btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button 
                                                type="button" 
                                                class="btn btn-info" 
                                                data-toggle="modal" 
                                                data-target="#change-modal"
                                                data-action='change-index'
                                                data-id="{{$ad->id}}"
                                                data-title="{{$ad->title}}"
                                                >
                                                @if($ad->index == 0)
                                                <i class="fas fa-plus-circle"></i>
                                                @else
                                                <i class="fas fa-minus-circle"></i>
                                                @endif
                                            </button>
                                            <button 
                                                type="button" 
                                                class="btn btn-info" 
                                                data-toggle="modal" 
                                                data-target="#delete-modal"
                                                data-action='delete'
                                                data-id='{{$ad->id}}'
                                                data-title='{{$ad->title}}'
                                                >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<form class="modal fade" id="delete-modal" action="{{route('admin.ads.delete')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__("Delete Ad")}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{__("Are you sure you want to delete Ad?")}}</p>
                <strong data-container="title"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__("Cancel")}}</button>
                <button type="submit" class="btn btn-danger">{{__("Delete")}}</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<form action="{{route('admin.ads.change_index')}}" method="post" class="modal fade" id="change-modal">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Change Index')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang('Are you sure you want to change index?')</p>
                <strong data-container="title"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Cancel')</button>
                <button type="submit" class="btn btn-danger">@lang('Change')</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->
@endsection

@push('head_links')
<link href="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.theme.min.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@push('script_tags')
<script src="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>

<script type="text/javascript">
$('#row-list-table').on('click', '[data-action="delete"]', function (e) {

    let id = $(this).attr('data-id');
    let title = $(this).attr('data-title');

    $('#delete-modal [name="id"]').val(id);
    $('#delete-modal [data-container="title"]').html(title);
});

$('#row-list-table').on('click', "[data-action='change-index']", function (e) {

    let id = $(this).attr('data-id');
    let title = $(this).attr('data-title');

    $('#change-modal [name="id"]').val(id);

    $('#change-modal [data-container="title"]').html(title);
});

$('#sortable-list').sortable({
    'handle': '.handle',
    'update': function (event, ui) {
        let sortedIDs = $("#sortable-list").sortable("toArray", {
            'attribute': 'data-id'
        });

        $('#change-priority-form [name="priorities"]').val(sortedIDs.join(','));
    }
});

$('[data-action="show-form"]').on('click', function (e) {
    $('[data-action="show-form"]').hide();
    $('#change-priority-form').show();
    $('#sortable-list .handle').show();
});

$('[data-action="hide-form"]').on('click', function (e) {
    $('#change-priority-form').hide();
    $('#sortable-list .handle').hide();
    $('[data-action="show-form"]').show();
    $("#sortable-list").sortable("cancel");
});
</script>
@endpush