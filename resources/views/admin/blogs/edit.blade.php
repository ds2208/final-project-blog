@extends('admin._layout.layout')

@section('seo_title', __('Edit Blog'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Edit Blog')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang("Home")</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.blogs.index')}}">@lang("Blogs")</a></li>
                    <li class="breadcrumb-item active">@lang("Edit Blog")</li>
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
                        <h3 class="card-title">@lang("Editing Blog:") #{{$blog->id}} | {{$blog->title}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form 
                        id="entity-form" 
                        role="form" 
                        action="{{route('admin.blogs.update', ['blog' => $blog->id])}}" 
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
                                                @if($author->id == old('author_id', $blog->author_id))
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
                                                @if($category->id == old('category_id', $blog->category_id))
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
                                            value="{{old('title', $blog->title)}}"
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
                                            >{{old('description', $blog->description)}}</textarea>
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
                                                @if(0 == old('status', $blog->status))
                                                checked
                                                @endif
                                                >
                                            <label class="custom-control-label" for="status-no">@lang("No")</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input 
                                                type="radio" 
                                                id="status-yes" 
                                                name="status" 
                                                value="1"
                                                class="custom-control-input"
                                                @if(1 == old('status', $blog->status))
                                                checked
                                                @endif
                                                >
                                            <label class="custom-control-label" for="status-yes">@lang("Yes")</label>
                                        </div>
                                        <div style="display: none;" class="form-control @if($errors->has('status')) is-invalid @endif">
                                        </div>
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'status'])
                                    </div>
                                    <div class="form-group">
                                        <label>@lang("Important")</label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input 
                                                type="radio" 
                                                id="important-no" 
                                                name="important" 
                                                class="custom-control-input"
                                                value="0"
                                                @if(0 == old('important', $blog->important))
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
                                                @if(1 == old('important', $blog->important))
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
                                        <label>@lang("Sizes")</label>
                                        <select name="tag_id[]" class="form-control @if($errors->has('tag_id')) is-invalid @endif" multiple>
                                            @foreach($tags as $tag)
                                            <option 
                                                value="{{$tag->id}}"
                                                @if(
                                                is_array(old('tag_id', $blog->tag_id)) &&
                                                in_array($tag->id, old('tag_id', $blog->tag_id))
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
                                <div class="offset-md-1 col-md-5">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang("Photo")</label>
                                                <div class="text-right">
                                                    <button 
                                                        type="button"
                                                        class="btn btn-sm btn-outline-danger"
                                                        data-action='delete'
                                                        data-photo='photo'
                                                        >
                                                        <i class="fas fa-remove"></i>
                                                        @lang("Delete Photo")
                                                    </button>
                                                </div>
                                                <div class="text-center">
                                                    <img 
                                                        src="{{$blog->getPhotoUrl()}}" 
                                                        alt="" 
                                                        class="img-fluid"
                                                        data-container='photo'
                                                        >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">@lang("Save")</button>
                            <a href="{{route('admin.blogs.index')}}" class="btn btn-outline-secondary">@lang("Cancel")</a>
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
    
    $('#entity-form').on('click', '[data-action="delete"]', function (e) {
        e.preventDefault();
        $.ajax({
            "url": "{{route('admin.blogs.delete_photo', ['blog' => $blog->id])}}",
            "type": "post",
            "data": {
                "_token": "{{csrf_token()}}"
            }
        }).done(function (response) {
            toastr.success(response.system_message);
            $("[data-container='photo']").attr('src', response.photo_url);
        }).fail(function () {
            toastr.error('Something is wrong');
        });
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