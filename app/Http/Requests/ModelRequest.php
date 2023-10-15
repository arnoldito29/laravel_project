<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModelRequest extends FormRequest
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
        $manufacturer = $this->manufacturer ? $this->manufacturer->id : 'NULL';
        $model = $this->model ? $this->model->id : 'NULL';
        $rule = sprintf(
            'required|unique:models,name,%s,id,manufacturer_id,%s,deleted_at,NULL|max:255',
            $model,
            $manufacturer
        );

        return [
            'name' => $rule,
        ];
    }
}
