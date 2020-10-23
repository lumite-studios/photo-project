<div>
	@livewire('album.partials.edit-photo-modal')

	@if($photos->count() === 0)
		<x-card class="text-center">
			<x-slot name="content">
				<div class="mb-1">{{ __('album/show.text.no-photos') }}</div>
				<x-button wire:click="uploadPhotos()">{{ __('album/show.links.upload-photos') }}</x-button>
			</x-slot>
		</x-card>
	@else
		<div class="gap-5 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-{{ $this->amount }}">
			@foreach($photos as $photo)
				<x-card class="col-span-1
					{{ $selectedPhotos->count() === 0 || $selectedPhotos->contains('id', $photo->id) ? '' : 'opacity-50 hover:opacity-75' }}"
				>
					<x-slot name="image">
						<div class="bg-center bg-cover bg-no-repeat h-32 w-full"
							style="background-image:url({{ $photo->photoUrl }})"
						>
						</div>
					</x-slot>
					<x-slot name="footer">
						<x-secondary-button class="border-r-0 rounded-r-none" wire:click="$emit('togglePhoto', {{ $photo }})">
							<input name="selectedPhotos[]" type="checkbox" @if($selectedPhotos->contains('id', $photo->id)) checked @endif" />
						</x-secondary-button>
						<x-secondary-button class="bg-transparent flex-grow justify-center rounded-l-none" wire:click="$emit('startEditingPhoto', {{ $photo }})">
							{{ __('album/show.links.edit-photo') }}
						</x-secondary-button>
					</x-slot>
				</x-card>
			@endforeach
		</div>
	@endif

	@if($photos->hasPages())
		<div class="mt-5">
			{{ $photos->links() }}
		</div>
	@endif
</div>
