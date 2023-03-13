<?php

use Manta\LaravelPages\Http\Livewire\Pages\PagesCreate;
use Manta\LaravelPages\Http\Livewire\Pages\PagesList;
use Manta\LaravelPages\Http\Livewire\Pages\PagesUpdate;
use Illuminate\Support\Facades\Route;
use Manta\LaravelPages\Http\Livewire\Pages\PagesUploads;

Route::get('/pagina', PagesList::class)->name('manta.pages.list');
Route::get('/pagina/toevoegen', PagesCreate::class)->name('manta.pages.create');
Route::get('/pagina/aanpassen/{input}', PagesUpdate::class)->name('manta.pages.update');
Route::get('/pagina/uploads/{input}', PagesUploads::class)->name('manta.pages.uploads');
