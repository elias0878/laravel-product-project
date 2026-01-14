@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="page-header">
    <h1>{{ $product->name }}</h1>
    <div class="action-buttons">
        <a href="{{ route('products.edit', $product) }}" class="btn btn-edit">{{ trans('messages.edit') }}</a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">{{ trans('messages.back') }}</a>
    </div>
</div>

<div class="product-details">
    @if($product->image)
        <div class="product-image-large">
            <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}">
        </div>
    @endif

    <div class="product-info">
        <div class="info-item">
            <strong>{{ trans('messages.name') }}:</strong>
            <span>{{ $product->name }}</span>
        </div>

        <div class="info-item">
            <strong>{{ trans('messages.description') }}:</strong>
            <p>{{ $product->description }}</p>
        </div>

        <div class="info-item">
            <strong>{{ trans('messages.created_at') }}:</strong>
            <span>{{ $product->created_at->format('Y-m-d H:i') }}</span>
        </div>
    </div>
</div>
@endsection
