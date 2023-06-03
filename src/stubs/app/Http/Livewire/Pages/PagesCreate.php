<?php

namespace App\Http\Livewire\Pages;

use Manta\LaravelPages\Models\MantaPage;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Str;
use Google\Cloud\Translate\V2\TranslateClient;

class PagesCreate extends Component
{
    public ?MantaPage $item = null;

    public ?string $created_by = null;
    public ?string $updated_by = null;
    public ?string $company_id = '1';
    public ?string $host = null;
    public ?string $pid = null;
    public ?string $locale = null;
    public ?string $title = null;
    public ?string $subtitle = null;
    public ?string $slug = null;
    public ?string $seo_title = null;
    public ?string $seo_description = null;
    public ?string $tags = null;
    public ?string $excerpt = null;
    public ?string $content = null;
    public int $fixed = 1;
    public int $fullpage = 1;

    public function mount(Request $request)
    {
        $this->host = request()->getHost();
        $this->locale = config('manta-cms.locale');
        if ($request->input('pid') && $request->input('locale')) {
            $this->item = MantaPage::find($request->input('pid'));
            if ($this->item) {
                $this->pid = $request->input('pid');
                $this->locale = $request->input('locale');
                $this->title = $this->item->title;
                $this->subtitle = $this->item->subtitle;
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
            'created_by' => auth()->user()->name,
            'company_id' => (int)$this->company_id,
            'host' => $this->host,
            'pid' => $this->pid,
            'locale' => $this->locale,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'slug' => Str::of($this->slug)->slug('-'),
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'tags' => $this->tags,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'fixed' => (int)$this->fixed,
            'fullpage' => (int)$this->fullpage
        ];
        MantaPage::create($items);

        toastr()->addInfo('Item opgeslagen');

        return redirect()->to(route('manta.pages.list'));
    }

    public function googleTranslateTags($locale)
    {

        $translate = new TranslateClient([
            'key' => env('GOOGLE_API')
        ]);


        $translateArr = [
            'created_by' => auth()->user()->name,
            'company_id' => (int)$this->company_id,
            'host' => $this->host,
            'pid' => $this->pid,
            'locale' => $locale,
            'title' => $this->item->title,
            'subtitle' => $this->item->subtitle,
            'slug' => Str::of($this->item->slug)->slug('-'),
            'seo_title' => $this->item->seo_title,
            'seo_description' => $this->item->seo_description,
            'tags' => $this->item->tags,
            'excerpt' => $this->item->excerpt,
            'content' => $this->item->content,
            'fixed' => (int)$this->item->fixed,
            'fullpage' => (int)$this->item->fullpage
        ];

        $item = [];
        foreach ($translateArr as $key => $value) {
            if (
                $key == 'created_by' ||
                $key == 'company_id' ||
                $key == 'host' ||
                $key == 'pid' ||
                $key == 'locale' ||
                $key == 'fixed' ||
                $key == 'fullpage' ||
                $value == null
            ) {
                $item[$key] = $value;
            } else {
                // $item[$key] = $value;
                $result = $translate->translate((string)$value, [
                    'source' => 'nl',
                    'target' => config('manta-cms.locales')[$locale]['google_code']
                ]);
                $item[$key] = $result['text'];
            }
        }
        if (isset($item['slug'])) {
            $item['slug'] = (string)Str::of($item['slug'])->slug('-');
        }

        MantaPage::create($item);

        toastr()->addInfo('Item opgeslagen');

        return redirect()->to(route('manta.pages.update', ['locale' => $locale, 'input' => $this->item->id]));
    }
}
