<div>
	<!-- details -->
	<x-form-section class="mb-5" submit="update">
		<x-slot name="title">{{ __('album/show.form.edit-album.details.section.title') }}</x-slot>
		<x-slot name="description">{{ __('album/show.form.edit-album.details.section.description') }}</x-slot>
		<x-slot name="form">
			<!-- name -->
			<div class="mb-3">
				<x-label for="name">{{ __('album/show.form.edit-album.details.name') }}</x-label>
				<x-input name="name" type="text" wire:model.defer="state.name" />
				<x-input-error for="state.name" class="mt-2" />
			</div>
			<!-- description -->
			<div class="mb-3">
				<x-label for="description">{{ __('album/show.form.edit-album.details.description') }}</x-label>
				<x-input name="description" type="text" wire:model.defer="state.description" />
				<x-input-error for="state.description" class="mt-2" />
			</div>
			<!-- duplicate check -->
			<div>
				<input name="duplicate_check" type="checkbox" wire:model.defer="state.duplicate_check" />
				<x-label for="duplicate_check">{{ __('album/show.form.edit-album.details.duplicate_check.title') }}</x-label>
				<div class="text-gray-500 text-sm">{{ __('album/show.form.edit-album.details.duplicate_check.description') }}</div>
				<x-input-error for="state.duplicate_check" class="mt-2" />
			</div>
		</x-slot>
		<x-slot name="actions">
			<x-button disabled wire:loading wire:target="update">
				<em class="fas fa-circle-notch fa-spin"></em>
			</x-button>
			<x-button wire:loading.remove wire:target="update">
				{{ __('album/show.form.edit-album.details.submit') }}
			</x-button>
		</x-slot>
	</x-form-section>
	<!-- danger zone -->
	<x-form-section submit="update">
		<x-slot name="title"><span class="text-red-500">{{ __('album/show.form.edit-album.danger-zone.section.title') }}</span></x-slot>
		<x-slot name="description"><span class="text-red-400">{{ __('album/show.form.edit-album.danger-zone.section.description') }}</span></x-slot>
		<x-slot name="form">
			<div class="flex items-center">
				<div class="flex-grow text-gray-500">{{ __('album/show.form.edit-album.danger-zone.delete-album.title') }}</div>
				<x-button disabled wire:loading wire:target="delete">
					<em class="fas fa-circle-notch fa-spin"></em>
				</x-button>
				<x-danger-button wire:loading.remove wire:click="delete" wire:target="delete">
					{{ __('album/show.form.edit-album.danger-zone.delete-album.submit') }}
				</x-danger-button>
			</div>
		</x-slot>
	</x-form-section>
</div>
