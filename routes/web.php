<?php

use App\Domains\Topic\Repositories\TopicKeywordRepository;
use Illuminate\Support\Facades\Route;

Route::livewire('/sources', 'pages::sources.index')
    ->name('sources.index');

Route::livewire(
    '/contents',
    'pages::contents.index'
)->name('contents.index');

Route::livewire(
    '/topics',
    'pages::topics.index'
)->name('topics.index');

Route::livewire(
    '/trends',
    'pages::trends.index'
)->name('trends.index');

Route::livewire(
    '/dashboard',
    'pages::dashboard.index'
)->name('dashboard.index');
Route::livewire(
    '/clusters',
    'pages::clusters.index'
)->name('clusters.index');

Route::get('test', function () {

    $repo = app(
        TopicKeywordRepository::class
    );

    return $repo->all()->count();

});

require __DIR__.'/settings.php';
