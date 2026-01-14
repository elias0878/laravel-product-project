<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * الحقول القابلة للتعبئة في قاعدة البيانات
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'image',
    ];

    /**
     * الحصول على اسم المنتج بناءً على اللغة الحالية
     */
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->name_ar : $this->name_en;
    }

    /**
     * الحصول على وصف المنتج بناءً على اللغة الحالية
     */
    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->description_ar : $this->description_en;
    }
}
