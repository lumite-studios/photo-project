<div>
	@if($hasFamily)
		<!-- options -->
		<div class="flex justify-end mb-5 px-6 sm:px-0">
			<a href="{{ route('album.index') }}"><x-secondary-button class="{{ auth()->user()->canUpload() ? 'rounded-r-none' : null }}">{{ __('album/index.title') }}</x-secondary-button></a>
			@if(auth()->user()->canUpload())
				<a href="{{ route('album.create') }}"><x-button class="rounded-l-none">{{ __('album/create.title') }}</x-button></a>
			@endif
		</div>
		<!-- albums -->
		@if($albums->count() === 0)
			<x-card>
				<x-slot name="content">
					<div class="text-center">
						<div class="text-gray-600 text-lg">{{ __('dashboard/index.text.create-album') }}</div>
						<div class="flex mt-3 justify-center">
							<a href="{{ route('album.create') }}">
								<x-button>{{ __('album/create.title') }}</x-button>
							</a>
						</div>
					</div>
				</x-slot>
			</x-card>
		@else
			<!-- list -->
			<div class="gap-5 grid grid-cols-2 md:grid-cols-4">
				@foreach($albums as $album)
					<x-card class="col-span-1" link="{{ route('album.show', ['album_slug' => $album->slug]) }}">
						<x-slot name="image">
							<div class="bg-center bg-cover bg-no-repeat cursor-pointer h-32 w-full"
								style="background-image:url({{ $album->photoUrl }})"
							>
							</div>
						</x-slot>
						<x-slot name="content">
							<h3 class="flex items-center">
								<div class="flex-grow font-bold text-xl">{{ $album->name }}</div>
								<div>{{ $album->photos->count() }}</div>
							</h3>
							<div class="text-gray-500 text-sm">{{ $album->description }}</div>
						</x-slot>
					</x-card>
				@endforeach
			</div>
		@endif
		<!-- options -->
		<div class="flex justify-end my-5 px-6 sm:px-0">
			<a href="{{ route('member.index') }}"><x-secondary-button class="{{ auth()->user()->canUpload() ? 'rounded-r-none' : null }}">{{ __('member/index.title') }}</x-secondary-button></a>
			@if(auth()->user()->canUpload())
				<a href="{{ route('member.create') }}"><x-button class="rounded-l-none">{{ __('member/create.title') }}</x-button></a>
			@endif
		</div>
		<!-- members -->
		@if($members->count() === 0)
			<x-card>
				<x-slot name="content">
					<div class="text-center">
						<div class="text-gray-600 text-lg">{{ __('dashboard/index.text.create-member') }}</div>
						<div class="flex mt-3 justify-center">
							<a href="{{ route('album.create') }}">
								<x-button>{{ __('member/create.title') }}</x-button>
							</a>
						</div>
					</div>
				</x-slot>
			</x-card>
		@else
			<!-- list -->
			<div class="gap-5 grid grid-cols-2 md:grid-cols-4">
				@foreach($members as $member)
					<x-card class="col-span-1" link="{{ route('member.show', ['member_id' => $member->id]) }}">
						<x-slot name="image">
							<div class="bg-center bg-cover bg-no-repeat cursor-pointer h-32 w-full"
								style="background-image:url({{ $member->photoUrl }})"
							>
							</div>
						</x-slot>
						<x-slot name="content">
							<h3 class="flex items-center">
								<div class="flex-grow font-bold text-xl">{{ $member->name }}</div>
								<div>{{ $member->photos->count() }}</div>
							</h3>
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
							<x-button class="rounded-r-none">{{ __('family/create.title') }}</x-button>
						</a>
						<x-secondary-button class="rounded-l-none">{{ __('dashboard/index.links.join-family') }}</x-secondary-button>
					</div>
				</div>
			</x-slot>
		</x-card>
	@endif
</div>
