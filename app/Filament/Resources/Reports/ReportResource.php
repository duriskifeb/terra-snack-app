<?php

namespace App\Filament\Resources\Reports;

use App\Filament\Resources\Reports\Pages\ManageReports;
use App\Models\Report;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Enums\Filters\SelectOption;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use pxlrbt\FilamentExcel\Actions\ExportAction; 
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static string|BackedEnum|null $navigationIcon = 'tabler-report-money'; 

    protected static bool $canCreate = false;

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canForceDelete($record): bool
    {
        return false;
    }

    public static function canRestore($record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID'),
                TextColumn::make('title')->label('Judul Report')->searchable(),
                TextColumn::make('user.name')->label('Dibuat Oleh')->searchable(),
                TextColumn::make('amount')
                    ->label('Jumlah/Nominal')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('period')
                    ->label('Filter Periode')
                    ->form([
                        \Filament\Forms\Components\Select::make('period')
                            ->options([
                                'this_week' => 'Minggu Ini',
                                'this_month' => 'Bulan Ini',
                                'last_30_days' => '30 Hari Terakhir',
                                'all' => 'Semua Waktu',
                            ])
                            ->default('all'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if ($data['period'] === 'this_week') {
                            return $query->whereBetween('created_at', [
                                Carbon::now()->startOfWeek(),
                                Carbon::now()->endOfWeek(),
                            ]);
                        }
                        if ($data['period'] === 'this_month') {
                            return $query->whereBetween('created_at', [
                                Carbon::now()->startOfMonth(),
                                Carbon::now()->endOfMonth(),
                            ]);
                        }
                         if ($data['period'] === 'last_30_days') {
                            return $query->where('created_at', '>=', Carbon::now()->subDays(30));
                        }
                        return $query;
                    }),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                ExportAction::make()->exports([
                    ExcelExport::make('report_export')
                        ->fromTable() 
                        ->withFilename(fn ($export) => 'report-' . now()->timestamp),
                ]),
            ])
            // ->footer(function (Builder $query) {
            //     $totalAmount = $query->sum('amount'); 

            //     return view('filament.tables.footers.report-total', [
            //         'totalAmount' => number_format($totalAmount, 0, ',', '.'),
            //     ]);
            // });
            ;
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageReports::route('/'),
        ];
    }
    
    // ... fungsi lainnya
}