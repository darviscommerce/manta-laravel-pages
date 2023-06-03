Route::group(['prefix' => config('manta-cms.prefix'), 'middleware' => config('manta-cms.middleware')], function () {
Route::get('/pagina', App\Http\Livewire\Pages\PagesList::class)->name('manta.pages.list');
Route::get('/pagina/toevoegen', App\Http\Livewire\Pages\PagesCreate::class)->name('manta.pages.create');
Route::get('/pagina/aanpassen/{input}', App\Http\Livewire\Pages\PagesUpdate::class)->name('manta.pages.update');
Route::get('/pagina/uploads/{input}', App\Http\Livewire\Pages\PagesUploads::class)->name('manta.pages.uploads');
});