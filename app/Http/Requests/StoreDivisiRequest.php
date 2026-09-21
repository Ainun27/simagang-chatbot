<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDivisiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_divisi' => 'required|string|max:255|unique:divisi,nama_divisi',
            'deskripsi'   => 'required|string|min:20',
            'kuota'       => 'required|integer|min:1|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_divisi.required' => 'Nama divisi wajib diisi.',
            'nama_divisi.unique'   => 'Nama divisi sudah ada.',
            'nama_divisi.max'      => 'Nama divisi maksimal 255 karakter.',
            'deskripsi.required'   => 'Deskripsi divisi wajib diisi.',
            'deskripsi.min'        => 'Deskripsi divisi minimal 20 karakter.',
            'kuota.required'       => 'Kuota divisi wajib diisi.',
            'kuota.integer'        => 'Kuota harus berupa angka bulat.',
            'kuota.min'            => 'Kuota minimal 1.',
            'kuota.max'            => 'Kuota maksimal 50.',
        ];
    }
}
