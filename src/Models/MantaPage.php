<?php

namespace Manta\LaravelPages\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class MantaPage extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'manta_pages';
    // Disable Laravel's mass assignment protection
    // protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'created_by',
        'updated_by',
        'deleted_by',
        'company_id',
        'host',
        'pid',
        'locale',
        'title',
        'subtitle',
        'slug',
        'seo_title',
        'seo_description',
        'excerpt',
        'content',
        'homepage',
        'fixed',
        'fullpage',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    public function translation(?string $getLocale = null): array
    {
        $return = ['get', 'org'];
        if ($getLocale == null) $getLocale = app()->getLocale();

        if ($this->pid) {
            $return['org'] = MantaPage::find($this->pid);
        } else {
            $return['org'] = $this;
        }
        $return['get'] = $return['org'];
        if ($getLocale != config('manta-users.locale')) {
            $item = MantaPage::where(['pid' => $return['org']->id, 'locale' => $getLocale])->first();
            if ($item) {
                $return['get'] = $item;
            }
        }
        return $return;
    }
}
