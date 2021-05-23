<aside id="content-maker" class="col-lg-4">
    <!-- Widget [Search Bar Widget]-->
    <div class="widget search">
        <header>
            <h3 class="h6">{{__("Search the blog")}}</h3>
        </header>
        <form action="{{route('front.search.index')}}" method="get">
            <div class="form-group">
                <input 
                    type="search" 
                    placeholder="{{__('What are you looking for?')}}"
                    name="search"
                    value="{{old('search')}}"
                    >
                <button type="submit" class="submit"><i class="icon-search"></i></button>
            </div>
        </form>
    </div>
    <!-- Widget [Latest Posts Widget] -->
    <div class="widget latest-posts">
        <header>
            <h3 class="h6">{{__("Latest Posts")}}</h3>
        </header>
        <div class="blog-posts">
            @foreach($latestBlogs as $singleBlog)
            <a href="{{$singleBlog->getFrontUrl()}}">
                <div class="item d-flex align-items-center">
                    <div class="image"><img src="{{$singleBlog->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                    <div class="title"><strong>{{$singleBlog->title}}</strong>
                        <div class="d-flex align-items-center">
                            <div class="views"><i class="icon-eye"></i>{{$singleBlog->views}}</div>
                            <div class="comments"><i class="icon-comment"></i>{{$singleBlog->comments_count}}</div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <!-- Widget [Categories Widget]-->
        <div class="widget categories">
            <header>
                <h3 class="h6">{{__("Categories")}}</h3>
            </header>
            @foreach($categories as $category)
            <div class="item d-flex justify-content-between">
                <a id="category_{{$category->id}}" href="{{$category->getFrontUrl()}}" class="category-link">
                    {{$category->name}}
                </a>
                <span>{{$category->blogs_count}}</span>
            </div>
            @endforeach
        </div>
        <!-- Widget [Tags Cloud Widget]-->
        <div class="widget tags">       
            <header>
                <h3 class="h6">{{__("Tags")}}</h3>
            </header>
            <ul class="list-inline">
                @foreach($tags as $tag)
                <li class="list-inline-item"><a href="{{$tag->getFrontUrl()}}" class="tag">#{{$tag->name}}</a></li>
                @endforeach
            </ul>
        </div>
</aside>