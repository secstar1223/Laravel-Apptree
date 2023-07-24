<?php

namespace App\Http\Livewire\Pathway;

use App\Models\Course;
use App\Models\Pathway;
use Livewire\Component;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Filament\Tables\Concerns\InteractsWithTable;

class PathwayContents extends Component implements HasTable
{
    use InteractsWithTable;
    use LivewireAlert;

    public Pathway $pathway;
    public $pathway_id;
    
    public function render()
    {
        return view('livewire.pathway.pathway-contents');
    }

    public function mount($id)
    {
        $this->pathway_id = $id;
        $this->pathway = Pathway::findOrFail($id);
    }

    protected function getTableQuery() 
    {
        return Course::query();
    } 

    protected function getTableColumns(): array 
    {
        return [
            TextColumn::make('title')->searchable()->sortable(),
            TextColumn::make('category.name')->searchable()->sortable(),
        ];
    }

    protected function getTableHeading()
    {
        return null;
    }

    protected function getTableBulkActions(): array
    {
        return [
            BulkAction::make('save')
                ->action(function(Collection $records){
                    $ids = $records->pluck('id')->all();
                    $this->pathway->courses()->sync($ids);

                    $this->alert('success', 'Pathway updated successfully!');
                })
        ];
    }
}
