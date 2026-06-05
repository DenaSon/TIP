<?php

use App\Jobs\CalculateTrendJob;
use Domains\Topic\Models\Topic;
use Domains\Trend\Actions\CalculateTrendAction;
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

Route::get('test', function () {

    CalculateTrendJob::dispatch(
        Topic::first()
    );

});

require __DIR__.'/settings.php';
