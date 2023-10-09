<div class="navbar-brand language-switcher">
    <div class="dropdown">
        <button class="btn dropdown-toggle" style="font-size: 15px;" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            {{ __('Language') }}
        </button>
        <ul class="dropdown-menu " aria-labelledby="languageDropdown">
            @foreach($available_locales as $locale_name => $available_locale)
                <li>
                    <a class="dropdown-item" href="{{ route('language.switch', ['locale' => $available_locale]) }}">
                        {{ $locale_name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
