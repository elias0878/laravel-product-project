<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * عرض قائمة المنتجات
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * عرض نموذج إنشاء منتج جديد
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * حفظ المنتج الجديد
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();

        // معالجة ورفع الصورة
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            
            // تعيين umask لضمان صلاحيات صحيحة
            $old = umask(0);
            $image->move(public_path('images/products'), $imageName);
            umask($old);
            
            $data['image'] = $imageName;
        }

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', trans('messages.product_created'));
    }

    /**
     * عرض تفاصيل المنتج
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * عرض نموذج تعديل المنتج
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * تحديث بيانات المنتج
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // معالجة ورفع الصورة الجديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
                @unlink(public_path('images/products/' . $product->image));
            }

            $image = $request->file('image');
            $imageName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            
            // تعيين umask لضمان صلاحيات صحيحة
            $old = umask(0);
            $image->move(public_path('images/products'), $imageName);
            umask($old);
            
            $data['image'] = $imageName;
        }

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', trans('messages.product_updated'));
    }

    /**
     * حذف المنتج
     */
    public function destroy(Product $product)
    {
        // حذف الصورة (مع التحقق من الصلاحيات)
        if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
            @unlink(public_path('images/products/' . $product->image));
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', trans('messages.product_deleted'));
    }
}
