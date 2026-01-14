<nav class="navbar">
    <div class="navbar-brand">
        <a href="{{ route('home') }}">{{ trans('messages.app_name') }}</a>
    </div>

    <ul class="navbar-menu">
        <li><a href="{{ route('home') }}">{{ trans('messages.home') }}</a></li>
        <li><a href="{{ route('products.index') }}">{{ trans('messages.products') }}</a></li>
        <li><a href="{{ route('products.create') }}">{{ trans('messages.add_product') }}</a></li>
    </ul>

    <div class="navbar-locale">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}"
               class="locale-link {{ app()->getLocale() == $localeCode ? 'active' : '' }}">
                {{ $properties['native'] }}
            </a>
        @endforeach
    </div>
</nav>
