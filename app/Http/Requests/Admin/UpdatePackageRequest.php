<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePackageRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge(['status' => $this->boolean('status')]);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:5000'],
            'image' => ['nullable', 'url', 'max:500'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'duration' => ['required', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:80'],
            'max_guests' => ['required', 'integer', 'min:1', 'max:1000'],
            'status' => ['boolean'],
        ];
    }
}
