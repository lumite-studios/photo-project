<div>
	<!-- albums -->
	@if($this->albums->count() === 0)
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
			<a href="{{ route('album.create') }}"><x-button>{{ __('album/create.title') }}</x-button></a>
		</div>
		<!-- list -->
		<div class="gap-5 grid grid-cols-2 md:grid-cols-4">
			@foreach($this->albums as $album)
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

		@if($this->albums->hasPages())
			<div class="mt-5">
				{{ $this->albums->links() }}
			</div>
		@endif
	@endif
</div>
