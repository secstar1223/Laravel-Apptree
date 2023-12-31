<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    use HasTags;
    use SoftDeletes;

    protected $guarded = [];

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function firstModule()
    {
        return $this->modules()->first();
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class);
    }

    public function subcategories()
    {
        return $this->belongsToMany(CourseSubcategory::class, 'course_subcategory');

        return tenancy()->central(function(){

        });
    }

    public function instructors()
    {
        return $this->belongsToMany(User::class, 'course_instructors');
    }

    public function pathways()
    {
        return $this->belongsToMany(Pathway::class, 'pathway_courses', 'course_id', 'pathway_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_courses')->withTimestamps()->withPivot('completed_at');
    }

    public function getImage()
    {
        if ($this->image) {
            return Storage::disk('do')->url($this->image);
        }

        return asset('img/hero.jpg');
    }

    public function assignments(): MorphMany
    {
        return $this->morphMany(Assignment::class, 'assignmentable');
    }
}
