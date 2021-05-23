@extends('admin._layout.layout')

@section('seo_title', __('Categories'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__("Categories")}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">{{__("Index")}}</a></li>
                    <li class="breadcrumb-item active">{{__("Categories")}}</li>
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
                        <h3 class="card-title">{{__("All Categories")}}</h3>
                        <div class="card-tools">
                            <form style="display: none;" id="change-priority-form" class="btn-group" method="post" action="{{route('admin.categories.change_priorities')}}">
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
                            <a href="{{route('admin.categories.add')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                {{__("Add new Category")}}
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id="row-list-table">
                            <thead>                  
                                <tr>
                                    <th style="width: 10%">#</th>
                                    <th style="width: 30%;">{{__("Name")}}</th>
                                    <th style="width: 30%;">{{__("Description")}}</th>
                                    <th class="text-center">{{__("Created At")}}</th>
                                    <th class="text-center">{{__("Last Change")}}</th>
                                    <th class="text-center">{{__("Action")}}</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-list">
                                @foreach($categories as $category)
                                <tr data-id="{{$category->id}}">
                                    <td>
                                        <span style="display: none;" class="btn btn-outline-secondary handle">
                                            <i class="fas fa-sort"></i>
                                        </span>
                                        #{{$category->id}}
                                    </td>
                                    <td>
                                        <strong>{{$category->name}}</strong>
                                    </td>
                                    <td>
                                        {{Str::limit($category->description, 20, ' ...')}}
                                    </td>
                                    <td class="text-center">{{$category->created_at}}</td>
                                    <td class="text-center">{{$category->updated_at}}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{$category->getFrontUrl()}}" class="btn btn-info" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{route('admin.categories.edit', ['category' => $category->id])}}" class="btn btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button 
                                                type="button" 
                                                class="btn btn-info" 
                                                data-toggle="modal" 
                                                data-target="#delete-modal"
                                                data-action='delete'
                                                data-id='{{$category->id}}'
                                                data-name='{{$category->name}}'
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

<form class="modal fade" id="delete-modal" action="{{route('admin.categories.delete')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__("Delete Category")}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{__("Are you sure you want to delete category?")}}</p>
                <strong data-container="name"></strong>
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
    let name = $(this).attr('data-name');

    $('#delete-modal [name="id"]').val(id);
    $('#delete-modal [data-container="name"]').html(name);
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