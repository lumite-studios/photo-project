@props(['size' => 'base'])

@php
$class = 'inline-flex items-center bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150';
switch ($size) {
    case 'base':
        $class = $class.' px-4 py-2';
        break;
    case 'small':
        $class = $class.' px-2 py-1';
        break;
        break;
}
@endphp
<button {{ $attributes->merge([
	'type' => 'submit',
	'class' => $class
]) }}>
    {{ $slot }}
</button>
