@extends('layouts.app')

@section('title', trans('messages.home'))

@section('content')
<div class="hero">
    <h1>{{ trans('messages.welcome') }}</h1>
    <p>{{ trans('messages.welcome_message') }}</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary">
        {{ trans('messages.view_products') }}
    </a>
</div>
@endsection
