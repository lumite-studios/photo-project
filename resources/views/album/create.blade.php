<div>
	<x-form-section submit="create">
		<x-slot name="title">{{ __('album/create.form.section.name') }}</x-slot>
		<x-slot name="description">{{ __('album/create.form.section.description') }}</x-slot>

		<x-slot name="form">
			<h3 class="mb-3 text-xl">
				<strong>{{ __('album/create.text.creating-album') }}:</strong>
				{{ auth()->user()->currentFamily->name }}
			</h3>
			<!-- cover photo -->
			<div class="mb-3">
				<x-label for="cover_photo">{{ __('album/create.form.cover_photo') }}</x-label>
				<x-input type="file" wire:model.defer="state.cover_photo" />
				<x-input-error for="cover_photo" class="mt-2" />
			</div>
			<!-- name -->
			<div class="mb-3">
				<x-label for="name">{{ __('album/create.form.name') }}</x-label>
				<x-input id="name" type="text" wire:model.defer="state.name" autofocus />
				<x-input-error for="state.name" class="mt-2" />
			</div>
			<!-- description -->
			<div>
				<x-label for="description">{{ __('album/create.form.description') }}</x-label>
				<x-input id="description" type="text" wire:model.defer="state.description" autofocus />
				<x-input-error for="state.description" class="mt-2" />
			</div>
		</x-slot>

		<x-slot name="actions">
			<x-button>{{ __('album/create.form.submit') }}</x-button>
		</x-slot>
	</x-form-section>
</div>
