<div class="row">
    @foreach($blogs as $blog)
    <!-- post -->
    <div class="post col-xl-6">
        <div class="post-thumbnail"><a href="{{$blog->getFrontUrl()}}"><img src="{{$blog->getPhotoUrl()}}" alt="..." class="img-fluid"></a></div>
        <div class="post-details">
            <div class="post-meta d-flex justify-content-between">
                <div class="date meta-last">{{$blog->datePresenter()}}</div>
                @if($blog->haveCategory())
                <div class="category"><a href="{{$blog->category->getFrontUrl()}}">{{$blog->category->name}}</a></div>
                @else
                <div class="category"><a>{{__('Uncategorized')}}</a></div>
                @endif
            </div><a href="{{$blog->getFrontUrl()}}">
                <h3 class="h4">{{$blog->title}}</h3></a>
            <p class="text-muted">{{$blog->description}}</p>
            <footer class="post-footer d-flex align-items-center"><a href="{{$blog->author->getFrontUrl()}}" class="author d-flex align-items-center flex-wrap">
                    <div class="avatar"><img src="{{$blog->author->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                    <div class="title"><span>{{$blog->author->name}}</span></div></a>
                <div class="date"><i class="icon-clock"></i>{{$blog->dateInAgoFormat()}}</div>
                <div class="comments meta-last"><i class="icon-comment"></i>{{$blog->comments_count}}</div>
            </footer>
        </div>
    </div>
    @endforeach
</div>