@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-xl bg-green-100 px-4 py-3 font-medium text-sm text-green-700']) }}>
        {{ $status }}
    </div>
@endif
