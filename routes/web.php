<?php

use Illuminate\Support\Facades\Route;

Route::prefix('panel')
    ->as('panel.')
    ->group(function () {});

Route::prefix('core')
    ->as('core.')
    ->group(function () {

        Route::livewire('/dashboard', 'pages::core.dashboard.index')
            ->name('dashboard.index');

        Route::livewire('/sources', 'pages::core.sources.index')
            ->name('sources.index');

        Route::livewire('/contents', 'pages::core.contents.index')
            ->name('contents.index');

        Route::livewire('/contents/{content}', 'pages::core.contents.show')
            ->name('contents.show');

        Route::livewire('/topics', 'pages::core.topics.index')
            ->name('topics.index');

        Route::livewire('/topics/create', 'pages::core.topics.create')
            ->name('topics.create');

        Route::livewire('/topics/{topic}/show', 'pages::core.topics.show')
            ->name('topics.show');

        Route::livewire('/topics/{topic}/edit', 'pages::core.topics.edit')
            ->name('topics.edit');

        Route::livewire('/topics/{topic}/keywords', 'pages::core.topics.keywords')
            ->name('topics.keywords');

        Route::livewire('/clusters', 'pages::core.clusters.index')
            ->name('clusters.index');

        Route::livewire('/trends', 'pages::core.trends.index')
            ->name('trends.index');
    });

Route::prefix('panel')
    ->as('panel.')
    ->group(function () {

        Route::livewire(
            '/opportunities/{topic}',
            'pages::panel.opportunities.show'
        )->name('opportunities.show');

        Route::livewire(
            '/opportunities',
            'pages::panel.opportunities.index'
        )->name('opportunities.index');

        Route::livewire(
            '/trends',
            'pages::panel.trends.index'
        )->name('trends.index');

        Route::livewire(
            '/topics',
            'pages::panel.topics.index'
        )->name('topics.index');

        Route::livewire(
            '/trends',
            'pages::panel.trends.index'
        )->name('trends.index');

    });

require __DIR__.'/settings.php';
