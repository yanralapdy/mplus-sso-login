<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth;

use App\Enums\SSOLoginProviderEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SSOAuthFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     * */
    public function rules(): array
    {
        return [
            'token' => ['required', 'string'],
            'provider' => ['required', Rule::enum(SSOLoginProviderEnum::class)],
            'device_name' => ['nullabel', 'string'],
        ];
    }
}
