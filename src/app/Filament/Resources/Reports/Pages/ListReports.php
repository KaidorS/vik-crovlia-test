<?php

namespace App\Filament\Resources\Reports\Pages;

use App\Filament\Resources\Reports\ReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Filament\Actions\Action;
use App\Models\Report;

class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        $user = auth()->user();
        $isAdmin = $user->hasAnyRole(['super_admin', 'panel_user']);

        if ($isAdmin) {
            return [CreateAction::make()];
        }

        $hasReportToday = Report::hasTodayReportForUser($user->id);

        if (!$hasReportToday) {
            return [CreateAction::make()];
        }

        return [
            Action::make('disabled_create')
                ->label('')
                ->disabled()
                ->extraAttributes(['class' => 'pointer-events-none'])
                ->view('filament.resources.report._disabled_create_button')
        ];
    }

    // Добавляем кастомный футер
    public function getFooter(): ?View
    {
        $total = $this->getTotalRevenue();
        return view('filament.resources.report._revenue_summary', ['totalRevenue' => $total]);
    }


    protected function getTotalRevenue(): float
    {
        $query = ReportResource::getEloquentQuery();

        // Используем состояние фильтров Livewire из свойства $this->tableFilters
        $filters = $this->tableFilters ?? [];
        if (isset($filters['month_year']['month'])) {
            $query->whereMonth('created_at', $filters['month_year']['month']);
        }
        if (isset($filters['month_year']['year'])) {
            $query->whereYear('created_at', $filters['month_year']['year']);
        }

        Log::info('Footer rendered', $this->tableFilters ?? []);

        return (float) $query->sum('revenue');
    }
}
