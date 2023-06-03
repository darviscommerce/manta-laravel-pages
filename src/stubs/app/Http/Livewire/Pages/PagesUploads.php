<?php

namespace App\Http\Livewire\Pages;

use Manta\LaravelPages\Models\MantaPage;
use Illuminate\Http\Request;
use Livewire\Component;

class PagesUploads extends Component
{
    public MantaPage $item;

    public ?string $locale = null;
    public ?string $plugin = null;

    public function mount(Request $request, $input)
    {
        $item = MantaPage::find($input);
        if ($request->input('locale')) {
            $item = MantaPage::where('locale', $request->input('locale'))->where('pid', $input)->first();
            if ($item == null) {
                return redirect()->to(route('manta.pages.create', ['locale' => $request->input('locale'), 'pid' => $input]));
            }
        }
        if ($item == null) {
            return redirect()->to(route('manta.pages.list'));
        }
        $this->item = $item;
        $this->locale = $item->locale;
        $this->plugin = 'uploads';
    }

    public function render()
    {
        return view('livewire.pages.pages-uploads')->layout('layouts.manta-bootstrap');
    }

    public function store($input)
    {
    }
}
