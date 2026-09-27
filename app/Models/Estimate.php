<?php

namespace App\Models;

/**
 * Prices the calculator's rooms on the server, using the same rules as resources/js/app.js,
 * so a downloaded estimate always shows the real prices from config/homepage.php.
 */
class Estimate
{
    /**
     * @param  array<int, array{number: int, length: float, width: float, area: float, edge: float, lines: array<int, array<string, mixed>>, total: float}>  $rooms
     */
    public function __construct(
        public readonly array $rooms,
        public readonly float $area,
        public readonly float $total,
    ) {}

    /**
     * @param  array<int, array<string, mixed>>  $rooms  validated rooms from the calculator
     * @param  array<string, mixed>  $pricing  config('homepage.pricing')
     * @param  array<string, string>  $labels  config('homepage.calculator.labels')
     */
    public static function fromRooms(array $rooms, array $pricing, array $labels): self
    {
        $priced = [];

        foreach (array_values($rooms) as $index => $room) {
            $length = (float) $room['length'];
            $width = (float) $room['width'];
            $area = round($length * $width, 2);
            $edge = round(2 * ($length + $width), 2);

            $finish = $pricing['finishes'][$room['finish']];
            $wall = $pricing['walls'][$room['wall'] ?? array_key_first($pricing['walls'])];
            $ceilingCost = $area * $finish['price'];
            $minimum = $pricing['minimum']['price'];

            $lines = [[
                'label' => "{$labels['ceiling']} ({$finish['name']})",
                'quantity' => $area,
                'unit' => $finish['unit'],
                'price' => (float) $finish['price'],
                'amount' => (float) max($ceilingCost, $minimum),
                'note' => $ceilingCost < $minimum ? $labels['minimum'] : null,
            ]];

            // Tile and porcelain walls add a fixing charge along the whole perimeter.
            if ($wall['price'] > 0) {
                $lines[] = self::line($wall, $edge);
            }

            foreach ($pricing['extras'] as $key => $extra) {
                $quantity = (float) ($room['extras'][$key] ?? 0);

                if ($quantity > 0) {
                    $lines[] = self::line($extra, $quantity);
                }
            }

            foreach ($pricing['perimeter'] as $key => $option) {
                if (! empty($room['perimeter'][$key])) {
                    $lines[] = self::line($option, $edge);
                }
            }

            $priced[] = [
                'number' => $index + 1,
                'length' => $length,
                'width' => $width,
                'area' => $area,
                'edge' => $edge,
                'lines' => $lines,
                'total' => (float) array_sum(array_column($lines, 'amount')),
            ];
        }

        return new self(
            $priced,
            (float) array_sum(array_column($priced, 'area')),
            (float) array_sum(array_column($priced, 'total')),
        );
    }

    /**
     * @param  array<string, mixed>  $item  a walls, extras or perimeter entry from the pricing config
     * @return array<string, mixed>
     */
    private static function line(array $item, float $quantity): array
    {
        return [
            'label' => $item['name'],
            'quantity' => $quantity,
            'unit' => $item['unit'],
            'price' => (float) $item['price'],
            'amount' => $quantity * $item['price'],
            'note' => null,
        ];
    }
}
