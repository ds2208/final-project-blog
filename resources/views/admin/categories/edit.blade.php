@extends('admin._layout.layout')

@section('seo_title', __('Edit Category'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Edit Category')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.categories.index')}}">@lang('Categories')</a></li>
                    <li class="breadcrumb-item active">@lang('Edit Category')</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">@lang("Editing category"): #{{$category->id}} - {{$category->name}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="entity-form" role="form" action="{{route('admin.categories.update', ['category' => $category->id])}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>@lang("Name")</label>
                                <input 
                                    name="name"
                                    value="{{old('name', $category->name)}}"
                                    type="text" 
                                    class="form-control @if($errors->has('name')) is-invalid @endif" 
                                    placeholder="{{__('Enter name')}}"
                                    >
                                @include('admin._layout.partials.form_errors', ['fieldName' => 'name'])
                            </div>
                            <div class="form-group">
                                <label>@lang('Description')</label>
                                <textarea 
                                    class="form-control @if($errors->has('description')) is-invalid @endif" 
                                    placeholder="{{__('Enter description')}}"
                                    name="description"
                                    >{{old('description', $category->description)}}</textarea>
                                @include('admin._layout.partials.form_errors', ['fieldName' => 'description'])
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">@lang('Save')</button>
                            <a href="{{route('admin.categories.index')}}" class="btn btn-outline-secondary">@lang('Cancel')</a>
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
<script type="text/javascript">
    $('#entity-form').validate({
        rules: {
            name: {
                required: true,
                maxlength: 20
            },
            description: {
                required: false,
                minlength: 10
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