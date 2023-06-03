<?php

namespace App\Http\Livewire\Pages;

use Manta\LaravelPages\Models\MantaPage;
use Livewire\Component;



class PagesRead extends Component
{

    public MantaPage $item;

    public function mount($input)
    {
        $item = MantaPage::where('slug', $input)->first();
        if (!$item) {
            return abort(404);
        }
        $this->item = $item;
    }

    public function render()
    {
        return view('livewire.pages.pages-read')->layout('layouts.otterlo');
    }
}
