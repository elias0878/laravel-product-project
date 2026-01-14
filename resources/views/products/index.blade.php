@extends('layouts.app')

@section('title', trans('messages.products'))

@section('content')
<div class="page-header">
    <h1>{{ trans('messages.products') }}</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        {{ trans('messages.add_product') }}
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($products->count() > 0)
    <div class="products-grid">
        @foreach($products as $product)
            <div class="product-card">
                @if($product->image)
                    <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                @else
                    <div class="no-image">{{ trans('messages.no_image') }}</div>
                @endif

                <div class="product-info">
                    <h3>{{ $product->name }}</h3>
                    <p>{{ Str::limit($product->description, 100) }}</p>

                    <div class="product-actions">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-info">{{ trans('messages.show') }}</a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">{{ trans('messages.edit') }}</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('{{ trans('messages.confirm_delete') }}')">
                                {{ trans('messages.delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pagination">
        {{ $products->links() }}
    </div>
@else
    <div class="hero">
        <h1>{{ trans('messages.no_products') }}</h1>
        <p>{{ trans('messages.start_adding') }}</p>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            {{ trans('messages.add_product') }}
        </a>
    </div>
@endif
@endsection
