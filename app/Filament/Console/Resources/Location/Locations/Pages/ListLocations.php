<?php

namespace App\Filament\Console\Resources\Location\Locations\Pages;

use App\Filament\Console\Resources\Location\Locations\LocationResource;
use App\Models\Location\Location;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Url;

class ListLocations extends ListRecords
{
    protected static string $resource = LocationResource::class;

    #[Url]
    public ?int $parentId = null;

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation|null
    {
        return parent::getTableQuery()->where('parent_id', $this->parentId);
    }

    public function getHeading(): string
    {
        if ($this->parentId) {
            $parent = Location::find($this->parentId);
            return $parent ? "Locations: " . $parent->name : "Locations";
        }
        return "Root Locations";
    }

    public function getSubheading(): string|Htmlable|null
    {
        if (!$this->parentId) {
            return null;
        }

        $breadcrumbs = [];
        $current = Location::find($this->parentId);
        
        while ($current) {
            array_unshift($breadcrumbs, $current);
            $current = $current->parent;
        }

        $html = '<nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-4">';
        $html .= '<a href="' . static::getUrl(['parentId' => null]) . '" class="hover:text-primary-600 transition-colors font-medium">Root</a>';
        
        foreach ($breadcrumbs as $index => $crumb) {
            $html .= ' <span class="text-gray-400">/</span> ';
            if ($index === count($breadcrumbs) - 1) {
                $html .= '<span class="font-semibold text-gray-700 dark:text-gray-200">' . e($crumb->name) . '</span>';
            } else {
                $html .= '<a href="' . static::getUrl(['parentId' => $crumb->id]) . '" class="hover:text-primary-600 transition-colors font-medium">' . e($crumb->name) . '</a>';
            }
        }
        $html .= '</nav>';

        return new HtmlString($html);
    }

    protected function getHeaderActions(): array
    {
        $actions = [];

        if ($this->parentId) {
            $parent = Location::find($this->parentId);
            $actions[] = \Filament\Actions\Action::make('goBack')
                ->label('Go Up')
                ->icon('heroicon-m-arrow-left')
                ->color('gray')
                ->url(fn () => static::getUrl(['parentId' => $parent?->parent_id]));
        }

        $actions[] = CreateAction::make()
            ->url(fn () => static::getResource()::getUrl('create', ['parentId' => $this->parentId]));

        return $actions;
    }
}
