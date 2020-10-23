<div>
	@if($hasFamily)
		<!-- albums -->
		@if($albums->count() === 0)
			<x-card>
				<x-slot name="content">
					<div class="text-center">
						<div class="text-gray-600 text-lg">{{ __('dashboard/index.text.create-album') }}</div>
						<div class="flex mt-3 justify-center">
							<a href="{{ route('album.create') }}">
								<x-button>{{ __('dashboard/index.links.create-album') }}</x-button>
							</a>
						</div>
					</div>
				</x-slot>
			</x-card>
		@else
			<!-- options -->
			<div class="flex justify-end mb-5 px-6 sm:px-0">
				<a href="/albums"><x-secondary-button class="rounded-r-none">{{ __('dashboard/index.links.all-albums') }}</x-secondary-button></a>
				<a href="/albums/create"><x-button class="rounded-l-none">{{ __('dashboard/index.links.create-album') }}</x-button></a>
			</div>
			<!-- list -->
			<div class="sm:gap-5 sm:grid sm:grid-cols-4">
				@foreach($albums as $album)
					<x-card class="col-span-1" link="{{ route('album.show', ['album_slug' => $album->slug]) }}">
						<x-slot name="image">
							<div class="bg-center bg-cover bg-no-repeat cursor-pointer h-32 w-full"
								style="background-image:url({{ $album->photoUrl }})"
							>
							</div>
						</x-slot>
						<x-slot name="content">
							<h3 class="font-bold text-xl">{{ $album->name }}</h3>
							<div class="text-gray-500 text-sm">{{ $album->description }}</div>
						</x-slot>
					</x-card>
				@endforeach
			</div>
		@endif
		<br />
		<!-- members -->
		@if($members->count() === 0)
			<x-card>
				<x-slot name="content">
					<div class="text-center">
						<div class="text-gray-600 text-lg">{{ __('dashboard/index.text.create-member') }}</div>
						<div class="flex mt-3 justify-center">
							<a href="{{ route('album.create') }}">
								<x-button>{{ __('dashboard/index.links.create-member') }}</x-button>
							</a>
						</div>
					</div>
				</x-slot>
			</x-card>
		@else
			<!-- options -->
			<div class="flex justify-end mb-5 px-6 sm:px-0">
				<a href="{{ route('member.index') }}"><x-secondary-button class="rounded-r-none">{{ __('dashboard/index.links.all-members') }}</x-secondary-button></a>
				<a href="{{ route('member.create') }}"><x-button class="rounded-l-none">{{ __('dashboard/index.links.create-member') }}</x-button></a>
			</div>
			<!-- list -->
			<div class="sm:gap-5 sm:grid sm:grid-cols-4">
				@foreach($members as $member)
					<x-card class="col-span-1" link="{{ route('member.show', ['member_id' => $member->id]) }}">
						<x-slot name="image">
							<div class="bg-center bg-cover bg-no-repeat cursor-pointer h-32 w-full"
								style="background-image:url({{ $member->photoUrl }})"
							>
							</div>
						</x-slot>
						<x-slot name="content">
							<h3 class="font-bold text-xl">{{ $member->name }}</h3>
							<div class="text-gray-500 text-sm">
								<div><strong>{{ __('dashboard/index.text.total-photos') }}:</strong> {{ $member->tags->count() }}</div>
							</div>
						</x-slot>
					</x-card>
				@endforeach
			</div>
		@endif
	@else
		<x-card>
			<x-slot name="content">
				<div class="text-center">
					<div class="mb-3 text-gray-600 text-lg">{{ __('dashboard/index.text.create-family') }}</div>
					<div class="flex justify-center">
						<a href="{{ route('family.create') }}">
							<x-button class="rounded-r-none">{{ __('dashboard/index.links.create-family') }}</x-button>
						</a>
						<x-secondary-button class="rounded-l-none">{{ __('dashboard/index.links.join-family') }}</x-secondary-button>
					</div>
				</div>
			</x-slot>
		</x-card>
	@endif
</div>
