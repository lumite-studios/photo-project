@props(['confirm' => 'Are you sure?'])

<button {{ $attributes->merge([
	'type' => 'submit',
	'class' => 'inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 active:bg-red-600 focus:outline-none focus:border-red-600 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150'
]) }} onclick="confirm('{{ $confirm }}') || event.stopImmediatePropagation()">
    {{ $slot }}
</button>
