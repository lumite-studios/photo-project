<x-dialog-modal wire:model="showEditingPhotoModal">
	@if($photo)
		<x-slot name="image">
			<x-photo-tagging allowCreateTag="1">
				<x-slot name="image"><img src="{{ $photo->photoUrl }}" /></x-slot>
				<!-- tags -->
				@foreach($photo->tags as $tag)
					<div
						class="absolute bg-black flex items-center px-2 py-1 opacity-50 rounded shadow text-white toggle-on-hover hover:opacity-100"
						style="left:{{ $tag['left'] }}%; top:{{ $tag['top'] }}%;"
					>
						<div class="flex-grow">{{ $tag->member->name }}</div>
						<button class="ml-2 text-xs toggle" wire:click="deleteTag({{ $tag }})"><em class="fas fa-times"></em></button>
					</div>
				@endforeach
				<!-- new tag -->
				@if($newTag)
					<div class="bg-white absolute flex px-1 py-1 rounded shadow text-gray-500 w-64" style="left:{{ $newTag['left'] }}%;; top:{{ $newTag['top'] }}%;">
						@livewire('livewire.select-search', ['options' => $members])
						<x-button class="pl-2 pr-2 rounded-l-none rounded-r-none" wire:click="createTag"><em class="fas fa-check"></em></x-button>
						<x-danger-button class="pl-2 pr-2 rounded-l-none" wire:click="closeNewTag"><em class="fas fa-times"></em></x-danger-button>
					</div>
				@endif
			</x-photo-tagging>
		</x-slot>
		<x-slot name="content">
			<!-- name -->
			<div class="mb-3">
				<x-label for="name">{{ __('album/show.modals.edit-photo.name') }}</x-label>
				<x-input id="name" type="text" wire:model="state.name" />
				<x-input-error for="state.name" />
			</div>
			<!-- description -->
			<div class="mb-3">
				<x-label for="description">{{ __('album/show.modals.edit-photo.description') }}</x-label>
				<x-input id="description" type="text" wire:model="state.description" />
				<x-input-error for="state.description" />
			</div>
			<!-- date taken -->
			<div class="mb-3">
				<x-label for="date_taken">{{ __('album/show.modals.edit-photo.date_taken') }}</x-label>
				<x-input id="date_taken" type="datetime-local" wire:model="state.date_taken" />
				<x-input-error for="state.date_taken" />
			</div>
			<!-- cover photo -->
			<div class="text-center">
				<input name="cover_photo" type="checkbox" wire:model="state.cover_photo" />
				<x-label for="cover_photo">{{ __('album/show.modals.edit-photo.cover_photo') }}</x-label>
				<x-input-error for="state.cover_photo" />
			</div>
		</x-slot>
		<x-slot name="footer">
			<x-button wire:click="save">Save Changes</x-button>
		</x-slot>
	@endif
</x-dialog-modal>
