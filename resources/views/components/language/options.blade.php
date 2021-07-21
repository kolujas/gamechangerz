<ul class="languages options grid grid-cols-4 lg:grid-cols-6 2xl:grid-cols-8 gap-4">
    @foreach ($languages as $language)
        <li class="language option" title="{{ $language->name }}">
            <input id="language-{{ $language->slug }}" type="checkbox" class="languages-form form-input" @foreach ($user->languages as $language_checked)
                @if ($language_checked->id_language === $language->id_language)
                    checked
                @endif
            @endforeach name="languages[]" value="{{ $language->slug }}">
            <label for="language-{{ $language->slug }}">
                <main class="grid">
                    @component('components.svg.' . $language->icon)
                    @endcomponent
                </main>
            </label>
        </li>
    @endforeach
</ul>
@if ($errors->has('languages'))
    <span class="color-white error support languages-form support-box overpass my-6 support-languages block">{{ $errors->first('languages') }}</span>
@else
    <span class="color-white error support languages-form support-box overpass my-6 support-languages block"></span>
@endif