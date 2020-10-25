@props(['family', 'component' => 'dropdown-link'])

<form method="POST" action="{{ route('family.update', ['family_id' => $family->id]) }}">
	@method('patch')
	@csrf

	<x-dynamic-component :component="$component" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
		<div class="flex items-center">
			@if(auth()->user()->isCurrentFamily($family))
				<svg class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
			@endif

			<div class="truncate">{{ $family->name }}</div>
		</div>
	</x-dynamic-component>
</form>
