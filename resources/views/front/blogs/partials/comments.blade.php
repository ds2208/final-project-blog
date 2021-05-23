<div class="post-comments" id="post-comments">
    <header>
        <h3 class="h6">@lang("Post Comments")<span class="no-of-comments">({{$comments->count()}})</span></h3>
    </header>
    @foreach($comments as $comment)
    <div class="comment">
        <div class="comment-header d-flex justify-content-between">
            <div class="user d-flex align-items-center">
                <div class="image"><img src="{{url('/themes/front/img/user.svg')}}" alt="..." class="img-fluid rounded-circle"></div>
                <div class="title"><strong>{{$comment->name}}</strong><span class="date">{{$comment->datePresenter()}}</span></div>
            </div>
        </div>
        <div class="comment-body">
            <p>{{$comment->content}}</p>
        </div>
    </div>
    @endforeach
</div>
