<?php

namespace App\Http\Livewire\Courses;

use Str;
use App\Models\Tag;
use App\Models\User;
use App\Models\Course;
use App\Models\Tenant;
use Livewire\Component;
use App\Enums\CourseStatus;
use App\Models\CourseCategory;
use App\Models\CourseSubcategory;
use Filament\Forms\Components\Grid;
use App\Forms\Components\SelectIcon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
use App\Forms\Components\SimpleFieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class EditCourse extends Component implements HasForms
{
    use InteractsWithForms;

    public Course $course;
    public $course_id;

    public function render()
    {
        return view('livewire.courses.edit-course');
    }

    public function mount($id)
    {
        $this->course = Course::findOrFail($id);
        $this->course_id = $id;

        $this->form->fill($this->course->toArray());
        $this->subcategories = $this->course->subcategories->pluck('id');
        $this->instructors = $this->course->instructors->pluck('id');
        $this->tags = $this->course->tags->pluck('id');
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make([
                'default' => 1,
                'sm' => 1,
                'lg' => 5,
            ])
                ->schema([
                    SimpleFieldset::make('Form')
                        ->schema([
                            Grid::make(['default' => 1, 'lg' => 6])
                            ->schema([
                            TextInput::make('title')
                                ->label('Course Title')
                                ->placeholder('Enter your course title')
                                ->columnSpan(['default' => 6, 'sm' => 5, 'md' => 5])
                                ->required(),
                            SelectIcon::make('icon')
                                ->label('Select Icon')
                                ->required()
                                ->columnSpan(['lg' => 1, 'xl' => 1, 'default' => 2]),
                            Select::make('category_id')
                                ->label('General Category')
                                ->options(function(){
                                    return CourseCategory::get()->pluck('name', 'id');
                                })
                                ->required()
                                ->preload()
                                ->searchable()
                                ->columnSpan(['default' => 6, 'md' => 3]),
                            Select::make('subcategories')
                                ->label('Specific Category')
                                ->columnSpan(['default' => 6, 'md' => 3])
                                ->options(function(){
                                    return CourseSubcategory::where('course_category_id', $this->category_id)->get()->pluck('name', 'id');
                                })
                                ->reactive()
                                ->required()
                                ->preload()
                                ->searchable(),
                            Select::make('instructors')
                                ->multiple()
                                ->searchable()
                                ->preload()
                                ->options(User::get()->pluck('name', 'id'))
                                ->columnSpan(['default' => 6]),
                            Textarea::make('description')
                                ->placeholder('Enter description')
                                ->required()
                                ->columnSpan(['default' => 6]),

                            TimePicker::make('estimated_time')
                                ->placeholder('HH::mm')
                                ->withoutSeconds()
                                ->columnSpan(['default' => 3, 'md' => 2]),
                            Select::make('passing_score')
                                ->label('Passing score')
                                ->preload()
                                ->reactive()
                                ->options(function(){
                                    return $this->getScorePercentages();
                                })
                                ->required()
                                ->default(10)
                                ->columnSpan(['default' => 3, 'md' => 1]),
                            Toggle::make('required_passing_modules')
                                ->label('Require Passing all Modules?')
                                ->inline()
                                ->columnSpan(['default' => 6, 'md' => 3]),
                            ]),
                        ])->columnSpan(3),
                    SimpleFieldset::make('Media')
                        ->columnSpan(2)
                        ->schema([
                            FileUpload::make('image')
                            ->image()
                            ->label('Upload course image')
                            ->columnSpan('full')
                        ]),
                ]),
        ];
    }

    private function getScorePercentages() : array
    {
        $array = [];

        foreach([0, 50, 60, 70, 80, 90, 100] as $val => $pct)
        {
            $array[$pct] = $pct . '%';
        }

        return $array;
    }
}
