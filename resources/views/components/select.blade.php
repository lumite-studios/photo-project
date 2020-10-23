@props(['disabled' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-white border border-gray-400 px-3 py-2 rounded-md shadow-sm w-full']) !!}>
	{{ $slot }}
</select>
