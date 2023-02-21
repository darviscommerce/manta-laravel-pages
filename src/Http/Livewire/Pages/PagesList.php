<?php

namespace Manta\LaravelPages\Http\Livewire\Pages;

use Manta\LaravelPages\Models\MantaPage;
use Manta\LaravelCms\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class PagesList extends Component
{
    use WithPagination;
    use WithSorting;

    protected $paginationTheme = 'bootstrap';

    public $search;
    protected $queryString = ['search'];

    public string $show = 'active';
    public ?int $trashed = null;
    public ?string $deleteId = null;

    public function mount()
    {
        $this->sortBy = 'title';
        $this->sortDirection = 'ASC';
    }

    public function render()
    {
        $obj = MantaPage::where('locale', config('manta-cms.locale'))->orderBy($this->sortBy, $this->sortDirection);
        if($this->show == 'trashed'){
            $obj->onlyTrashed();
        }
        if($this->search){
            $keyword = $this->search;
            $obj->where(function ($query) use($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%')
                   ->orWhere('content', 'like', '%' . $keyword . '%');
              });
        // ->where('name', 'like', '%'.$this->search.'%')->orWhere('email', 'like', '%'.$this->search.'%');
        }
        $items = $obj->paginate(20);
        return view('manta-laravel-pages::livewire.pages.pages-list', ['items' => $items])->layout('manta-laravel-cms::layouts.manta-bootstrap');
    }

    public function loadTrash()
    {
        $this->trashed = count(MantaPage::onlyTrashed()->get());
    }

    public function show($show)
    {
        $this->show = $show;
    }

    public function delete($id)
    {
        $this->deleteId = $id;
    }

    public function deleteCancel()
    {
        $this->deleteId = null;
    }

    public function deleteConfirm()
    {
        MantaPage::find($this->deleteId)->delete();
        $this->deleteId = null;
        $this->trashed = count(MantaPage::onlyTrashed()->get());
    }

    public function restore($id)
    {
        MantaPage::withTrashed()->where('id', $id)->restore();
        $this->trashed = count(MantaPage::onlyTrashed()->get());
        $this->show = 'active';
    }
}
