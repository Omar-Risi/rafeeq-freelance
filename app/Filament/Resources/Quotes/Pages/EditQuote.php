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
            ->action(function (Quote $record) {
                // 1. Render the HTML from the Blade template
                $html = view('quotes.template', ['quote' => $record])->render();

                // 2. CRITICAL STEP: Convert any non-UTF-8 characters to HTML entities
                // This prevents the "Malformed UTF-8" error common with Dompdf
                $cleaned_html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

                // 3. Load the cleaned HTML and stream the PDF
                return Pdf::loadHtml($cleaned_html)
                          ->setPaper('a4')
                          ->stream('quotation-' . $record->id . '.pdf');
            }),
        ];
    }
}
