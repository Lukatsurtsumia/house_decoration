@php
    $brand = $content['brand'];
    $contact = $content['contact'];
    $labels = $content['calculator']['labels'];
    $pdf = $content['calculator']['pdf'];
    $currency = $content['pricing']['currency'];
    $fonts = resource_path('fonts');

    // Georgian number style: comma decimals, space thousands, no trailing zeros.
    $number = fn (float $value): string => rtrim(rtrim(number_format($value, 2, ',', ' '), '0'), ',');
    $money = fn (float $value): string => $number($value).' '.$currency;
    // The PDF font has no "²" glyph, so it is drawn as a raised 2.
    $unit = fn (string $text): string => str_replace('²', '<sup>2</sup>', e($text));
@endphp
<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="utf-8">
    <title>{{ $pdf['title'] }} {{ $reference }}</title>
    <style>
        @font-face {
            font-family: 'Noto Sans Georgian';
            font-style: normal;
            font-weight: normal;
            src: url('{{ $fonts }}/NotoSansGeorgian-Regular.ttf') format('truetype');
        }

        @font-face {
            font-family: 'Noto Sans Georgian';
            font-style: normal;
            font-weight: bold;
            src: url('{{ $fonts }}/NotoSansGeorgian-Bold.ttf') format('truetype');
        }

        @font-face {
            font-family: 'Noto Serif Georgian';
            font-style: normal;
            font-weight: bold;
            src: url('{{ $fonts }}/NotoSerifGeorgian-SemiBold.ttf') format('truetype');
        }

        @page {
            margin: 16mm 16mm 24mm;
        }

        body {
            font-family: 'Noto Sans Georgian';
            font-size: 9.5pt;
            line-height: 1.35;
            color: #17191b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 0;
            vertical-align: top;
        }

        sup {
            font-size: 65%;
            vertical-align: super;
            line-height: 0;
        }

        .display {
            font-family: 'Noto Serif Georgian';
            font-weight: bold;
        }

        .muted {
            color: #676d73;
        }

        .right {
            text-align: right;
        }

        /* Header */
        .header td {
            vertical-align: middle;
        }

        /* The logo mark (see logo-mark.blade.php), drawn with boxes because dompdf sizes SVG unreliably. */
        .logo {
            position: relative;
            width: 12mm;
            height: 12mm;
            border-radius: 2.6mm;
            background: #17191b;
        }

        .logo-ceiling {
            position: absolute;
            top: 3.5mm;
            left: 3mm;
            width: 6mm;
            height: 0.85mm;
            border-radius: 0.4mm;
            background: #ffffff;
        }

        .logo-cord {
            position: absolute;
            top: 3.9mm;
            left: 5.72mm;
            width: 0.56mm;
            height: 1.6mm;
            background: #ffffff;
        }

        .logo-lamp {
            position: absolute;
            top: 5.53mm;
            left: 4.78mm;
            width: 2.44mm;
            height: 2.44mm;
            border-radius: 1.22mm;
            background: #0f8a5f;
        }

        .brand-name {
            font-size: 21pt;
            line-height: 1.1;
        }

        .brand-tagline {
            font-size: 8.5pt;
        }

        .doc-title {
            font-size: 15pt;
            line-height: 1.2;
        }

        .rule {
            height: 3px;
            margin: 5mm 0 5mm;
            background: #0f8a5f;
        }

        /* Summary */
        .summary {
            padding: 3mm 5mm;
            border-radius: 6px;
            background: #f3f5f1;
        }

        .label {
            font-size: 8pt;
            color: #676d73;
        }

        .summary .value {
            font-size: 12pt;
        }

        .summary .total {
            font-size: 15pt;
            color: #0b6b4a;
        }

        /* Rooms */
        .room {
            margin-top: 5mm;
            page-break-inside: avoid;
        }

        .room-head td {
            padding-bottom: 2mm;
            border-bottom: 1.5px solid #17191b;
            vertical-align: bottom;
        }

        .room-title,
        .room-total {
            font-size: 12pt;
        }

        .plan-cell {
            width: 46mm;
            padding: 3mm 6mm 0 0;
        }

        .plan {
            padding: 2mm 0;
            border-radius: 6px;
            background: #f3f5f1;
            text-align: center;
        }

        .plan-box {
            width: auto;
            margin: 1.5mm auto;
        }

        .plan-box td {
            border: 1.5px solid #17191b;
            background: #ffffff;
            text-align: center;
            vertical-align: middle;
            font-size: 8.5pt;
            font-weight: bold;
        }

        .dim {
            font-size: 7pt;
            color: #676d73;
        }

        .lines {
            margin-top: 2mm;
        }

        .lines th {
            padding: 1.2mm 0 1mm;
            border-bottom: 1px solid #e2e5e0;
            font-size: 7.5pt;
            font-weight: normal;
            color: #676d73;
            text-align: left;
        }

        .lines td {
            padding: 1mm 0;
            border-bottom: 1px solid #eef0ec;
        }

        .lines .num {
            padding-left: 3mm;
            text-align: right;
            white-space: nowrap;
        }

        .note {
            font-size: 7.5pt;
            color: #0b6b4a;
        }

        /* Grand total */
        .grand {
            margin-top: 5mm;
            padding: 3.5mm 6mm;
            border-radius: 6px;
            background: #17191b;
            color: #ffffff;
            page-break-inside: avoid;
        }

        .grand td {
            vertical-align: middle;
        }

        .grand .label {
            font-size: 10pt;
            color: #c9cdc7;
        }

        .grand .value {
            font-size: 18pt;
        }

        /* Notes and contacts */
        .info {
            margin-top: 5mm;
            page-break-inside: avoid;
        }

        .info td {
            width: 50%;
        }

        .info td + td {
            padding-left: 8mm;
        }

        .info-title {
            margin-bottom: 1.2mm;
            font-size: 9.5pt;
        }

        .info-item {
            margin-bottom: 0.8mm;
            padding-left: 3.5mm;
            text-indent: -3.5mm;
            font-size: 8pt;
            line-height: 1.35;
        }

        .contact-row {
            margin-bottom: 0.8mm;
            font-size: 8pt;
        }

        footer {
            position: fixed;
            right: 0;
            bottom: -15mm;
            left: 0;
            padding-top: 2.5mm;
            border-top: 1px solid #e2e5e0;
            font-size: 7.5pt;
            color: #676d73;
        }
    </style>
