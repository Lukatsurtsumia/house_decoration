<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EstimatePdfRequest extends FormRequest
{
    /**
     * Anyone can download an estimate of their own rooms.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * The calculator posts its rooms as a single JSON string.
     */
    protected function prepareForValidation(): void
    {
        $rooms = json_decode((string) $this->input('rooms'), true);

        $this->merge(['rooms' => is_array($rooms) ? $rooms : null]);
    }

    /**
     * Only sizes, finishes and add-ons that exist in config/homepage.php are accepted,
     * so a downloaded estimate can never contain made-up prices.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $pricing = config('homepage.pricing');
        $dimensions = config('homepage.calculator.dimensions');
        $size = ['required', 'numeric', 'min:'.$dimensions['min'], 'max:'.$dimensions['input_max']];

        return [
            'rooms' => ['required', 'array', 'min:1', 'max:'.config('homepage.calculator.max_rooms')],
            'rooms.*.length' => $size,
            'rooms.*.width' => $size,
            'rooms.*.finish' => ['required', Rule::in(array_keys($pricing['finishes']))],
            'rooms.*.extras' => ['sometimes', 'array:'.implode(',', array_keys($pricing['extras']))],
            'rooms.*.extras.*' => ['numeric', 'min:0', 'max:999'],
            'rooms.*.perimeter' => ['sometimes', 'array:'.implode(',', array_keys($pricing['perimeter']))],
            'rooms.*.perimeter.*' => ['boolean'],
        ];
    }
}
