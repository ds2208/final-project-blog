@extends('front._layout.layout')

@section('seo_title', $author->name)
@section('seo_description', __('Welcome to our author page, enjoy with your favorite author!'))
@section('seo_image', $author->getPhotoUrl())

@section('content')
<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="posts-listing col-lg-8"> 
            <div class="container">
                <h2 class="mb-3 author d-flex align-items-center flex-wrap">
                    <div class="avatar"><img src="{{$author->getPhotoUrl()}}" alt="..." class="img-fluid rounded-circle"></div>
                    <div class="title">
                        <span> @lang('Posts by author') "{{$author->name}}"</span>
                    </div>
                </h2>
                @include('front._layout.partials.blogs', ['blogs' => $blogs])
                <!-- Pagination -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination pagination-template d-flex justify-content-center">
                        {{$blogs->links()}}
                    </ul>
                </nav>
            </div>
        </main>
        @include('front._layout.partials.aside')
    </div>
</div>
@endsection