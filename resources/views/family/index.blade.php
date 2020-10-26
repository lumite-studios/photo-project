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
