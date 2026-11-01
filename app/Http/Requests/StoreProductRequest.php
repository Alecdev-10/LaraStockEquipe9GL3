<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'sku' => ['nullable', 'string', 'max:255', 'unique:products,sku'],
            'quantity' => ['required', 'integer', 'min:0', 'max:2147483647'],
            'price' => ['required', 'numeric', 'decimal:0,2', 'gt:0', 'max:99999999.99'],
            'low_stock_threshold' => ['required', 'integer', 'min:0', 'max:2147483647'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom du produit est obligatoire.',
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'category_id.required' => 'Veuillez choisir une catégorie.',
            'category_id.exists' => 'La catégorie choisie est invalide.',
            'sku.unique' => 'Cette référence est déjà utilisée.',
            'quantity.required' => 'La quantité est obligatoire.',
            'quantity.integer' => 'La quantité doit être un nombre entier.',
            'quantity.min' => 'La quantité ne peut pas être négative.',
            'quantity.max' => 'La quantité maximale autorisée est 2 147 483 647.',
            'price.required' => 'Le prix est obligatoire.',
            'price.numeric' => 'Le prix doit être un nombre.',
            'price.decimal' => 'Le prix doit comporter au maximum deux décimales.',
            'price.gt' => 'Le prix doit être supérieur à zéro.',
            'price.max' => 'Le prix ne peut pas dépasser 99 999 999,99.',
            'low_stock_threshold.required' => 'Le seuil d’alerte est obligatoire.',
            'low_stock_threshold.integer' => 'Le seuil d’alerte doit être un nombre entier.',
            'low_stock_threshold.min' => 'Le seuil d’alerte ne peut pas être négatif.',
            'low_stock_threshold.max' => 'Le seuil maximal autorisé est 2 147 483 647.',
        ];
    }
}
