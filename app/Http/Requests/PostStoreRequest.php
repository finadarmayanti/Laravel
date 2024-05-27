<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Anda mungkin ingin mengubah ini sesuai dengan logika otorisasi Anda
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'name' => 'required|string|max:258',
                'caption' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        } else {
            return [
                'name' => 'required|string|max:258',
                'caption' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        }
    }

    public function messages()
    {
        if ($this->isMethod('post')) {
            return [
                'name.required' => 'Name is required!',
                'caption.required' => 'Description is required!',
                'image.required' => 'Image is required!'
            ];
        } else {
            return [
                'name.required' => 'Name is required!',
                'caption.required' => 'Description is required!'
            ];
        }
    }
}
