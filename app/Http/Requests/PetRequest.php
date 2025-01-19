<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'            => 'required|integer',
            'name'          => 'required|string|max:255',
            'status'        => 'required|in:available,pending,sold',
            'category_id'   => 'required|integer',
            'category_name' => 'required|string|max:255',
            'photo_url'     => 'required',
            'tags.*.id'     => 'nullable|integer',
            'tags.*.name'   => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'id.required'            => 'ID jest wymagane.',
            'id.integer'             => 'ID musi być liczbą całkowitą.',
            'name.required'          => 'Nazwa jest wymagana.',
            'name.string'            => 'Nazwa musi być tekstem.',
            'name.max'               => 'Nazwa nie może mieć więcej niż 255 znaków.',
            'status.required'        => 'Status jest wymagany.',
            'status.in'              => 'Status musi być jedną z wartości: available, pending, sold.',
            'category_id.required'   => 'ID kategorii jest wymagane.',
            'category_id.integer'    => 'ID kategorii musi być liczbą.',
            'category_name.required' => 'Nazwa kategorii jest wymagana.',
            'category_name.string'   => 'Nazwa kategorii musi być tekstem.',
            'category_name.max'      => 'Nazwa kategorii nie może mieć więcej niż 255 znaków.',
            'photo_url.required'     => 'URL zdjęcia jest wymagany.',
            'tags.*.id.integer'      => 'ID tagu musi być liczbą całkowitą.',
            'tags.*.name.string'     => 'Nazwa tagu musi być tekstem.',
            'tags.*.name.max'        => 'Nazwa tagu nie może mieć więcej niż 255 znaków.',
        ];
    }
}
