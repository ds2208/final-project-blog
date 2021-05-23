<?php

use Illuminate\Support\Facades\Route;
//FRONT
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\SearchController;
//ADMIN
use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\TagsController as AdminTagsController;
use App\Http\Controllers\Admin\CategoriesController as AdminCategoriesController;
use App\Http\Controllers\Admin\AdsController as AdminAdsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\BlogsController as AdminBlogsController;
use App\Http\Controllers\Admin\CommentsController;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */


//FRONT
Route::get('/', [IndexController::class, 'index'])->name('front.index.index');

Route::prefix('/contac-us')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('front.contact.index');
    Route::post('/send-message', [ContactController::class, 'sendMessage'])->name('front.contact.send_message');
});

Route::prefix('/blogs')->group(function () {
    Route::get('/', [BlogsController::class, 'index'])->name('front.blogs.index');
    Route::get('/{blog}/{seoSlug}', [BlogsController::class, 'singleBlog'])->name('front.blogs.single');
    Route::post('/comment-container', [BlogsController::class, 'commentContainer'])->name('front.blogs.partials.comments');
    Route::post('/add-comment', [BlogsController::class, 'addComment'])->name('front.blogs.add_comment');
});

Route::prefix('/categories')->group(function () {
    Route::get('/{category}/{seoSlug}', [CategoriesController::class, 'index'])->name('front.categories.index');
});

Route::prefix('/authors')->group(function () {
    Route::get('/{author}/{seoSlug}', [AuthorsController::class, 'index'])->name('front.authors.index');
});

Route::prefix('/tags')->group(function () {
    Route::get('/{tag}/{seoSlug}', [TagsController::class, 'index'])->name('front.tags.index');
});

Route::prefix('/search')->group(function () {
    Route::get('/', [SearchController::class, 'index'])->name('front.search.index');
});

//AUTH
Auth::routes();

//ADMIN
Route::middleware('auth')->prefix('/admin')->group(function () {
    Route::get('/', [AdminIndexController::class, 'index'])->name('admin.index.index');

    Route::prefix('/tags')->group(function () {
        Route::get('/', [AdminTagsController::class, 'index'])->name('admin.tags.index');
        Route::get('/add', [AdminTagsController::class, 'add'])->name('admin.tags.add');
        Route::post('/insert', [AdminTagsController::class, 'insert'])->name('admin.tags.insert');
        Route::get('/edit/{tag}', [AdminTagsController::class, 'edit'])->name('admin.tags.edit');
        Route::post('/update/{tag}', [AdminTagsController::class, 'update'])->name('admin.tags.update');
        Route::post('/delete/', [AdminTagsController::class, 'delete'])->name('admin.tags.delete');
    });

    Route::prefix('/categories')->group(function () {
        Route::get('/', [AdminCategoriesController::class, 'index'])->name('admin.categories.index');
        Route::get('/add', [AdminCategoriesController::class, 'add'])->name('admin.categories.add');
        Route::post('/insert', [AdminCategoriesController::class, 'insert'])->name('admin.categories.insert');
        Route::get('/edit/{category}', [AdminCategoriesController::class, 'edit'])->name('admin.categories.edit');
        Route::post('/update/{category}', [AdminCategoriesController::class, 'update'])->name('admin.categories.update');
        Route::post('/delete', [AdminCategoriesController::class, 'delete'])->name('admin.categories.delete');
        Route::post('/change-priorities', [AdminCategoriesController::class, 'changePriorities'])->name('admin.categories.change_priorities');
    });

    Route::prefix('/ads')->group(function () {
        Route::get('/', [AdminAdsController::class, 'index'])->name('admin.ads.index');
        Route::get('/add', [AdminAdsController::class, 'add'])->name('admin.ads.add');
        Route::post('/insert', [AdminAdsController::class, 'insert'])->name('admin.ads.insert');
        Route::get('/edit/{ad}', [AdminAdsController::class, 'edit'])->name('admin.ads.edit');
        Route::post('/update/{ad}', [AdminAdsController::class, 'update'])->name('admin.ads.update');
        Route::post('/delete', [AdminAdsController::class, 'delete'])->name('admin.ads.delete');
        Route::post('/change-priorities', [AdminAdsController::class, 'changePriorities'])->name('admin.ads.change_priorities');
        Route::post('/change-index', [AdminAdsController::class, 'changeIndex'])->name('admin.ads.change_index');
        Route::post('/delete-photo/{ad}', [AdminAdsController::class, 'deletePhoto'])->name('admin.ads.delete_photo');
    });

    Route::prefix('/users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('admin.users.index');
        Route::get('/add', [UsersController::class, 'add'])->name('admin.users.add');
        Route::post('/insert', [UsersController::class, 'insert'])->name('admin.users.insert');
        Route::get('/edit/{user}', [UsersController::class, 'edit'])->name('admin.users.edit');
        Route::post('/update/{user}', [UsersController::class, 'update'])->name('admin.users.update');
        Route::post('/disable', [UsersController::class, 'disable'])->name('admin.users.disable');
        Route::post('/enable', [UsersController::class, 'enable'])->name('admin.users.enable');
        Route::post('/delete-photo/{user}', [UsersController::class, 'deletePhoto'])->name('admin.users.delete_photo');
        Route::post('/datatable', [UsersController::class, 'datatable'])->name('admin.users.datatable');
    });

    Route::prefix('/profile')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::post('/update', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('admin.profile.change_password');
        Route::post('/change-password', [ProfileController::class, 'changePasswordConfirm'])->name('admin.profile.change_password_confirm');
        Route::post('/delete-photo', [ProfileController::class, 'deletePhoto'])->name('admin.profile.delete_photo');
    });

    Route::prefix('/blogs')->group(function () {
        Route::get('/', [AdminBlogsController::class, 'index'])->name('admin.blogs.index');
        Route::get('/add', [AdminBlogsController::class, 'add'])->name('admin.blogs.add');
        Route::post('/insert', [AdminBlogsController::class, 'insert'])->name('admin.blogs.insert');
        Route::get('/edit/{blog}', [AdminBlogsController::class, 'edit'])->name('admin.blogs.edit');
        Route::post('/update/{blog}', [AdminBlogsController::class, 'update'])->name('admin.blogs.update');
        Route::post('/delete', [AdminBlogsController::class, 'delete'])->name('admin.blogs.delete');
        Route::post('/disable', [AdminBlogsController::class, 'disable'])->name('admin.blogs.disable');
        Route::post('/enable', [AdminBlogsController::class, 'enable'])->name('admin.blogs.enable');
        Route::post('/get-important', [AdminBlogsController::class, 'getImportant'])->name('admin.blogs.get_important');
        Route::post('/get-not-important', [AdminBlogsController::class, 'getNotImportant'])->name('admin.blogs.get_not_important');
        Route::post('/delete-photo/{blog}', [AdminBlogsController::class, 'deletePhoto'])->name('admin.blogs.delete_photo');
        Route::post('/datatable', [AdminBlogsController::class, 'datatable'])->name('admin.blogs.datatable');
    });

    Route::prefix('/comments')->group(function () {
        Route::get('/', [CommentsController::class, 'index'])->name('admin.comments.index');
        Route::post('/datatable', [CommentsController::class, 'datatable'])->name('admin.comments.datatable');
        Route::post('/disable', [CommentsController::class, 'disable'])->name('admin.comments.disable');
        Route::post('/enable', [CommentsController::class, 'enable'])->name('admin.comments.enable');
    });
});
