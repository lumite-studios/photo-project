<div>
	<!-- details -->
	<x-form-section submit="create">
		<x-slot name="title">{{ __('family/create.text.details.section.title') }}</x-slot>
		<x-slot name="description">{{ __('family/create.text.details.section.description') }}</x-slot>
		<x-slot name="form">
			<!-- name -->
			<div class="mb-3">
				<x-label>{{ __('family/create.text.details.form.name') }}</x-label>
				<x-input name="name" type="text" wire:model="state.name" />
			</div>
			<!-- invites -->
			<div>
				<x-label>{{ __('family/create.text.details.form.invites.title') }}</x-label>
				<div class="border border-gray-400 overflow-hidden rounded-md">
					<div class="flex">
						<x-input class="border-b-0 border-l-0 border-r-0 border-t-0 flex-grow rounded-none" name="invites" type="email" placeholder="{{ __('family/create.text.details.form.invites.placeholder') }}" wire:model="invite" />
						<x-button class="rounded-b-none rounded-l-none" wire:click.prevent="addInvite">{{ __('family/create.text.details.form.invites.submit') }}</x-button>
					</div>

					<div class="bg-gray-100 border-gray-400 border-t px-3 py-2 shadow-sm w-full">
						@if(count($state['invites']) !== 0)
							@foreach($state['invites'] as $invite)
								<div class="flex items-center space-x-3">
									<button class="cursor-pointer font-bold text-red-500" wire:click.prevent="removeInvite('{{ $invite }}')">
										<em class="fas fa-times"></em>
									</button>
									<div class="flex-grow text-gray-600 text-sm">{{ $invite }}</div>
								</div>
							@endforeach
						@else
							<div class="text-center text-sm">{{ __('family/create.text.details.form.invites.none') }}</div>
						@endif
					</div>
				</div>
				<x-input-error for="invite" />
			</div>
		</x-slot>
		<x-slot name="actions">
			<x-button>{{ __('family/create.text.details.form.submit') }}</x-button>
		</x-slot>
	</x-form-section>
</div>
