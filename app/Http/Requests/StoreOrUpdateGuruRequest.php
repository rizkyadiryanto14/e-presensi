<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrUpdateGuruRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $guruId = $this->route('guru');

        return [
            'user_id' => ['required', 'exists:users,id'],
            'nip' => [
                'required',
                'string',
                Rule::unique('gurus', 'nip')->ignore($guruId),
            ],
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string'],
            'status_kepegawaian' => ['required', Rule::in(['PNS', 'Honorer'])],
            'gaji_pokok' => ['required', 'integer', 'min:0'],
            'tunjangan' => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'User harus dipilih.',
            'user_id.exists' => 'User tidak valid.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah digunakan.',
            'nama.required' => 'Nama wajib diisi.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'status_kepegawaian.required' => 'Status kepegawaian wajib dipilih.',
            'status_kepegawaian.in' => 'Status hanya boleh PNS atau Honorer.',
            'gaji_pokok.required' => 'Gaji pokok wajib diisi.',
            'gaji_pokok.integer' => 'Gaji pokok harus berupa angka.',
            'tunjangan.integer' => 'Tunjangan harus berupa angka.',
        ];
    }
}
