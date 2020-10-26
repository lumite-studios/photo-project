<div>
	<!-- details -->
	<x-form-section class="mb-5" submit="update">
		<x-slot name="title">{{ __('family/index.form.details.section.title') }}</x-slot>
		<x-slot name="description">{{ __('family/index.form.details.section.description') }}</x-slot>
		<x-slot name="form">
			<!-- name -->
			<div class="mb-3">
				<x-label for="name">{{ __('family/index.form.details.name') }}</x-label>
				<x-input name="name" type="text" wire:model.defer="state.name" />
				<x-input-error for="state.name" class="mt-2" />
			</div>
		</x-slot>
		<x-slot name="actions">
			<x-button disabled wire:loading wire:target="update">
				<em class="fas fa-circle-notch fa-spin"></em>
			</x-button>
			<x-button wire:loading.remove wire:target="update">
				{{ __('family/index.form.details.submit') }}
			</x-button>
		</x-slot>
	</x-form-section>

	<!-- users -->
	<x-form-section class="mb-5">
		<x-slot name="title">{{ __('family/index.form.users.section.title') }}</x-slot>
		<x-slot name="description">{{ __('family/index.form.users.section.description') }}</x-slot>
		<x-slot name="form">
			<!-- list users -->
			<div class="overflow-x-auto">
				<table>
					<thead>
						<tr>
							<th class="text-left">{{ __('family/index.form.users.table.name') }}</th>
							<th class="w-1">{{ __('family/index.form.users.table.view') }}</th>
							<th class="w-1">{{ __('family/index.form.users.table.invite') }}</th>
							<th class="w-1">{{ __('family/index.form.users.table.upload') }}</th>
							<th class="w-1">{{ __('family/index.form.users.table.edit') }}</th>
							<th class="w-1">{{ __('family/index.form.users.table.delete') }}</th>
							<th class="w-1">{{ __('family/index.form.users.table.admin') }}</th>
							<th class="w-1">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $user)
							<tr>
								<td>{{ $user['name'] }}</td>
								<td class="text-center">
									<input type="checkbox" checked disabled/>
								</td>
								<td class="text-center">
									<input type="checkbox" wire:model="users.{{ $loop->index }}.invite" @if($user->hasAllPermissions()) disabled @endif/>
								</td>
								<td class="text-center">
									<input type="checkbox" wire:model="users.{{ $loop->index }}.upload" @if($user->hasAllPermissions()) disabled @endif/>
								</td>
								<td class="text-center">
									<input type="checkbox" wire:model="users.{{ $loop->index }}.edit" @if($user->hasAllPermissions()) disabled @endif/>
								</td>
								<td class="text-center">
									<input type="checkbox" wire:model="users.{{ $loop->index }}.delete" @if($user->hasAllPermissions()) disabled @endif/>
								</td>
								<td class="text-center">
									<input type="checkbox" wire:model="users.{{ $loop->index }}.admin" @if($user->hasAllPermissions()) disabled @endif/>
								</td>
								<td class="text-center">
									<x-button size="small" disabled wire:loading wire:target="edit">
										<em class="fas fa-circle-notch fa-spin"></em>
									</x-button>
									<x-button size="small" wire:loading.remove wire:click="edit({{ $user }})" wire:target="edit">
										{{ __('family/index.form.users.submit') }}
									</x-button>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<!-- invites -->
			<div class="border border-gray-400 mt-5 overflow-hidden rounded-md">
				@if(auth()->user()->canInvite())
					<div class="flex">
						<x-input class="border-b-0 border-l-0 border-r-0 border-t-0 flex-grow rounded-none" name="invites" type="email" placeholder="{{ __('family/create.text.details.form.invites.placeholder') }}" wire:model="state.invite" />
						<x-button class="rounded-b-none rounded-l-none" disabled wire:loading wire:target="sendInvite">
							<em class="fas fa-circle-notch fa-spin"></em>
						</x-button>
						<x-button class="rounded-b-none rounded-l-none" wire:click.prevent="sendInvite" wire:loading.remove wire:target="sendInvite">
							{{ __('family/create.text.details.form.invites.submit') }}
						</x-danger-button>
					</div>
				@endif
				<div class="bg-gray-100 border-gray-400 @if(auth()->user()->canInvite()) border-t @endif px-3 py-2 shadow-sm w-full">
					@if(count($invites) !== 0)
						@foreach($invites as $invite)
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
		</x-slot>
	</x-form-section>

	<!-- danger zone -->
	@if(auth()->user()->canDelete())
		<x-form-section>
			<x-slot name="title"><span class="text-red-500">{{ __('family/index.form.danger-zone.section.title') }}</span></x-slot>
			<x-slot name="description"><span class="text-red-600">{{ __('family/index.form.danger-zone.section.description') }}</span></x-slot>
			<x-slot name="form">
				<div class="flex items-center">
					<div class="flex-grow text-gray-500">{{ __('family/index.form.danger-zone.delete.title') }}</div>
					<x-button disabled wire:loading wire:target="delete">
						<em class="fas fa-circle-notch fa-spin"></em>
					</x-button>
					<x-danger-button wire:loading.remove wire:click="delete" wire:target="delete" confirm="{{ __('family/index.form.danger-zone.confirm') }}">
						{{ __('family/index.form.danger-zone.delete.submit') }}
					</x-danger-button>
				</div>
			</x-slot>
		</x-form-section>
	@endif
</div>
