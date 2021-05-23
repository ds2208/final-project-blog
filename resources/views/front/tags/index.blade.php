@extends('front._layout.layout')

@section('seo_title', $tag->name)
@section('seo_description', __('Welcome to our tags page, enjoy in your favorite tag!'))

@section('content')
<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="posts-listing col-lg-8"> 
            <div class="container">
                <h2 class="mb-3">Tag "{{$tag->name}}"</h2>
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