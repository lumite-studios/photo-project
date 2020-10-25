<nav x-data="{ open: false }" class="bg-white border-b border-gray-200">
	<!-- desktop navigation menu -->
	<div class="max-w-7xl mx-auto px-6">
		<div class="flex h-16">
			<!-- links -->
			<div class="hidden space-x-6 sm:-my-px sm:flex">
				@include('layouts.partials.links')
			</div>
			<div class="flex-grow"></div>
			<!-- profile -->
			@include('layouts.partials.profile')
		</div>
	</div>
</nav>
