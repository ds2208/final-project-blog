@extends('front._layout.layout')

@section('seo_title', 'Home')
@section('seo_description', __('Welcome to our home page, enjoy in our posts!'))

@section('content')
<!-- Hero Section-->
<div id="index-slider" class="owl-carousel">
    @foreach($ads as $ad)
    <section style="background: url({{$ad->getPhotoUrl()}}); background-size: cover; background-position: center center" class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <h1>{{$ad->title}}</h1>
                    <a href="{{$ad->url}}" class="hero-link" target="_blank">{{$ad->button_title}}</a>
                </div>
            </div>
        </div>
    </section>
    @endforeach
</div>

<!-- Intro Section-->
<section class="intro">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h2 class="h3">Some great intro here</h2>
                <p class="text-big">Place a nice <strong>introduction</strong> here <strong>to catch reader's attention</strong>.</p>
            </div>
        </div>
    </div>
</section>
<section class="featured-posts no-padding-top">
    <div class="container">
        <!-- Post-->
        @foreach($blogs as $key => $blog)
        <div class="row d-flex align-items-stretch">
            @if($key % 2 == 1)
            <div class="image col-lg-5"><img src="{{$blog->getPhotoUrl()}}" alt="..."></div>
            @endif
            <div class="text col-lg-7">
                <div class="text-inner d-flex align-items-center">
                    <div class="content">
                        <header class="post-header">
                            @if(isset($blog->category))
                            <div class="category"><a href="{{optional($blog->category)->getFrontUrl()}}">{{optional($blog->category)->name}}</a></div>
                            @else
                            <div class="category"><a>{{__("Uncategorized")}}</a></div>
                            @endif
                            <a href="{{$blog->getFrontUrl()}}">
                                <h2 class="h4">{{$blog->title}}</h2></a>
                        </header>
                        <p>{{$blog->description}}</p>
                        <footer class="post-footer d-flex align-items-center"><a href="{{$blog->author->getFrontUrl()}}" class="author d-flex align-items-center flex-wrap">
                                <div class="avatar"><img src="{{$blog->author->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                                <div class="title"><span>{{$blog->author->name}}</span></div></a>
                            <div class="date"><i class="icon-clock"></i>{{$blog->dateInAgoFormat()}}</div>
                            <div class="comments"><i class="icon-comment"></i>{{$blog->comments_count}}</div>
                        </footer>
                    </div>
                </div>
            </div>
            @if($key % 2 == 0)
            <div class="image col-lg-5"><img src="{{$blog->getPhotoUrl()}}" alt="..."></div>
            @endif
        </div>
        @endforeach
    </div>
</section>
<!-- Divider Section-->
<section style="background: url(/themes/front/img/divider-bg.jpg); background-size: cover; background-position: center bottom" class="divider">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h2>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</h2>
                <a href="{{route('front.contact.index')}}" class="hero-link">Contact Us</a>
            </div>
        </div>
    </div>
</section>
<!-- Latest Posts -->
<section class="latest-posts"> 
    <div class="container">
        <header> 
            <h2>Latest from the blog</h2>
            <p class="text-big">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        </header>
        <div class="owl-carousel" id="latest-posts-slider">
            @foreach($latestBlogs as $treeBlogs)
            <div class="row">
                @foreach($treeBlogs as $singleBlog)
                <div class="post col-md-4">
                    <div class="post-thumbnail"><a href="{{$singleBlog->getFrontUrl()}}"><img src="{{$singleBlog->getPhotoUrl()}}" alt="..." class="img-fluid"></a></div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="date">{{$singleBlog->datePresenter()}}</div>
                            @if(isset($blog->category))
                            <div class="category"><a href="{{optional($singleBlog->category)->getFrontUrl()}}">{{optional($singleBlog->category)->name}}</a></div>
                            @else
                            <div class="category"><a>{{__("Uncategorized")}}</a></div>
                            @endif
                        </div><a href="{{$singleBlog->getFrontUrl()}}">
                            <h3 class="h4">{{$singleBlog->title}}</h3></a>
                        <p class="text-muted">{{$singleBlog->description}}</p>
                    </div>
                </div>
                @endforeach
            </div>           
            @endforeach
        </div>
    </div>
</section>
<!-- Gallery Section-->
<section class="gallery no-padding">    
    <div class="row">
        <div class="mix col-lg-3 col-md-3 col-sm-6">
            <div class="item">
                <a href="{{url('/themes/front/img/gallery-1.jpg')}}" data-fancybox="gallery" class="image">
                    <img src="{{url('/themes/front/img/gallery-1.jpg')}}" alt="gallery image alt 1" class="img-fluid" title="gallery image title 1">
                    <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div>
                </a>
            </div>
        </div>
        <div class="mix col-lg-3 col-md-3 col-sm-6">
            <div class="item">
                <a href="{{url('/themes/front/img/gallery-2.jpg')}}" data-fancybox="gallery" class="image">
                    <img src="{{url('/themes/front/img/gallery-2.jpg')}}" alt="gallery image alt 2" class="img-fluid" title="gallery image title 2">
                    <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div>
                </a>
            </div>
        </div>
        <div class="mix col-lg-3 col-md-3 col-sm-6">
            <div class="item">
                <a href="{{url('/themes/front/img/gallery-3.jpg')}}" data-fancybox="gallery" class="image">
                    <img src="{{url('/themes/front/img/gallery-3.jpg')}}" alt="gallery image alt 3" class="img-fluid" title="gallery image title 3">
                    <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div>
                </a>
            </div>
        </div>
        <div class="mix col-lg-3 col-md-3 col-sm-6">
            <div class="item">
                <a href="{{url('/themes/front/img/gallery-4.jpg')}}" data-fancybox="gallery" class="image">
                    <img src="{{url('/themes/front/img/gallery-4.jpg')}}" alt="gallery image alt 4" class="img-fluid" title="gallery image title 4">
                    <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div>
                </a>
            </div>
        </div>

    </div>
</section>
@endsection

@push('links')
<!-- owl carousel 2 stylesheet-->
<link rel="stylesheet" href="{{url('/themes/front/plugins/owl-carousel2/assets/owl.carousel.min.css')}}" id="theme-stylesheet">
<link rel="stylesheet" href="{{url('/themes/front/plugins/owl-carousel2/assets/owl.theme.default.min.css')}}" id="theme-stylesheet">
@endpush

@push('scripts')
<script src="{{url('/themes/front/plugins/owl-carousel2/owl.carousel.min.js')}}" type="text/javascript"></script>
<script>
$("#index-slider").owlCarousel({
    "items": 1,
    "loop": true,
    "autoplay": true,
    "autoplayHoverPause": true
});

$("#latest-posts-slider").owlCarousel({
    "items": 1,
    "loop": true,
    "autoplay": true,
    "autoplayHoverPause": true
});
</script>
@endpush