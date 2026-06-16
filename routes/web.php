<?php

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

Route::livewire('topics/create', 'pages::topics.create');
Route::livewire('topics/{topic}/edit', 'pages::topics.edit');
Route::livewire('topics/{topic}/keywords', 'pages::topics.keywords');
Route::livewire('/topics/{topic}',
    'livewire.pages.topic.show');

require __DIR__.'/settings.php';
