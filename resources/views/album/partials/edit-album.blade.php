<div>
	@livewire('album.partials.edit-photo-modal')

	<div class="flex">
		<div>
			<input type="checkbox" wire:change="toggleAll($event.target.checked)" />
			<x-label>{{ __('display-photos.select.select') }}</x-select>
		</div>
		<div class="flex-grow"></div>
		@if($canEdit)
			<a href="#edit-album-form">{{ __('album/show.links.jump-to') }}</a>
		@endif
	</div>

	@if(count($this->photos) === 0)
		<x-card class="text-center">
			<x-slot name="content">
				<div class="mb-3 text-gray-600 text-lg">{{ __('album/show.text.no-photos') }}</div>
				<x-button wire:click="$emit('toggleUploadingPhotosModal')">{{ __('album/show.links.upload-photos') }}</x-button>
			</x-slot>
		</x-card>
	@else
		<div class="flex flex-col space-y-5">
			@foreach($this->photos as $date => $group)
				<div>
					<div class="mt-1 px-6 text-gray-600 text-2xl sm:px-0">{{ $date }}</div>
					<div class="gap-5 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
						@foreach($group as $photo)
						<x-card class="col-span-1
							{{ $selectedPhotos->count() === 0 || $selectedPhotos->contains('id', $photo->id) ? '' : 'opacity-50 hover:opacity-75' }}"
						>
								<x-slot name="image">
									<div class="bg-center bg-cover bg-no-repeat cursor-pointer h-32 relative w-full"
										style="background-image:url({{ $photo->photoUrl }})"
										wire:click="$emit('startEditingPhoto', {{ $photo }})"
									>
										<button class="absolute bg-white block leading-none left-0 ml-2 mt-2 p-1 rounded shadow top-0" wire:click.stop="togglePhoto({{ $photo }})">
											<input name="selectedPhotos[]" type="checkbox" @if($selectedPhotos->contains('id', $photo->id)) checked @endif" />
										</button>
									</div>
								</x-slot>
							</x-card>
						@endforeach
					</div>
				</div>
			@endforeach
		</div>
	@endif

	@if($count < $total)
		<x-secondary-button class="justify-center mt-5 text-base w-full" wire:click="loadMorePhotos" wire:target="loadMorePhotos" wire:loading.attr="disabled">
			<span wire:loading wire:target="loadMorePhotos"><em class="fas fa-circle-notch fa-spin"></em></span>
			<span wire:loading.remove wire:target="loadMorePhotos">{{ __('display-photos.load-more') }}</span>
		</x-secondary-button>
	@endif

	@if($canEdit)
		<hr class="my-10" />
		<div id="edit-album-form">
			@livewire('album.partials.edit-album-form', ['album' => $album])
		</div>
	@endif
</div>
