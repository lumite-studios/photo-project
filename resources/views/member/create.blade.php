<div>
	<x-form-section submit="create">
		<x-slot name="title">{{ __('member/create.form.section.name') }}</x-slot>
		<x-slot name="description">{{ __('member/create.form.section.description') }}</x-slot>

		<x-slot name="form">
			<h3 class="mb-3 text-xl">
				<strong>{{ __('member/create.text.creating-member') }}:</strong>
				{{ auth()->user()->currentFamily->name }}
			</h3>
			<!-- name -->
			<div class="mb-3">
				<x-label for="name">{{ __('member/create.form.name') }}</x-label>
				<x-input id="name" type="text" wire:model.defer="state.name" autofocus />
				<x-input-error for="state.name" class="mt-2" />
			</div>
			<!-- description -->
			<div class="mb-3">
				<x-label for="description">{{ __('member/create.form.description') }}</x-label>
				<x-input name="description" type="text" wire:model.defer="state.description" />
				<x-input-error for="state.description" class="mt-2" />
			</div>
			<!-- birthday -->
			<div class="mb-3">
				<x-label for="birthday">{{ __('member/create.form.birthday') }}</x-label>
				<x-input name="birthday" type="date" wire:model.defer="state.birthday" placeholder="dd/mm/yyyy" />
				<x-input-error for="state.birthday" class="mt-2" />
			</div>
		</x-slot>

		<x-slot name="actions">
			<x-button>{{ __('member/create.form.submit') }}</x-button>
		</x-slot>
	</x-form-section>
</div>
