<?php

namespace App\Filament\Imports;

use App\Models\Category;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class CategoryImporter extends Importer
{
    protected static ?string $model = Category::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->label(__('Name'))
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->example(__('Category A')),
            ImportColumn::make('slug')
                ->label(__('Slug'))
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->example('category-a'),
            ImportColumn::make('description')
                ->label(__('Description'))
                ->example(__('This is the description for Category A.')),
            ImportColumn::make('is_visible')
                ->label(__('Visibility'))
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean'])
                ->example('yes'),
            ImportColumn::make('seo_title')
                ->label(__('SEO title'))
                ->rules(['max:60'])
                ->example('Awesome Category A'),
            ImportColumn::make('seo_description')
                ->label(__('SEO description'))
                ->rules(['max:160'])
                ->example(__('Wow! It\'s just so amazing.')),
        ];
    }

    public function resolveRecord(): ?Category
    {
        return Category::firstOrNew([
            'slug' => $this->data['slug'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = __('Your category import has been completed and :successful_rows :rows have been imported.', ['successful_rows' => number_format($import->successful_rows), 'rows' => __(str('row')->plural($import->successful_rows))]);

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . __(str('row')->plural($failedRowsCount)) . __(' failed to import.');
        }

        return $body;
    }
}
