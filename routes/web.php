<?php

use Domains\Content\Models\Content;
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



Route::get('test', function () {
});

require __DIR__.'/settings.php';
