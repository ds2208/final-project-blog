@extends('front._layout.layout')

@section('seo_title', $search)
@section('seo_description', __('Welcome to our search page, we hope that, you will find your wish!'))

@section('content')
<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="posts-listing col-lg-8"> 
            <div class="container">
                <h2 class="mb-3">Search results for "{{$search}}"</h2>
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