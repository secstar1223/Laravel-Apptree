<?php

namespace App\Http\Livewire\Courses;

use Auth;
use App\Models\Course;
use Livewire\Component;
use App\Enums\CourseStatus;
use App\Models\CourseCategory;

class ManageCourses extends Component
{
    public $filter = '', $counts = [];

    public $categories = [];
    
    public $courses = [];

    public $category_id;

    protected $queryString = ['filter'];

    public function render()
    {
        return view('livewire.courses.manage-courses');
    }

    public function mount()
    {
        $this->getCourses();
        
        $this->categories = CourseCategory::get();

        $this->counts['total'] = Course::count();
        $this->counts['published'] = Course::where('status', CourseStatus::Published)->count();
        $this->counts['draft'] = Course::where('status', CourseStatus::Draft)->count();
        $this->counts['deleted'] = Course::withTrashed()->whereNotNull('deleted_at')->count();
    }

    public function getCourses()
    {
        if($this->filter == 'published'){
            $query = Course::where('status', CourseStatus::Published)->latest();
        }
        elseif($this->filter == 'draft'){
            $query = Course::where('status', CourseStatus::Draft)->latest();
        }
        elseif($this->filter == 'deleted'){
            $query = Course::withTrashed()->whereNotNull('deleted_at')->latest();
        }
        else{
            $query = Course::latest();
        }

        if($this->category_id)
        {
            $query = $query->where('category_id', $this->category_id);
        }

        $this->courses = $query->get();

    }

    public function updatedCategoryId()
    {
        $this->getCourses();
    }
}
