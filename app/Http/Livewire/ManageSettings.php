<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Settings;
use App\Models\CourseCategory;
use Livewire\TemporaryUploadedFile;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\CheckboxList;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Filament\Forms\Concerns\InteractsWithForms;
use File;

class ManageSettings extends Component implements HasForms
{
    use InteractsWithForms;
    use LivewireAlert;

    public $image;

    public $full_access;

    public function render()
    {
        return view('livewire.manage-settings', ['settings' => Settings::get()]);
    }

    public function mount()
    {
        $this->logoForm->fill([
            'image' => settings('logo')
        ]);
    }

    protected function getLogoFormSchema(): array
    {
        return [
            FileUpload::make('image')
                ->required()
                ->directory('settings')
                ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                    return (string) str($file->getClientOriginalName())->prepend('logo-');
                }),
        ];
    }

    protected function getLibraryFormSchema(): array
    {
        return [
            CheckboxList::make('courses')
                ->options(function(){
                    return CourseCategory::get()->pluck('name', 'id');
                })
                ->columns(3)
        ];
    }

    public function getPermissionFormSchema()
    {
        return [
            Toggle::make('full_access')
                ->label('Allow users full access to the available library (will be shown on the bottom of the page)')
                ->inline()
                ->columnSpan('full')
        ];
    }

    protected function getForms(): array
    {
        return [
            'logoForm' => $this->makeForm()
                ->schema($this->getLogoFormSchema()),
            'libraryForm' => $this->makeForm()
                ->schema($this->getLibraryFormSchema()),
            'permissionForm' => $this->makeForm()
                ->schema($this->getPermissionFormSchema()),
        ];
    }


    // note: function exists
    // view is not used anymore...
    public function updateLogo()
    {
        $data = $this->logoForm->getState();

        update_settings('logo', $data['image']);

        $this->alert('success', 'Logo has been updated successfully!');

        return redirect('/settings');
    }


}
