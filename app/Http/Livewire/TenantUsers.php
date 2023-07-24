<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Concerns\InteractsWithTable;

class TenantUsers extends Component implements HasTable
{
    use InteractsWithTable;

    public function render()
    {
        return view('livewire.tenant-users');
    }

    protected function getTableQuery()
    {
        return User::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('email')->searchable()->sortable(),
            TextColumn::make('roles.display_name'),
            TextColumn::make('created_at')->dateTime('F d, Y')

        ];
    }

    protected function getTableActions()
    {
        return [
            ActionGroup::make([
                ViewAction::make()->form([
                    TextInput::make('name'),
                    TextInput::make('email'),
                ]),
                EditAction::make()
                ->form([
                    TextInput::make('name'),
                    TextInput::make('email'),
                ]),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
        ];
    }
}
