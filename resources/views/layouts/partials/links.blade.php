<x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
	{{ __('navigation.dashboard') }}
</x-nav-link>
