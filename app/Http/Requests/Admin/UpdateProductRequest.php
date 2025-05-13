<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Only users with 'edit products' permission can update products
        return auth()->user()->can('edit products');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'sku' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products', 'sku')->ignore($this->route('id'))
            ],
            'inventory' => ['required', 'integer', 'min:0'],
            'available' => ['nullable', 'boolean'],
            'product_image' => ['nullable', 'array'],
            'product_image.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'color' => ['nullable', 'array'],
            'color.*' => ['nullable', 'string', 'max:50'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes()
    {
        return [
            'name' => 'product name',
            'description' => 'product description',
            'price' => 'product price',
            'category_id' => 'category',
            'sku' => 'SKU',
            'inventory' => 'inventory quantity',
            'available' => 'availability status',
            'product_image' => 'product image',
            'product_image.*' => 'product image',
            'color' => 'color',
            'color.*' => 'color',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'The product name is required.',
            'description.required' => 'The product description is required.',
            'price.required' => 'The product price is required.',
            'price.numeric' => 'The product price must be a number.',
            'price.min' => 'The product price must be at least :min.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category is invalid.',
            'sku.required' => 'The SKU is required.',
            'sku.unique' => 'This SKU is already in use.',
            'inventory.required' => 'The inventory quantity is required.',
            'inventory.integer' => 'The inventory quantity must be a whole number.',
            'inventory.min' => 'The inventory quantity must be at least :min.',
            'product_image.*.image' => 'The file must be an image.',
            'product_image.*.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'product_image.*.max' => 'The image may not be greater than 2MB.',
        ];
    }
}
