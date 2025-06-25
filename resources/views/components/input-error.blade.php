@props(['messages'])

@if ($messages)
    <div {{ $attributes->merge(['class' => 'text-sm text-red-600 bg-red-50 rounded-md px-3 py-2 border-l-2 border-red-400']) }}>
        <ul class="list-disc pl-5 space-y-1">
            @foreach ((array) $messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
