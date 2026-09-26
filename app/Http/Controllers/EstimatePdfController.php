<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstimatePdfRequest;
use App\Models\Estimate;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class EstimatePdfController extends Controller
{
    /**
     * Turn the calculator's rooms into a downloadable PDF estimate.
     */
    public function __invoke(EstimatePdfRequest $request): Response
    {
        $content = config('homepage');
        $rooms = $request->validated('rooms');
        $estimate = Estimate::fromRooms($rooms, $content['pricing'], $content['calculator']['labels']);

        $issuedAt = now();
        // A short code the customer can quote on the phone; the same rooms give the same code that day.
        $reference = 'PL-'.$issuedAt->format('ymd').'-'.strtoupper(substr(hash('crc32b', json_encode($rooms)), 0, 5));

        $fontCache = storage_path('fonts');
        File::ensureDirectoryExists($fontCache);

        $options = (new Options)
            ->setChroot([resource_path('fonts')])
            ->setFontDir($fontCache)
            ->setFontCache($fontCache)
            ->setDefaultFont('Noto Sans Georgian');

        $pdf = new Dompdf($options);
        $pdf->setPaper('A4');
        $pdf->loadHtml(view('pdf.estimate', compact('content', 'estimate', 'reference', 'issuedAt'))->render(), 'UTF-8');
        $pdf->render();

        // CSS cannot count pages in dompdf, so "1 / 2" is stamped into the footer after rendering.
        $canvas = $pdf->getCanvas();
        $font = $pdf->getFontMetrics()->getFont('Noto Sans Georgian');
        $canvas->page_text($canvas->get_width() - 66, $canvas->get_height() - 39.5, '{PAGE_NUM} / {PAGE_COUNT}', $font, 7.5, [0.4, 0.43, 0.45]);

        $filename = $content['calculator']['pdf']['filename'].'-'.$issuedAt->format('Y-m-d').'.pdf';

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}
