@extends('layouts.app')

@section('title', trans('messages.edit_product'))

@section('content')
<div class="page-header">
    <h1>{{ trans('messages.edit_product') }}</h1>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="product-form">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name_ar">{{ trans('messages.name_ar') }}</label>
        <input type="text" name="name_ar" id="name_ar" value="{{ old('name_ar', $product->name_ar) }}" required>
    </div>

    <div class="form-group">
        <label for="name_en">{{ trans('messages.name_en') }}</label>
        <input type="text" name="name_en" id="name_en" value="{{ old('name_en', $product->name_en) }}" required>
    </div>

    <div class="form-group">
        <label for="description_ar">{{ trans('messages.description_ar') }}</label>
        <textarea name="description_ar" id="description_ar" rows="5" required>{{ old('description_ar', $product->description_ar) }}</textarea>
    </div>

    <div class="form-group">
        <label for="description_en">{{ trans('messages.description_en') }}</label>
        <textarea name="description_en" id="description_en" rows="5" required>{{ old('description_en', $product->description_en) }}</textarea>
    </div>

    <div class="form-group">
        <label for="image">{{ trans('messages.image') }}</label>
        @if($product->image)
            <div class="current-image">
                <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ trans('messages.current_image') }}">
                <p>{{ trans('messages.current_image') }}</p>
            </div>
        @endif
        <input type="file" name="image" id="image" accept="image/*">
        <small>{{ trans('messages.leave_image_empty') }}</small>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">{{ trans('messages.save') }}</button>
        <a href="{{ route('products.index') }}" class="btn btn-info">{{ trans('messages.cancel') }}</a>
    </div>
</form>
@endsection
