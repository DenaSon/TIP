<?php

use Domains\Opportunity\Actions\DetectOpportunityAction;
use Domains\Opportunity\Models\Opportunity;
use Domains\Trend\Models\Trend;
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

    $trend = Trend::first();

    app(
        DetectOpportunityAction::class
    )->execute(
        $trend
    );

    return Opportunity::first();

});

require __DIR__.'/settings.php';
