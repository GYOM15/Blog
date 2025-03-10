<?php
/*
 * Cette class nous permet d'établir des paramètres de validation
 * Cela permet de nous assurer que dans le controller, les données correspondent à ce qu'on attend
 * */
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BlogFilterRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'title' => ['required', 'min:4'],
            'slug' => ['required', 'regex:/^[a-z0-9\-]+$/']
        ];
    }

    public function prepareForValidation()
    {
        //
        $this->merge([
            'slug' => $this->input('slug') ?: Str::slug($this->input('title'))
        ]);
    }
}
