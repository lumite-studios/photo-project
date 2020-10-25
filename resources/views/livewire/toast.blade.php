<div class="bottom-0 fixed m-5 p-3 rounded shadow text-sm {{ $classes[$type] }}"
	x-data="{ show: false }"
	@toast-message-show.window="show = true; setTimeout(() => show=false, 5000);"
	x-show="show"
	x-cloak
>
	{!! $message !!}
</div>
