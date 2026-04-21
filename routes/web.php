<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PlannerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/home', [FeedController::class, 'index'])->name('home');
    Route::get('/explore', [FeedController::class, 'explore'])->name('explore');
    Route::get('/feed/latest', [FeedController::class, 'latest'])->name('feed.latest');

    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/{post}/share', [PostController::class, 'share'])->name('posts.share');
    Route::post('/posts/{post}/bookmark', [PostController::class, 'bookmark'])->name('posts.bookmark');
    Route::post('/posts/{post}/review', [PostController::class, 'review'])->name('posts.review');
    Route::post('/posts/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');
    Route::post('/posts/{post}/report', [PostController::class, 'report'])->name('posts.report');

    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/users/{user}/follow', [ProfileController::class, 'follow'])->name('users.follow');
    Route::post('/users/{user}/unfollow', [ProfileController::class, 'unfollow'])->name('users.unfollow');
    Route::get('/travel-list', [ProfileController::class, 'travelList'])->name('profile.travel-list');
    Route::get('/notifications', [ProfileController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{notification}/read', [ProfileController::class, 'markNotificationRead'])->name('notifications.read');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{user}', [ChatController::class, 'send'])->name('chat.send');

    Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
    Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');

    Route::get('/travel-plans', [PlannerController::class, 'index'])->name('plans.index');
    Route::post('/travel-plans', [PlannerController::class, 'store'])->name('plans.store');
    Route::post('/travel-plans/{plan}/items', [PlannerController::class, 'addItem'])->name('plans.items.store');
    Route::delete('/travel-plans/{plan}', [PlannerController::class, 'destroy'])->name('plans.destroy');
    Route::delete('/travel-plans/items/{item}', [PlannerController::class, 'destroyItem'])->name('plans.items.destroy');

    // Admin routes - protected by admin middleware
    Route::middleware('admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::post('/admin/ban/{user}', [AdminController::class, 'banUser'])->name('admin.ban');
        Route::post('/admin/unban/{user}', [AdminController::class, 'unbanUser'])->name('admin.unban');
        Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');
        Route::post('/admin/posts/{post}/hide', [AdminController::class, 'hidePost'])->name('admin.post.hide');
        Route::post('/admin/posts/{post}/approve', [AdminController::class, 'approvePost'])->name('admin.post.approve');
        Route::post('/admin/posts/{post}/toggle-comments', [AdminController::class, 'togglePostComments'])->name('admin.post.toggle-comments');
        Route::post('/admin/reports/{report}/resolve', [AdminController::class, 'resolveReport'])->name('admin.report.resolve');
        Route::post('/admin/reports/{report}/delete-post', [AdminController::class, 'deleteReportedPost'])->name('admin.report.delete-post');
        Route::post('/admin/reports/{report}/ban-user', [AdminController::class, 'banReportedUser'])->name('admin.report.ban-user');
        Route::delete('/admin/comments/{comment}', [AdminController::class, 'destroyComment'])->name('admin.comment.destroy');
        Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
        Route::delete('/admin/categories/{category}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');
        Route::post('/admin/locations', [AdminController::class, 'storeLocation'])->name('admin.locations.store');
        Route::delete('/admin/locations/{location}', [AdminController::class, 'destroyLocation'])->name('admin.locations.destroy');
        Route::post('/admin/announcements', [AdminController::class, 'storeAnnouncement'])->name('admin.announcements.store');
        Route::delete('/admin/announcements/{announcement}', [AdminController::class, 'destroyAnnouncement'])->name('admin.announcements.destroy');
        Route::post('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    });
});
