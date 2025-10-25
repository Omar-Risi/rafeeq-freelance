<?php

namespace App\Filament\Resources\Quotes\Pages;

use App\Filament\Resources\Quotes\QuoteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf; // Use the Dompdf Facade
use App\Models\Quote;

class EditQuote extends EditRecord
{
    protected static string $resource = QuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            Action::make('download_pdf')
            ->label('Download PDF')
            ->color('primary')
            ->icon('heroicon-o-document-arrow-down')
            ->action(function () {
                // Use $this->record instead of the parameter
                $quote = $this->record;

                // Fresh load with relationships
                $quote = Quote::with(['project', 'items'])->findOrFail($quote->id);

                // Generate PDF
                $pdf = Pdf::loadView('quotes.template', ['quote' => $quote])
                        ->setPaper('a4', 'portrait');

                // Stream download
                return response()->streamDownload(
                    fn() => print($pdf->output()),
                    'quotation-' . $quote->id . '.pdf'
                );
            })
        ];
    }
}
