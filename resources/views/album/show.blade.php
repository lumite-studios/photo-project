<div>
	<!-- meta -->
	<div class="flex items-end mb-5 px-5 sm:px-0">
		<!-- sort -->
		@if($selectedPhotos->count() === 0)
			<div>
				<x-label for="meta.paginate.value">Per Page</x-label>
				<x-select name="meta.paginate.value" wire:model="meta.paginate.value" wire:change="$emit('updatePaginate', $event.target.value)">
					@foreach($meta['paginate']['options'] as $val)
						<option value="{{ $val }}">{{ $val }}</option>
					@endforeach
				</x-select>
			</div>
		@else
		<!-- selected -->
			selected
		@endif
		<div class="flex-grow"></div>
		<!-- options -->
		<x-secondary-button class="{{ $canUpload ? 'rounded-r-none' : null }}" wire:click="toggleEditing" wire:target="toggleEditing" wire:loading.attr="disabled">
			<span wire:loading wire:target="toggleEditing"><em class="fas fa-circle-notch fa-spin"></em></span>
			<span wire:loading.remove wire:target="toggleEditing">
				@if($editing)
					{{ __('album/show.links.view-album') }}
				@else
					{{ __('album/show.links.edit-album') }}
				@endif
			</span>
		</x-secondary-button>
		@if($canUpload)
			<x-button class="rounded-l-none" wire:click="toggleUploadingPhotosModal()">
				{{ __('album/show.links.upload-photos') }}
			</x-button>
		@endif
	</div>

	<!-- view -->
	@if($editing)
		@livewire('album.partials.edit-album', ['album' => $album, 'amount' => $amount, 'total' => $meta['paginate']['value']])
	@else
		@livewire('album.partials.view-album', ['album' => $album, 'amount' => $amount, 'total' => $meta['paginate']['value']])
	@endif

	<!-- uploading photos modal -->
	<x-dialog-modal wire:model="showUploadingPhotosModal">
		<x-slot name="title">{{ __('album/show.links.upload-photos') }}</x-slot>
		<x-slot name="content">
			<x-input type="file" wire:model.defer="state.photos" multiple />
			<x-input-error for="state.photos" class="mt-2" />
		</x-slot>
		<x-slot name="footer">
			<x-button disabled wire:loading>
				<i class="fas fa-circle-notch fa-spin"></i>
			</x-button>
			<div wire:loading.remove>
				<x-button wire:click="upload">
					{{ __('album/show.modals.upload-photos.submit') }}
				</x-button>
			</div>
		</x-slot>
	</x-dialog-modal>
</div>
