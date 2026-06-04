<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::sources.index')->name('source.index');



require __DIR__.'/settings.php';
