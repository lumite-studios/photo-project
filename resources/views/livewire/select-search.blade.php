<div class="relative">
	<x-input
		type="search"
		class="rounded-b-none rounded-l-none rounded-r-none rounded-t-none"
		placeholder="{{ __('livewire/select-search.search') }}"
		wire:model="query"
	/>

	@if(!empty($query))
		<div class="absolute bg-white list-group rounded-t-none shadow-lg text-sm w-full z-10">
			@if($options->count() > 0)
				@foreach($options as $option)
					<div class="list-item px-2 py-1 hover:bg-gray-100" wire:click="selectOption({{ $option->id }})">{{ $option[$term] }}</div>
				@endforeach
			@endif
		</div>
	@endif
</div>
