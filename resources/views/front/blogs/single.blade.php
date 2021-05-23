@extends('front._layout.layout')

@section('seo_title', $blog->title)
@section('seo_description', $blog->description)
@section('seo_image', $blog->getPhotoUrl())

@push('head_meta')

@endpush


@section('content')
<div class="container">
    <div class="row">
        <!--Blog post -->
        <main class="post blog-post col-lg-8"> 
            <div class="container">
                <div class="post-single">
                    <div class="post-thumbnail"><img src="{{$blog->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            @if($blog->haveCategory())
                            <div class="category"><a href="{{$blog->category->getFrontUrl()}}">{{$blog->category->name}}</a></div>
                            @else
                            <div class="category"><a>{{__("Uncategorized")}}</a></div>
                            @endif
                        </div>
                        <h1>{{$blog->title}}<a href="#"><i class="fa fa-bookmark-o"></i></a></h1>
                        <div class="post-footer d-flex align-items-center flex-column flex-sm-row"><a href="{{$blog->author->getFrontUrl()}}" class="author d-flex align-items-center flex-wrap">
                                <div class="avatar"><img src="{{$blog->author->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                                <div class="title"><span>{{$blog->author->name}}</span></div></a>
                            <div class="d-flex align-items-center flex-wrap">       
                                <div class="date"><i class="icon-clock"></i>{{$blog->dateInAgoFormat()}}</div>
                                <div class="views"><i class="icon-eye"></i>{{$blog->views}}</div>
                                <div class="comments meta-last"><a href="#post-comments"><i class="icon-comment"></i>{{$blog->comments()->count()}}</a></div>
                            </div>
                        </div>
                        <div class="post-body">
                            <p class="lead">{{$blog->description}}</p>
                            <blockquote class="blockquote">
                                {!! $blog->content !!}
                            </blockquote>
                        </div>
                        <div class="post-tags">
                            @foreach($blog->tags as $tag)
                            <a href="{{$tag->getFrontUrl()}}" class="tag">#{{$tag->name}}</a>
                            @endforeach
                        </div>
                        <div class="posts-nav d-flex justify-content-between align-items-stretch flex-column flex-md-row">
                            <a href="{{$blog->previousBlog()->getFrontUrl()}}" class="prev-post text-left d-flex align-items-center">
                                <div class="icon prev"><i class="fa fa-angle-left"></i></div>
                                <div class="text"><strong class="text-primary">{{__('Previous Post')}}</strong>
                                    <h6>{{$blog->previousBlog()->title}}</h6>
                                </div>
                            </a>
                            <a href="{{($blog->nextBlog())->getFrontUrl()}}" class="next-post text-right d-flex align-items-center justify-content-end">
                                <div class="text"><strong class="text-primary">{{__("Next Post")}}</strong>
                                    <h6>{{$blog->nextBlog()->title}}</h6>
                                </div>
                                <div class="icon next"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </div>
                        <div class="comment-container">

                        </div>
                        <div class="add-comment">
                            <header>
                                <h3 class="h6">{{__("Leave a reply")}}</h3>
                            </header>
                            <form id="form-add-comments" action="{{route('front.blogs.add_comment')}}" class="commenting-form" method="post">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input 
                                            type="text" 
                                            name="name"
                                            value=""
                                            id="username" 
                                            placeholder="{{__('Name')}}" 
                                            class="form-control"
                                            >
                                        @include('front._layout.partials.form_errors', ['fieldName' => 'name'])
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input 
                                            type="email" 
                                            name="email"
                                            value=""
                                            id="useremail" 
                                            placeholder="@lang('Email Address (will not be published)')" 
                                            class="form-control"
                                            >
                                        @include('front._layout.partials.form_errors', ['fieldName' => 'email'])
                                    </div>
                                    <div class="form-group col-md-12">
                                        <textarea 
                                            name="content" 
                                            id="usercomment" 
                                            placeholder="@lang('Type your comment')" 
                                            class="form-control"
                                            ></textarea>
                                        @include('front._layout.partials.form_errors', ['fieldName' => 'content'])
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button 
                                            type="submit" 
                                            class="btn btn-secondary"
                                            data-action='add_comment'
                                            data-blog-id="{{$blog->id}}"
                                            >{{__("Submit Comment")}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @include('front._layout.partials.aside')
    </div>
</div>
@endsection

@push('scripts')
<script src="{{url('/themes/front/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{url('/themes/front/js/additional-methods.min.js')}}" type="text/javascript"></script>

<script type="text/javascript">
function commentContainerRefresh() {
    $.ajax({
        "url": "{{route('front.blogs.partials.comments')}}",
        "type": "post",
        "data": {
            '_token': "{{csrf_token()}}",
            'blog_id': "{{$blog->id}}"
        }
    }).done(function (response) {
        $('.comment-container').html(response);
    }).fail(function (jqXHR, textStatus, error) {
        console.log('Error!');
    });
}

commentContainerRefresh();

function addComment(blog_id, name, email, content) {
    $.ajax({
        "url": "{{route('front.blogs.add_comment')}}",
        "type": "post",
        "data": {
            '_token': "{{csrf_token()}}",
            'blog_id': blog_id,
            'name': name,
            'email': email,
            'content': content
        }
    }).done(function (response) {
        $('#username').val('');
        $('#useremail').val('');
        $('#usercomment').val('');
        let systemMessage = "Success, you added new comment!";
        if (systemMessage !== "") {
            toastr.success(response.systemMessage);
        }
        commentContainerRefresh();
    }).fail(function (jqXHR, textStatus, error) {
        let systemError = "Your parameters are invalid!";
        if (systemError !== "") {
            toastr.error(systemError);
        }
    });
}

$(".add-comment").on('click', "[data-action='add_comment']", function (e) {
    e.preventDefault();
    //e.stopPropagation();

    let blog_id = $(this).attr('data-blog-id');
    let name = $('#username').val();
    let email = $('#useremail').val();
    let content = $('#usercomment').val();

    addComment(blog_id, name, email, content);

});

$('#form-add-comments').validate({
    rules: {
        name: {
            required: true,
            rangelength: [2, 50]
        },
        email: {
            required: true,
            email: true,
            maxlength: 255
        },
        content: {
            required: true,
            rangelength: [50, 500]
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