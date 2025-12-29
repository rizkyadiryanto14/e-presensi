<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAbsensiRequest extends FormRequest
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
        return [
            'guru_id' => ['required', 'exists:gurus,id'],
            'tanggal' => ['required', 'date'],
            'status' => ['required', 'in:hadir,izin,sakit,alpha'],
            'waktu_masuk' => ['nullable', 'date_format:H:i'],
            'waktu_pulang' => ['nullable', 'date_format:H:i'],
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'guru_id.required' => 'Guru harus dipilih.',
            'guru_id.exists' => 'Guru tidak ditemukan.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal tidak valid.',
            'status.required' => 'Status kehadiran wajib dipilih.',
            'status.in' => 'Status hanya boleh hadir, izin, sakit, atau alpha.',
            'waktu_masuk.date_format' => 'Format waktu masuk harus HH:MM.',
            'waktu_pulang.date_format' => 'Format waktu pulang harus HH:MM.',
        ];
    }
}
