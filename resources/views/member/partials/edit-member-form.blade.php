<div>
	<!-- details -->
	@if(auth()->user()->canEdit())
		<x-form-section class="mb-5" submit="update">
			<x-slot name="title">{{ __('member/show.form.edit-member.details.section.title') }}</x-slot>
			<x-slot name="description">{{ __('member/show.form.edit-member.details.section.description') }}</x-slot>
			<x-slot name="form">
				<!-- name -->
				<div class="mb-3">
					<x-label for="name">{{ __('member/show.form.edit-member.details.name') }}</x-label>
					<x-input name="name" type="text" wire:model.defer="state.name" />
					<x-input-error for="state.name" class="mt-2" />
				</div>
				<!-- description -->
				<div class="mb-3">
					<x-label for="description">{{ __('member/show.form.edit-member.details.description') }}</x-label>
					<x-input name="description" type="text" wire:model.defer="state.description" />
					<x-input-error for="state.description" class="mt-2" />
				</div>
			</x-slot>
			<x-slot name="actions">
				<x-button disabled wire:loading wire:target="update">
					<em class="fas fa-circle-notch fa-spin"></em>
				</x-button>
				<x-button wire:loading.remove wire:target="update">
					{{ __('member/show.form.edit-member.details.submit') }}
				</x-button>
			</x-slot>
		</x-form-section>
	@endif

	<!-- danger zone -->
	@if(auth()->user()->canDelete())
		<x-form-section submit="delete">
			<x-slot name="title"><span class="text-red-500">{{ __('member/show.form.edit-member.danger-zone.section.title') }}</span></x-slot>
			<x-slot name="description"><span class="text-red-600">{{ __('member/show.form.edit-member.danger-zone.section.description') }}</span></x-slot>
			<x-slot name="form">
				<div class="flex items-center">
					<div class="flex-grow text-gray-500">{{ __('member/show.form.edit-member.danger-zone.delete.title') }}</div>
					<x-button disabled wire:loading wire:target="delete">
						<em class="fas fa-circle-notch fa-spin"></em>
					</x-button>
					<x-danger-button wire:loading.remove wire:target="delete">
						{{ __('member/show.form.edit-member.danger-zone.delete.submit') }}
					</x-danger-button>
				</div>
			</x-slot>
		</x-form-section>
	@endif
</div>
