@extends('admin._layout.layout')

@section('seo_title', __('Blogs'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Blogs</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.index.index')}}">
                            @lang('Home')
                        </a>
                    </li>
                    <li class="breadcrumb-item active">@lang('Blogs')</li>
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
                        <h3 class="card-title">{{__("Search Blogs")}}</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.blogs.add')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                {{__("Add new Blog")}}
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="entities-filter-form">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label>{{__("Title")}}</label>
                                    <input 
                                        name="title" 
                                        value="" 
                                        type="text" 
                                        class="form-control" 
                                        placeholder="Search by title"
                                        >
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>{{__("Author")}}</label>
                                    <select name="author_id" class="form-control">
                                        <option value="">--{{__("Choose Author")}}--</option>
                                        @foreach($authors as $author)
                                        <option value="{{$author->id}}">{{$author->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>{{__("Category")}}</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">--{{__("Choose Category")}}--</option>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1 form-group">
                                    <label>{{__("Status")}}</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- {{__("All")}} --</option>
                                        <option value="1">{{__("Yes")}}</option>
                                        <option value="0">{{__("No")}}</option>
                                    </select>
                                </div>
                                <div class="col-md-1 form-group">
                                    <label>{{__("Important")}}</label>
                                    <select name="important" class="form-control">
                                        <option value="">-- {{__("All")}} --</option>
                                        <option value="1">{{__("Yes")}}</option>
                                        <option value="0">{{__("No")}}</option>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>{{__("Tags")}}</label>
                                    <select name="tags[]" class="form-control" multiple>
                                        @foreach($tags as $tag)
                                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('All Blogs')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="row-list-table" class="table table-bordered">
                            <thead>                  
                                <tr>
                                    <th class="text-center">{{__("Photo")}}</th>
                                    <th class="text-center">{{__("Status")}}</th>
                                    <th class="text-center">{{__("Important")}}</th>
                                    <th class="text-center">{{__("Category")}}</th>
                                    <th style="width: 15%;">{{__("Title")}}</th>
                                    <th style="width: 5%;">{{__("Comments")}}</th>
                                    <th style="width: 5%;">{{__("Views")}}</th>
                                    <th class="text-center">{{__("Author")}}</th>
                                    <th class="text-center">{{__("Created At")}}</th>
                                    <th style="width: 20%;" class="text-center">{{__("Actions")}}</th>
                                </tr>
                            </thead>
                            <tbody>

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
<form action="{{route('admin.blogs.delete')}}" method="post" class="modal fade" id="delete-modal">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__("Delete Blog")}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{__("Are you sure you want to delete blog?")}}</p>
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
<form action="{{route('admin.blogs.disable')}}" class="modal fade" id="disable-modal">
    @csrf
    <input type="hidden" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__("Disable Blog")}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{__("Are you sure you want to disable blog?")}}</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__("Cancel")}}</button>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-minus-circle"></i>
                    {{__("Disable")}}
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->
<form action="{{route('admin.blogs.enable')}}" method="post" class="modal fade" id="enable-modal">
    @csrf
    <input type="hidden" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__("Enable Blog")}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{__("Are you sure you want to enable blog?")}}</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__("Cancel")}}</button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i>
                    {{__("Enable")}}
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->
<form action="{{route('admin.blogs.get_important')}}" class="modal fade" id="get-important-modal">
    @csrf
    <input type="hidden" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__("Make Blog Important")}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{__("Are you sure you want to make Blog important?")}}</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__("Cancel")}}</button>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-minus-circle"></i>
                    {{__("Make Blog Important")}}
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->
<form action="{{route('admin.blogs.get_not_important')}}" method="post" class="modal fade" id="get-not-important-modal">
    @csrf
    <input type="hidden" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__("Make Blog Not important")}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{__("Are you sure you want to make Blog not important?")}}</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__("Cancel")}}</button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i>
                    {{__("Make Blog Not important")}}
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->
@endsection

