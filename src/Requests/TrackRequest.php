<?php

namespace Sfneal\Tracking\Requests;

use Illuminate\Foundation\Http\FormRequest;

// todo: add to controllers package?
class TrackRequest extends FormRequest
{
    /**
     * TrackRequest constructor.
     *
     * @param array                $query      The GET parameters
     * @param array                $request    The POST parameters
     * @param array                $attributes The request attributes (parameters parsed from the PATH_INFO, ...)
     * @param array                $cookies    The COOKIE parameters
     * @param array                $files      The FILES parameters
     * @param array                $server     The SERVER parameters
     * @param string|resource|null $content    The raw body data
     */
    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        // Set container
        $this->setContainer(app());

        // Get validator instance
        $this->getValidatorInstance();
    }

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
