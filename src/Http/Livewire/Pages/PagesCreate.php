<?php

namespace App\Http\Livewire\Pages;

use Manta\LaravelPages\Models\MantaPage;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Str;

class PagesCreate extends Component
{
    public ?MantaPage $item = null;

    public ?string $added_by = null;
    public ?string $changed_by = null;
    public ?string $company_id = '1';
    public ?string $host = null;
    public ?string $pid = null;
    public ?string $locale = null;
    public ?string $title = null;
    public ?string $slug = null;
    public ?string $seo_title = null;
    public ?string $seo_description = null;
    public ?string $excerpt = null;
    public ?string $content = null;
    public int $fixed = 1;
    public int $fullpage = 1;

    public function mount(Request $request)
    {
        $this->host = request()->getHost();
        $this->locale = config('manta-cms.locale');
        if($request->input('pid') && $request->input('locale')){
            $this->item = MantaPage::find($request->input('pid'));
            if($this->item){
                $this->pid = $request->input('pid');
                $this->locale = $request->input('locale');
                $this->title = $this->item->title;
                $this->fixed = $this->item->fixed;
                $this->fullpage = $this->item->fullpage;
            }
        }
    }

    public function render()
    {
        return view('livewire.pages.pages-create')->layout('layouts.manta-bootstrap');
    }

    public function updatedTitle()
    {
        $this->slug = Str::of($this->title)->slug('-');
        $this->seo_title = $this->title;
    }

    public function updatedSlug()
    {
        $this->slug = Str::of($this->slug)->slug('-');
    }

    public function store($input)
    {
        $this->validate(
            [
                'title' => 'required|min:1',
            ],
            [
                'title.required' => 'Titel is verplicht',
            ]
        );

        $items = [
            'added_by' => auth()->user()->name,
            'company_id' => (int)$this->company_id,
            'host' => $this->host,
            'pid' => $this->pid,
            'locale' => $this->locale,
            'title' => $this->title,
            'slug' => Str::of($this->slug)->slug('-'),
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'fixed' => (int)$this->fixed,
            'fullpage' => (int)$this->fullpage
        ];
        MantaPage::create($items);

        toastr()->addInfo('Item opgeslagen');

        return redirect()->to(route('manta.pages.list'));
    }
}