@push('script_tags')
<script type="text/javascript">
    //SELECT2
    $('#entities-filter-form [name="tags[]"]').select2({
        theme: 'bootstrap4'
    });
    $('#entities-filter-form select[name="category_id"]').select2({
        theme: 'bootstrap4'
    });
    $('#entities-filter-form select[name="author_id"]').select2({
        theme: 'bootstrap4'
    });
    $('#entities-filter-form select[name="status"]').select2({
        theme: 'bootstrap4'
    });
    $('#entities-filter-form select[name="important"]').select2({
        theme: 'bootstrap4'
    });

    $('#entities-filter-form [name]').on('change keyup', function (e) {
        e.preventDefault();
        $('#entities-filter-form').trigger('submit');
    });
    $('#entities-filter-form').on('submit', function (e) {
        e.preventDefault();
        entitiesDataTable.ajax.reload(null, true);
    });

    let entitiesDataTable = $('#row-list-table').DataTable({
        'serverSide': true,
        'processing': true,
        'ajax': {
            'url': "{{route('admin.blogs.datatable')}}",
            'type': 'post',
            'data': function (dtData) {
                dtData['_token'] = '{{csrf_token()}}';

                dtData['author_id'] = $('#entities-filter-form [name="author_id"]').val();
                dtData['category_id'] = $('#entities-filter-form [name="category_id"]').val();
                dtData['title'] = $('#entities-filter-form [name="title"]').val();
                dtData['status'] = $('#entities-filter-form [name="status"]').val();
                dtData['important'] = $('#entities-filter-form [name="important"]').val();
                dtData['tags'] = $('#entities-filter-form [name="tags[]"]').val();
            }
        },
        'pageLength': 5,
        'lengthMenu': [5, 10, 20],
        'order': [[4, 'desc']],
        'columns': [
            {'name': 'photo', 'data': 'photo', "orderable": false, "searchable": false},
            {'name': 'status', 'data': 'status', "searchable": false},
            {'name': 'important', 'data': 'important', "searchable": false},
            {'name': 'category_name', 'data': 'category_name'},
            {'name': 'title', 'data': 'title'},
            {'name': 'total_comments', 'data': 'total_comments', "searchable": false},
            {'name': 'views', 'data': 'views', "searchable": false},
            {'name': 'author_name', 'data': 'author_name', "orderable": false},
            {'name': 'created_at', 'data': 'created_at', "searchable": false},
            {'name': 'actions', 'data': 'actions', "orderable": false, "searchable": false}
        ]
    });

    //delete modal
    $('#row-list-table').on('click', '[data-action="delete"]', function (e) {
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');
        $('#delete-modal [name="id"]').val(id);
        $('#delete-modal [data-container="name"]').html(name);
    });
    $('#delete-modal').on('submit', function (e) {
        e.preventDefault();
        $(this).modal('hide');
        $.ajax({
            "url": $(this).attr('action'),
            "type": 'post',
            "data": $(this).serialize()
        }).done(function (response) {
            toastr.success(response.system_message);
            entitiesDataTable.ajax.reload(null, false);
        }).fail(function () {
            toastr.error("@lang('Something is wrong!')");
        });
    });

    //enable modal
    $('#row-list-table').on('click', '[data-action="enable"]', function (e) {
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');
        $('#enable-modal [name="id"]').val(id);
        $('#enable-modal [data-container="name"]').html(name);
    });
    $('#enable-modal').on('submit', function (e) {
        e.preventDefault();
        $(this).modal('hide');
        $.ajax({
            "url": $(this).attr('action'),
            "type": "post",
            "data": $(this).serialize()
        }).done(function (response) {
            toastr.success(response.system_message);
            entitiesDataTable.ajax.reload(null, false);
        }).fail(function (xhr) {
            let systemError = "@lang('Error occured while enable blog')";
            if (xhr.responseJSON && xhr.responseJSON['system_error']) {
                systemError = xhr.responseJSON['system_error'];
            }
            toastr.error(systemError);
        });
    });

    //disable modal
    $('#row-list-table').on('click', '[data-action="disable"]', function (e) {
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');
        $('#disable-modal [name="id"]').val(id);
        $('#disable-modal [data-container="name"]').html(name);
    });
    $('#disable-modal').on('submit', function (e) {
        e.preventDefault();
        $(this).modal('hide');
        $.ajax({
            "url": $(this).attr('action'),
            "type": "post",
            "data": $(this).serialize()
        }).done(function (response) {
            toastr.success(response.system_message);
            entitiesDataTable.ajax.reload(null, false);
        }).fail(function (xhr) {
            let systemError = "@lang('Error occured while disable blog')";
            if (xhr.responseJSON && xhr.responseJSON['system_error']) {
                systemError = xhr.responseJSON['system_error'];
            }
            toastr.error(systemError);
        });
    });

//get important modal
    $('#row-list-table').on('click', '[data-action="get-important"]', function (e) {
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');
        $('#get-important-modal [name="id"]').val(id);
        $('#get-important-modal [data-container="name"]').html(name);
    });
    $('#get-important-modal').on('submit', function (e) {
        e.preventDefault();
        $(this).modal('hide');
        $.ajax({
            "url": $(this).attr('action'),
            "type": "post",
            "data": $(this).serialize()
        }).done(function (response) {
            toastr.success(response.system_message);
            entitiesDataTable.ajax.reload(null, false);
        }).fail(function (xhr) {
            let systemError = "@lang('Error occured while get important blog')";
            if (xhr.responseJSON && xhr.responseJSON['system_error']) {
                systemError = xhr.responseJSON['system_error'];
            }
            toastr.error(systemError);
        });
    });

    //get not important modal
    $('#row-list-table').on('click', '[data-action="get-not-important"]', function (e) {
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');
        $('#get-not-important-modal [name="id"]').val(id);
        $('#get-not-important-modal [data-container="name"]').html(name);
    });
    $('#get-not-important-modal').on('submit', function (e) {
        e.preventDefault();
        $(this).modal('hide');
        $.ajax({
            "url": $(this).attr('action'),
            "type": "post",
            "data": $(this).serialize()
        }).done(function (response) {
            toastr.success(response.system_message);
            entitiesDataTable.ajax.reload(null, false);
        }).fail(function (xhr) {
            let systemError = "@lang('Error occured while get not important blog')";
            if (xhr.responseJSON && xhr.responseJSON['system_error']) {
                systemError = xhr.responseJSON['system_error'];
            }
            toastr.error(systemError);
        });
    });
</script>
@endpush