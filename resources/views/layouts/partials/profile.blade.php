<div class="flex items-center ml-5">
	<x-dropdown align="right" width="48">
		<x-slot name="trigger">
			<button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
				<img class="h-8 w-8 rounded-full object-cover" src="{{ auth()->user()->photo_url }}" alt="{{ auth()->user()->name }}" />
			</button>
		</x-slot>

		<x-slot name="content">
			<!-- manage account -->
			<x-dropdown-title>{{ __('navigation.profile.manage-account') }}</x-dropdown-title>
			<x-dropdown-link href="{{ route('album.index') }}">
				{{ __('profile/index.title') }}
			</x-dropdown-link>
			<div class="border-t border-gray-200"></div>
			<!-- manage families -->
			<x-dropdown-title>{{ __('navigation.profile.manage-families') }}</x-dropdown-title>
			@if(auth()->user()->hasFamily() && auth()->user()->canAdmin())
				<x-dropdown-link href="{{ route('family.index') }}">
					{{ __('family/index.title') }}
				</x-dropdown-link>
			@endif
			<x-dropdown-link href="{{ route('family.create') }}">
				{{ __('family/create.title') }}
			</x-dropdown-link>
			<div class="border-t border-gray-200"></div>
			<!-- switch family -->
			@if(auth()->user()->hasFamily())
				<x-dropdown-title>{{ __('navigation.profile.switch-family') }}</x-dropdown-title>
                @foreach (auth()->user()->families as $family)
					<x-switch-family :family="$family"></x-switch-family>
				@endforeach
                <div class="border-t border-gray-200"></div>
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
