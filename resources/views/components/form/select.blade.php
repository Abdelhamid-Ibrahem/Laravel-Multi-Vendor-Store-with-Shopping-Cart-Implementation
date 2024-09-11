{{--<select--}}
{{--        name="{{ $name }}"--}}
{{--        {{ $attributes->class([--}}
{{--            'form-control',--}}
{{--            'form.select',--}}
{{--            'is-invalid' => $errors->has($name)--}}
{{--            ]) }}--}}
{{-->--}}
{{--    @foreach($options as $value => $text)--}}
{{--        <option value="{{ $value }}" @selected($value == $selected)>{{ $text }}</option>--}}
{{--    @endforeach--}}
{{--</select>--}}

<!-- Label for the select -->
<label for="{{ $name }}" class="form-label">{{ $label }}</label>
<select

        name="{{ $name }}"
        class="form-control form-select {{ $errors->has($name) ? 'is-invalid' : '' }} "
        name="{{ $name }}"
>

@foreach($options as $value => $text)
    <option value="{{ $value }}" @selected($value == $selected)>{{ $text }}</option>
    @endforeach
    </select>
    <x-form.validation-feedback :name="$name"/>
