<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Livewire\Attributes\Url;
use Filament\Tables\Table;
use Filament\Tables;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    #[Url(history: true)]
    public string $listType = 'kanban';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('switchListType')
                ->label(fn () => $this->listType == 'kanban' ? 'Switch to List' : 'Switch to Kanban')
                ->action('updateView')
        ];
    }

    public function updateView () {
        $this->listType = $this->listType === 'kanban' ? 'list' : 'kanban';
    }


    public function table(Table $table): Table
    {
        return $table
            ->content(fn () => $this->listType === 'kanban' ? view('kanban') : null)
            ->selectable(fn () => $this->listType !== 'kanban')
            ->paginated(fn () => $this->listType !== 'kanban')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
