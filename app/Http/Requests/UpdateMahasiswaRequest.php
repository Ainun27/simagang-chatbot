<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $mahasiswaId = $this->route('mahasiswa') instanceof \App\Models\Mahasiswa 
            ? $this->route('mahasiswa')->id 
            : $this->route('mahasiswa');

        return [
            'nim' => 'required|string|min:5|max:20|unique:mahasiswa,nim,' . $mahasiswaId,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswa,email,' . $mahasiswaId,
            'no_hp' => 'required|string|min:10|max:15',
            'universitas' => 'required|string|max:255',
            'divisi_id' => 'required|exists:divisi,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'is_active' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah digunakan oleh mahasiswa lain.',
            'nim.min' => 'NIM minimal 5 karakter.',
            'nim.max' => 'NIM maksimal 20 karakter.',
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh mahasiswa lain.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.min' => 'Nomor HP minimal 10 digit.',
            'no_hp.max' => 'Nomor HP maksimal 15 digit.',
            'universitas.required' => 'Universitas wajib diisi.',
            'divisi_id.required' => 'Divisi magang wajib dipilih.',
            'divisi_id.exists' => 'Divisi yang dipilih tidak valid.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'is_active.required' => 'Status wajib dipilih.',
            'is_active.boolean' => 'Status tidak valid.',
        ];
    }
}
