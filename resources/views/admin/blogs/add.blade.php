@extends('admin._layout.layout')

@section('seo_title', __('Add new Blog'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Add new Blog')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang("Home")</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.blogs.index')}}">@lang("Blogs")</a></li>
                    <li class="breadcrumb-item active">@lang("Add new Blog")</li>
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
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">@lang("Enter data for the blog")</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form 
                        id="entity-form" 
                        role="form" 
                        action="{{route('admin.blogs.insert')}}" 
                        method="post" 
                        enctype="multipart/form-data"
                        > 
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Authors')</label>
                                        <select name="author_id" class="form-control @if($errors->has('author_id')) is-invalid @endif">
                                            <option value="">-- Choose Author --</option>
                                            @foreach($authors as $author)
                                            <option 
                                                value="{{$author->id}}"
                                                @if($author->id == old('author_id'))
                                                selected
                                                @endif
                                                >{{$author->name}}</option>
                                            @endforeach
                                        </select>
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'author_id'])
                                    </div>
                                    <div class="form-group">
                                        <label>@lang("Blog Category")</label>
                                        <select name="category_id"class="form-control @if($errors->has('category_id')) is-invalid @endif">
                                            <option value="">-- Choose Category --</option>
                                            @foreach($categories as $category)
                                            <option 
                                                value="{{$category->id}}"
                                                @if($category->id == old('category_id'))
                                                selected
                                                @endif
                                                >{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'category_id'])
                                    </div>
                                    <div class="form-group">
                                        <label>@lang("Title")</label>
                                        <input 
                                            name="title"
                                            value="{{old('title')}}"
                                            type="text" 
                                            class="form-control @if($errors->has('title')) is-invalid @endif" 
                                            placeholder="Enter title"
                                            >
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'title'])
                                    </div>
                                    <div class="form-group">
                                        <label>@lang("Description")</label>
                                        <textarea 
                                            name="description"
                                            class="form-control @if($errors->has('description')) is-invalid @endif" 
                                            placeholder="Enter Description"
                                            >{{old('description')}}</textarea>
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'description'])
                                    </div>
                                    <div class="form-group">
                                        <label>@lang("Status")</label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input 
                                                type="radio" 
                                                id="status-no" 
                                                name="status" 
                                                class="custom-control-input"
                                                value="0"
                                                @if(0 == old('status'))
                                                checked
                                                @endif
                                                >
                                            <label class="custom-control-label" for="status-no">@lang("Disabled")</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input 
                                                type="radio" 
                                                id="status-yes" 
                                                name="status" 
                                                value="1"
                                                class="custom-control-input"
                                                @if(1 == old('status'))
                                                checked
                                                @endif
                                                >
                                            <label class="custom-control-label" for="status-yes">@lang("Enabled")</label>
                                        </div>
                                        <div style="display: none;" class="form-control @if($errors->has('status')) is-invalid @endif">
                                        </div>
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'status'])
                                    </div>
                                    <div class="form-group">
                                        <label>@lang("On home page")</label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input 
                                                type="radio" 
                                                id="important-no" 
                                                name="important" 
                                                class="custom-control-input"
                                                value="0"
                                                @if(0 == old('important'))
                                                checked
                                                @endif
                                                >
                                            <label class="custom-control-label" for="important-no">@lang("No")</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input 
                                                type="radio" 
                                                id="important-yes" 
                                                name="important" 
                                                value="1"
                                                class="custom-control-input"
                                                @if(1 == old('important'))
                                                checked
                                                @endif
                                                >
                                            <label class="custom-control-label" for="important-yes">@lang("Yes")</label>
                                        </div>
                                        <div style="display: none;" class="form-control @if($errors->has('important')) is-invalid @endif">
                                        </div>
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'important'])
                                    </div>
                                    <div class="form-group select2-danger">
                                        <label>@lang("Tags")</label>
                                        <select name="tag_id[]" class="form-control @if($errors->has('tag_id')) is-invalid @endif" multiple>
                                            @foreach($tags as $tag)
                                            <option 
                                                value="{{$tag->id}}"
                                                @if(
                                                is_array(old('tag_id')) &&
                                                in_array($tag->id, old('tag_id'))
                                                )
                                                selected
                                                @endif
                                                >{{$tag->name}}</option>
                                            @endforeach
                                        </select>
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'tag_id'])
                                    </div>
                                    <div class="form-group">
                                        <label>@lang("Choose New Photo")</label>
                                        <input 
                                            name="photo" 
                                            type="file" 
                                            class="form-control @if($errors->has('photo')) is-invalid @endif"
                                            >
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'photo'])
                                    </div>
                                    <div class="form-group">
                                    <label>@lang("Content")</label>
                                    <textarea 
                                        name="content"
                                        class="form-control @if($errors->has('content')) is-invalid @endif" 
                                        placeholder="Enter content"
                                        >{{old('content')}}</textarea>
                                    @include('admin._layout.partials.form_errors', ['fieldName' => 'content'])
                                </div> 
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">@lang('Save')</button>
                            <a href="{{route('admin.blogs.index')}}" class="btn btn-outline-secondary">@lang('Cancel')</a>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@push('script_tags')
<script src="{{url('/themes/admin/plugins/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script src="{{url('/themes/admin/plugins/ckeditor/adapters/jquery.js')}}" type="text/javascript"></script>

<script type="text/javascript">
    $('#entity-form [name="content"]').ckeditor({
        height: "400px",
        filebrowserBrowseUrl: '{{route("elfinder.ckeditor")}}'
    });
    
    //Initialize Select2 Elements
    $('#entity-form select[name="author_id"]').select2({
        theme: 'bootstrap4'
    });
    $('#entity-form select[name="category_id"]').select2({
        theme: 'bootstrap4'
    });
    $('#entity-form select[name="tag_id[]"]').select2({
        theme: 'bootstrap4'
    });

    //VALIDATION
    $('#entity-form').validate({
        rules: {
            author_id: {
                required: true
            },
            category_id: {
                required: true
            },
            title: {
                required: true,
                maxlength: 255
            },
            description: {
                maxlength: 2000
            },
            status: {
                required: true
            },
            important: {
                required: true
            }, 
            content: {
                required: true,
                minlength: 100
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
</script>
@endpush