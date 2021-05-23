@extends('front._layout.layout')

@section('seo_title', __('Blogs'))
@section('seo_description', __('Welcome to our blogs page, enjoy in our blogs!'))

@section('content')
<div class="container">
    <div class="row">
        <!--Posts -->
        <main class="posts-listing col-lg-8">
            <div class="container">
                @include('front._layout.partials.blogs', ['blogs' => $blogs])
                <!-- Pagination -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination pagination-template d-flex justify-content-center col-4">
                        {{$blogs->links()}}
                    </ul>
                </nav>
            </div>
        </main>
        @include('front._layout.partials.aside')
    </div>
</div>
@endsection