</head>
<body>
    <footer>
        <table>
            <tr>
                <td>{{ $brand['name'] }} · {{ $brand['tagline'] }}</td>
                {{-- Page numbers are drawn at the right edge by EstimatePdfController. --}}
                <td class="right" style="padding-right: 12mm;">{{ $pdf['reference'] }} {{ $reference }}</td>
            </tr>
        </table>
    </footer>

    <table class="header">
        <tr>
            <td style="width: 16mm;">
                <div class="logo">
                    <div class="logo-ceiling"></div>
                    <div class="logo-cord"></div>
                    <div class="logo-lamp"></div>
                </div>
            </td>
            <td>
                <div class="display brand-name">{{ $brand['name'] }}</div>
                <div class="muted brand-tagline">{{ $brand['tagline'] }}</div>
            </td>
            <td class="right">
                <div class="display doc-title">{{ $pdf['title'] }}</div>
                <div class="muted">{{ $pdf['reference'] }} {{ $reference }}</div>
                <div class="muted">{{ $pdf['date'] }}: {{ $issuedAt->format('d.m.Y') }}</div>
            </td>
        </tr>
    </table>

    <div class="rule"></div>

    <div class="summary">
        <table>
            <tr>
                <td>
                    <div class="label">{{ $pdf['rooms'] }}</div>
                    <div class="display value">{{ count($estimate->rooms) }}</div>
                </td>
                <td>
                    <div class="label">{{ $pdf['total_area'] }}</div>
                    <div class="display value">{{ $number($estimate->area) }} {!! $unit($labels['sqm']) !!}</div>
                </td>
                <td class="right">
                    <div class="label">{{ $pdf['total'] }}</div>
                    <div class="display total">{{ $money($estimate->total) }}</div>
                </td>
            </tr>
        </table>
    </div>

    @foreach ($estimate->rooms as $room)
        @php
            // Draw the room to scale inside a 32 x 16 mm box.
            $scale = min(32 / $room['length'], 16 / $room['width']);
            $planWidth = round($room['length'] * $scale, 1);
            $planHeight = round($room['width'] * $scale, 1);
        @endphp

        <div class="room">
            <table class="room-head">
                <tr>
                    <td class="display room-title">
                        {{ $labels['room'] }} {{ $room['number'] }}
                        <span class="muted">· {{ $number($room['length']) }} × {{ $number($room['width']) }} {{ $labels['meter'] }}</span>
                    </td>
                    <td class="right display room-total">{{ $money($room['total']) }}</td>
                </tr>
            </table>

            <table>
                <tr>
                    <td class="plan-cell">
                        <div class="plan">
                            <div class="dim">{{ $number($room['length']) }} {{ $labels['meter'] }}</div>
                            <table class="plan-box">
                                <tr>
                                    <td style="width: {{ $planWidth }}mm; height: {{ $planHeight }}mm;">{{ $number($room['area']) }} {!! $unit($labels['sqm']) !!}</td>
                                </tr>
                            </table>
                            <div class="dim">{{ $labels['perimeter'] }}: {{ $number($room['edge']) }} {{ $labels['meter'] }}</div>
                        </div>
                    </td>
                    <td>
                        <table class="lines">
                            <thead>
                                <tr>
                                    <th>{{ $pdf['columns']['item'] }}</th>
                                    <th class="num">{{ $pdf['columns']['quantity'] }}</th>
                                    <th class="num">{{ $pdf['columns']['price'] }}</th>
                                    <th class="num">{{ $pdf['columns']['amount'] }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($room['lines'] as $line)
                                    <tr>
                                        <td>
                                            {{ $line['label'] }}
                                            @if ($line['note'])
                                                <div class="note">{{ $line['note'] }}</div>
                                            @endif
                                        </td>
                                        <td class="num">{{ $number($line['quantity']) }} {!! $unit($line['unit']) !!}</td>
                                        <td class="num">{{ $money($line['price']) }}</td>
                                        <td class="num">{{ $money($line['amount']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    @endforeach

    <div class="grand">
        <table>
            <tr>
                <td class="label">{{ $pdf['total'] }}</td>
                <td class="right display value">{{ $money($estimate->total) }}</td>
            </tr>
        </table>
    </div>

    <table class="info">
        <tr>
            <td>
                <div class="display info-title">{{ $pdf['notes_title'] }}</div>
                @foreach ($pdf['notes'] as $note)
                    <div class="info-item">• {{ $note }}</div>
                @endforeach
            </td>
            <td>
                <div class="display info-title">{{ $pdf['contact_title'] }}</div>
                <div class="contact-row">{{ $contact['labels']['phone'] }}: <strong>{{ $contact['phone'] }}</strong></div>
                <div class="contact-row">{{ $contact['labels']['email'] }}: <strong>{{ $contact['email'] }}</strong></div>
                <div class="contact-row">{{ $contact['labels']['hours'] }}: {{ $contact['hours'] }}</div>
            </td>
        </tr>
    </table>
</body>
</html>
