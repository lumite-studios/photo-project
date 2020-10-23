@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-5']) }}>
	<div class="md:col-span-1">
		<div class="px-5 sm:px-0">
			<h3 class="font-medium text-gray-900 text-lg">{{ $title }}</h3>
			<div class="mt-1 text-gray-600 text-sm">{{ $description }}</div>
		</div>
	</div>

	<div class="mt-5 md:mt-0 md:col-span-2">
		<form wire:submit.prevent="{{ $submit }}">
			<x-card>
				<x-slot name="content">{{ $form }}</x-slot>
				@if(isset($actions))
					<x-slot name="footer">{{ $actions }}</x-slot>
				@endif
			</x-card>
		</form>
	</div>
</div>
