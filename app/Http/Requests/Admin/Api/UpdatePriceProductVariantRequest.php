<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Api;

use App\Support\FormRequest\Concerns\HasPrice;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePriceProductVariantRequest extends FormRequest
{
    use HasPrice;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->priceRules();
    }
}
