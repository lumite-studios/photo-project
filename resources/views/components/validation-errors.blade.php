@if($errors->any())
    <div {{ $attributes->merge(['class' => 'bg-red-500 p-3 rounded shadow-sm text-white']) }}>
        <div class="font-bold">{{ __('validation.title') }}</div>
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
