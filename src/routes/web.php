<?php

use App\Http\Livewire\Pages\PagesCreate;
use App\Http\Livewire\Pages\PagesList;
use App\Http\Livewire\Pages\PagesUpdate;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Pages\PagesUploads;

Route::get('/pagina', PagesList::class)->name('manta.pages.list');
Route::get('/pagina/toevoegen', PagesCreate::class)->name('manta.pages.create');
Route::get('/pagina/aanpassen/{input}', PagesUpdate::class)->name('manta.pages.update');
Route::get('/pagina/uploads/{input}', PagesUploads::class)->name('manta.pages.uploads');
