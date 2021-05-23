@extends('front._layout.layout')

@section('seo_title', $category->name)
@section('seo_description', $category->description)

@section('content')
<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="posts-listing col-lg-8"> 
            <div class="container">
                <h2 class="mb-3">@lang('Category') "{{$category->name}}"</h2>
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