<?php

namespace Tests\Feature;

use App\Models\Estimate;
use Tests\TestCase;

class EstimatePdfTest extends TestCase
{
    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function room(array $overrides = []): array
    {
        return array_merge(['length' => 4.5, 'width' => 4, 'finish' => 'matte', 'extras' => [], 'perimeter' => []], $overrides);
    }

    public function test_estimate_uses_the_same_prices_as_the_calculator(): void
    {
        $estimate = Estimate::fromRooms([
            $this->room(),
            $this->room(['length' => 2, 'width' => 2]),
            $this->room([
                'length' => 5,
                'width' => 4,
                'finish' => 'gloss',
                'extras' => ['lights' => 2, 'pipes' => 1, 'curtain' => 3],
                'perimeter' => ['shadow' => true],
            ]),
        ], config('homepage.pricing'), config('homepage.calculator.labels'));

        // 18 m² × 21 ₾; a 4 m² room pays the 180 ₾ minimum; 20 m² × 25 + 24 + 10 + 330 + 18 m × 22.
        $this->assertSame([378.0, 180.0, 1260.0], array_column($estimate->rooms, 'total'));
        $this->assertSame(1818.0, $estimate->total);
        $this->assertSame(42.0, $estimate->area);
        $this->assertSame(config('homepage.calculator.labels.minimum'), $estimate->rooms[1]['lines'][0]['note']);
    }

    public function test_it_downloads_the_estimate_as_a_pdf(): void
    {
        $response = $this->post(route('estimate.pdf'), [
            'rooms' => json_encode([$this->room(['extras' => ['lights' => 4]])]),
        ]);

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
        $this->assertStringContainsString('attachment; filename="plafond-estimate-', $response->headers->get('Content-Disposition'));
        $this->assertStringStartsWith('%PDF-', $response->getContent());
    }

    public function test_it_rejects_prices_that_are_not_in_the_config(): void
    {
        $response = $this->post(route('estimate.pdf'), [
            'rooms' => json_encode([$this->room(['finish' => 'gold', 'extras' => ['walls' => 3]])]),
        ]);

        $response->assertSessionHasErrors(['rooms.0.finish', 'rooms.0.extras']);
    }

    public function test_it_requires_rooms(): void
    {
        $this->post(route('estimate.pdf'), ['rooms' => 'not json'])->assertSessionHasErrors('rooms');
    }
}
