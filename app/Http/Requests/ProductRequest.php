<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * تحديد ما إذا كان المستخدم مفوضاً لإجراء هذا الطلب
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * الحصول على قواعد التحقق التي تنطبق على الطلب
     */
    public function rules(): array
    {
        return [
            'name_ar' => 'required|min:3',
            'name_en' => 'required|min:3',
            'description_ar' => 'required|min:10',
            'description_en' => 'required|min:10',
            'image' => 'required|image|mimes:jpg,png|max:2048',
        ];
    }

    /**
     * الحصول على رسائل الخطأ المخصصة
     */
    public function messages(): array
    {
        return [
            'name_ar.required' => 'حقل الاسم العربي مطلوب',
            'name_ar.min' => 'يجب أن يحتوي الاسم العربي على 3 أحرف على الأقل',
            'name_en.required' => 'حقل الاسم الإنجليزي مطلوب',
            'name_en.min' => 'يجب أن يحتوي الاسم الإنجليزي على 3 أحرف على الأقل',
            'description_ar.required' => 'حقل الوصف العربي مطلوب',
            'description_ar.min' => 'يجب أن يحتوي الوصف العربي على 10 أحرف على الأقل',
            'description_en.required' => 'حقل الوصف الإنجليزي مطلوب',
            'description_en.min' => 'يجب أن يحتوي الوصف الإنجليزي على 10 أحرف على الأقل',
            'image.required' => 'حقل الصورة مطلوب',
            'image.image' => 'يجب أن يكون الملف صورة',
            'image.mimes' => 'يجب أن تكون الصورة من نوع jpg أو png',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
        ];
    }
}
