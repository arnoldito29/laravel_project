<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransportRequest extends FormRequest
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
        $transport = $this->transport ? $this->transport->id : 'NULL';
        $rule = sprintf(
            'required|unique:transports,license_plate,%s,id,deleted_at,NULL|max:10',
            $transport
        );

        return [
            'license_plate' => $rule,
            'model_id' => 'required|exists:models,id',
            'fuel_tank_capacity' => 'required|numeric|between:0.001,9999.999',
            'average_fuel' => 'required|numeric|between:0.001,99.999',
        ];
    }
}
