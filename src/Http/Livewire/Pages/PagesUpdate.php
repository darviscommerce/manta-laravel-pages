<?php

namespace Manta\LaravelPages\Http\Livewire\Pages;

use Manta\LaravelPages\Models\MantaPage;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Str;

class PagesUpdate extends Component
{
    public MantaPage $item;

    public ?string $added_by = null;
    public ?string $changed_by = null;
    public ?string $company_id = '1';
    public ?string $host = null;
    public ?string $locale = null;
    public ?string $title = null;
    public ?string $slug = null;
    public ?string $seo_title = null;
    public ?string $seo_description = null;
    public ?string $excerpt = null;
    public ?string $content = null;

    public function mount(Request $request, $input)
    {
        $item = MantaPage::find($input);
        if($request->input('locale')){
            $item = MantaPage::where('locale', $request->input('locale'))->where('pid', $input)->first();
            if($item == null){
                return redirect()->to(route('manta.pages.create', ['locale' => $request->input('locale'), 'pid' => $input]));
            }
        }
        if ($item == null) {
            return redirect()->to(route('manta.pages.list'));
        }
        $this->item = $item;
        $this->added_by = $item->added_by;
        $this->changed_by = $item->changed_by;
        $this->company_id = $item->company_id;
        $this->host = $item->host;
        $this->locale = $item->locale;
        $this->title = $item->title;
        $this->slug = $item->slug;
        $this->seo_title = $item->seo_title;
        $this->seo_description = $item->seo_description;
        $this->excerpt = $item->excerpt;
        $this->content = $item->content;
    }

    public function render()
    {
        return view('manta-laravel-pages::livewire.pages.pages-update')->layout('manta-laravel-cms::layouts.manta-bootstrap');
    }

    public function store($input)
    {
        $this->validate(
            [
                'title' => 'required|min:1',
                'slug' => 'required|min:1',
            ],
            [
                'title.required' => 'Titel is verplicht',
                'slug.required' => 'Slug is verplicht',
            ]
        );

        $items = [
            'added_by' => auth()->user()->name,
            'locale' => $this->locale,
            'title' => $this->title,
            'slug' => Str::of($this->slug)->slug('-'),
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'excerpt' => $this->excerpt,
            'content' => $this->content
        ];
        MantaPage::where('id', $this->item->id)->update($items);

        toastr()->addInfo('Item opgeslagen');
    }
}
