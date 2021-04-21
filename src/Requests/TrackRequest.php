<?php

namespace Sfneal\Tracking\Requests;

use Sfneal\Requests\FormRequest;

class TrackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'table' => ['string', 'nullable'],
            'user' => ['integer', 'nullable'],
            'users' => ['array', 'nullable'],
            'key' => ['integer', 'nullable'],
            'period' => ['array', 'nullable'],
        ];
    }
}
