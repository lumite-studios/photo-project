<x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
	{{ __('navigation.dashboard') }}
</x-nav-link>
@if(auth()->user()->hasFamily())
	<x-nav-link href="{{ route('album.index') }}" :active="request()->routeIs('album.index') || request()->routeIs('album.create') || request()->routeIs('album.show')">
		{{ __('navigation.albums') }}
	</x-nav-link>
	<x-nav-link href="{{ route('member.index') }}" :active="request()->routeIs('member.index') || request()->routeIs('member.create') || request()->routeIs('member.show')">
		{{ __('navigation.members') }}
	</x-nav-link>
@endif
