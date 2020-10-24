<div>
	<!-- meta -->
	<div class="sm:flex items-end mb-5 px-5 sm:px-0">
		<div class="flex items-center space-x-2">
			<!-- sort -->
			<div>
				<x-label for="sort">{{ __('display-photos.sort.title') }}</x-label>
				<x-select name="sort" wire:model="meta.sort.value" wire:change="$emit('updateMeta', 'sort', $event.target.value)">
					@foreach($meta['sort']['options'] as $key => $value)
						<option value="{{ $key }}">{{ __('display-photos.sort.options.'.$value) }}</option>
					@endforeach
				</x-select>
			</div>
			<!-- group -->
			<div>
				<x-label for="group">{{ __('display-photos.group.title') }}</x-label>
				<x-select name="group" wire:model="meta.group.value" wire:change="$emit('updateMeta', 'group', $event.target.value)">
					@foreach($meta['group']['options'] as $value)
						<option value="{{ $value }}">{{ __('display-photos.group.options.'.$value) }}</option>
					@endforeach
				</x-select>
			</div>
			<!-- selected -->
			@if($selectedPhotos->count() > 0)
				<div>
					<x-label>{{ $selectedPhotos->count() }} <span class="font-normal">{{ __('display-photos.selected.title') }}</span></x-label>
					<div class="flex">
						<x-select class="flex-grow rounded-r-none">
							@foreach($meta['selected']['options'] as $value)
								<option value="{{ $value }}" @if($value === 'none') disabled selected @endif>{{ __('display-photos.selected.options.'.$value) }}</option>
							@endforeach
						</x-select>
						<x-button class="rounded-l-none"><em class="fas fa-check"></em></x-button>
					</div>
				</div>
			@endif
		</div>
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
		@livewire('album.partials.edit-album', ['album' => $album])
	@else
		@livewire('album.partials.view-album', ['album' => $album])
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
