<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pathway extends Model
{
    use HasFactory;
    use HasTags;

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function goals()
    {
        //return $this->belongsTo(Goal::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'pathway_courses');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'assignments');
    }

    public function assignments(): MorphMany
    {
        return $this->morphMany(Assignment::class, 'assignmentable');
    }
}
