<?php

namespace App\Http\Livewire\Courses;

use Str;
use Auth;
use App\Models\Course;
use App\Models\Module;
use Livewire\Component;
use App\Models\Enrollment;
use App\Models\EnrollmentModule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ShowCourse extends Component
{
    use LivewireAlert;
    
    public $course;
    public $enrollment_record;
    public $modules = [];
    
    public function render()
    {
        return view('livewire.courses.show-course');
    }

    public function mount($id)
    {
        $this->course = Course::findOrFail($id);

        $this->enrollment_record = Enrollment::whereUserId(Auth::id())->whereCourseId($id)->first();

        $this->getModules();
    }

    public function getModules()
    {
        $course_modules = Module::withCount('items')->where('course_id', $this->course->id)->ordered()->get()->toArray();
        $modules = [];
        
        foreach($course_modules as $moduleItem)
        { 
            $moduleItem['completed_count'] = 0;

            if($this->enrollment_record)
            {
                $enrollmentModule = EnrollmentModule::where('enrollment_id', $this->enrollment_record->id)->where('module_id', $moduleItem['id'])->first();

                if($enrollmentModule){
                    $moduleItem['completed_count'] = $enrollmentModule->items()->count();
                }
            }

            $modules[] = $moduleItem;
        }

        $this->modules = $modules;
    }

    public function start()
    {

        if(!$this->course->modules()->count()){
            return $this->alert('error', 'This course has no modules');
        }

        if($this->enrollment_record){
            $enroll = $this->enrollment_record;
        }else{
            $enroll = new Enrollment;
            $enroll->user_id = Auth::id();
            $enroll->course_id = $this->course->id;
            $enroll->save();
        }
        

        return redirect()->route('courses.play', $enroll->uuid);
    }
}
