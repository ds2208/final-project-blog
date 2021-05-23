<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Blog;
use Illuminate\Support\Carbon;

class ViewServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

        View::composer(
                [
                    'front.blogs.index',
                    'front.blogs.single',
                    'front.categories.index',
                    'front.authors.index',
                    'front.tags.index',
                    'front.search.index'
                ],
                function ($view) {
                    $view->with('categories', Category::query()
                                    ->orderBy('priority', 'ASC')
                                    ->withCount('blogs')
                                    ->get()
                    );
                });

        View::composer(
                [
                    'front.blogs.index',
                    'front.blogs.single',
                    'front.categories.index',
                    'front.authors.index',
                    'front.tags.index',
                    'front.search.index'
                ],
                function ($view) {
                    $view->with('tags', Tag::query()
                                    ->orderBy('blogs_count', 'DESC')
                                    ->withCount('blogs')
                                    ->get()
                    );
                });

        View::composer(
                [
                    'front.blogs.index',
                    'front.blogs.single',
                    'front.categories.index',
                    'front.authors.index',
                    'front.tags.index',
                    'front.search.index',
                    'front.contact.index'
                ],
                function ($view) {
                    $view->with('latestBlogs', Blog::query()
                                    ->where('status', '=', 1)
                                    ->whereBetween('created_at',
                                            [
                                                Carbon::now()->startOfMonth()->subMonth(2),
                                                Carbon::now()->startOfMonth()
                                    ])
                                    ->orderBy('views', "DESC")
                                    ->withCount('comments')
                                    ->limit(3)
                                    ->get()
                    );
                });

        View::composer(
                [
                    'front.blogs.index',
                    'front.blogs.single',
                    'front.categories.index',
                    'front.authors.index',
                    'front.tags.index',
                    'front.search.index',
                    'front.index.index',
                    'front.contact.index'
                ],
                function ($view) {
                    $view->with('footerBlogs', Blog::query()
                                    ->where('status', '=', 1)
                                    ->orderBy('created_at', 'DESC')
                                    ->limit(3)
                                    ->get()
                    );
                });

        View::composer(
                [
                    'front.blogs.index',
                    'front.blogs.single',
                    'front.categories.index',
                    'front.authors.index',
                    'front.tags.index',
                    'front.search.index',
                    'front.index.index',
                    'front.contact.index'
                ],
                function ($view) {
                    $view->with('footerCategories', Category::query()
                                    ->orderBy('priority')
                                    ->limit(4)
                                    ->get()
                    );
                });
    }

}
