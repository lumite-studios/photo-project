<div class="hidden sm:flex sm:items-center sm:ml-6">
	<x-dropdown align="right" width="48">
		<x-slot name="trigger">
			<button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
				<img class="h-8 w-8 rounded-full object-cover" src="{{ auth()->user()->photo_url }}" alt="{{ auth()->user()->name }}" />
			</button>
		</x-slot>

		<x-slot name="content">
			<!-- manage account -->
			<x-dropdown-title>{{ __('Manage Account') }}</x-dropdown-title>
			<x-dropdown-link href="{{ route('album.index') }}">
				{{ __('profile/index.title') }}
			</x-jet-dropdown-link>
			<div class="border-t border-gray-100"></div>
			<!-- manage families -->
			<x-dropdown-title>{{ __('Manage families') }}</x-dropdown-title>
			@if(auth()->user()->hasFamily())
				<x-dropdown-link href="{{ route('family.show', ['family_id' => auth()->user()->currentFamily->id]) }}">
					{{ __('family/show.title') }}
				</x-dropdown-link>
			@endif
			<x-dropdown-link href="{{ route('family.create') }}">
				{{ __('family/create.title') }}
			</x-dropdown-link>
			<div class="border-t border-gray-100"></div>
			<!-- switch family -->
			@if(auth()->user()->hasFamily())
				<x-dropdown-title>{{ __('switch family') }}</x-dropdown-title>
                <div class="border-t border-gray-100"></div>
			@endif
			<!-- logout -->
			<form method="POST" action="{{ route('logout') }}">
				@csrf
				<x-dropdown-link href="{{ route('logout') }}"
									onclick="event.preventDefault();
												this.closest('form').submit();">
					{{ __('Logout') }}
				</x-dropdown-link>
			</form>
		</x-slot>
	</x-dropdown>
</div>
