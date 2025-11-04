<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Filament\Imports\CategoryImporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ImportAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label(__('Slug'))
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_visible')
                    ->label(__('Visibility')),
                TextColumn::make('updated_at')
                    ->label(__('Last Updated'))
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(CategoryImporter::class)
                    ->chunkSize(250)
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
