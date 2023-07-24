<?php

namespace App\Models;

use Storage;
use App\Enums\ModuleItemType;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModuleItem extends Model implements Sortable
{
    use SortableTrait;
    use HasFactory;

    protected $casts = [
        'type' => ModuleItemType::class,
        'video_response' => 'array'
    ];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected $guarded = [];

    protected $appends = [ 'image_url' ]; 

    public function getImage()
    {
        if($this->image){
            return Storage::disk('do')->url($this->image);
        }
        return '';
    }

    public function getImageUrlAttribute()
    {
        return $this->getImage();
    }

    public function question()
    {
        return $this->hasOne(Question::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_module_activity')->withPivot('completed_at');
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
