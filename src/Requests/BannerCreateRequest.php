<?php

namespace admin\banners\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [                   
            'title' => 'required|string|min:3|max:255|unique:banners,title',
            'sub_title' => 'nullable|string|max:255',
            'button_title' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255',
            'sort_order' => 'nullable|numeric|max:255',
            'description' => 'required|string|min:3|max:65535',
            'image' => 'required|image',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
