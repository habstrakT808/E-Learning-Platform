@php
    $value = old('settings.' . $key, $setting->value ?? '');
    $type = $type ?? $setting->type ?? 'text';
    $options = $options ?? [];
@endphp

<div class="mb-3">
    <label for="{{ $key }}" class="form-label">
        {{ $setting->display_name ?? ucwords(str_replace('_', ' ', $key)) }}
        @if($setting->is_public ?? false)
            <span class="badge bg-info">Public</span>
        @endif
    </label>

    @switch($type)
        @case('textarea')
            <textarea 
                name="settings[{{ $key }}]" 
                id="{{ $key }}" 
                class="form-control @error('settings.' . $key) is-invalid @enderror" 
                rows="3"
            >{{ $value }}</textarea>
            @break

        @case('boolean')
            <div class="form-check form-switch">
                <input 
                    type="checkbox" 
                    name="settings[{{ $key }}]" 
                    id="{{ $key }}" 
                    class="form-check-input @error('settings.' . $key) is-invalid @enderror" 
                    value="1" 
                    {{ $value ? 'checked' : '' }}
                >
                <label class="form-check-label" for="{{ $key }}">Enable</label>
            </div>
            @break

        @case('color')
            <input 
                type="color" 
                name="settings[{{ $key }}]" 
                id="{{ $key }}" 
                class="form-control form-control-color @error('settings.' . $key) is-invalid @enderror" 
                value="{{ $value }}"
            >
            @break

        @case('file')
            @if($value)
                <div class="mb-2">
                    <img src="{{ Storage::url($value) }}" alt="{{ $key }}" class="img-thumbnail" style="max-height: 100px;">
                </div>
            @endif
            <input 
                type="file" 
                name="{{ $key }}" 
                id="{{ $key }}" 
                class="form-control @error($key) is-invalid @enderror"
            >
            @break

        @case('select')
            <select 
                name="settings[{{ $key }}]" 
                id="{{ $key }}" 
                class="form-select @error('settings.' . $key) is-invalid @enderror"
            >
                @foreach($options as $optionValue => $optionLabel)
                    <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}>
                        {{ $optionLabel }}
                    </option>
                @endforeach
            </select>
            @break

        @case('password')
            <input 
                type="password" 
                name="settings[{{ $key }}]" 
                id="{{ $key }}" 
                class="form-control @error('settings.' . $key) is-invalid @enderror" 
                value="{{ $value }}"
            >
            @break

        @default
            <input 
                type="{{ $type }}" 
                name="settings[{{ $key }}]" 
                id="{{ $key }}" 
                class="form-control @error('settings.' . $key) is-invalid @enderror" 
                value="{{ $value }}"
            >
    @endswitch

    @if($setting->description ?? false)
        <div class="form-text">{{ $setting->description }}</div>
    @endif

    @error('settings.' . $key)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@push('settings_scripts')
<style>
    /* Toggle Switch */
    .toggle-checkbox:checked {
        right: 0;
        border-color: #68D391;
    }
    .toggle-checkbox:checked + .toggle-label {
        background-color: #68D391;
    }
</style>
@endpush 