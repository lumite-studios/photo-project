<div>
	@if($photos->total() === 0)
		<x-card class="text-center">
			<x-slot name="content">
				<div class="mb-3 text-gray-600 text-lg">{{ __('album/show.text.no-photos') }}</div>
				<x-button wire:click="$emit('toggleUploadingPhotosModal')">{{ __('album/show.links.upload-photos') }}</x-button>
			</x-slot>
		</x-card>
	@else
		<div class="gap-5 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-{{ $this->amount }}">
			@foreach($photos as $photo)
				<x-card>
					<x-slot name="image">
						<div class="bg-center bg-cover bg-no-repeat cursor-pointer h-32 w-full"
							style="background-image:url({{ $photo->photoUrl }})"
							wire:click="toggleViewingPhotoModal({{ $photo }})"
						>
						</div>
					</x-slot>
				</x-card>
			@endforeach
		</div>
	@endif

	@if($photos->hasPages())
		<div class="mt-5 px-5 sm:px-0">
			{{ $photos->links() }}
		</div>
	@endif

	<!-- viewing photo modal -->
	<x-dialog-modal wire:model="showViewingPhotoModal">
		@if($viewPhoto)
			<x-slot name="image">
				<x-photo-tagging>
					<x-slot name="image"><img src="{{ $viewPhoto->photoUrl }}" /></x-slot>
					<!-- tags -->
					@foreach($viewPhoto->tags as $tag)
						<div
							class="absolute bg-black flex items-center px-2 py-1 opacity-50 rounded shadow text-white toggle-on-hover hover:opacity-100"
							style="left:{{ $tag['left'] }}%; top:{{ $tag['top'] }}%;"
						>
							<div class="flex-grow">{{ $tag->member->name }}</div>
						</div>
					@endforeach
				</x-photo-tagging>
			</x-slot>

			<x-slot name="content">
				<div class="text-center">
					<div class="text-gray-600 text-lg">{{ $viewPhoto->name }}</div>
					@if($viewPhoto->description != null)
						<div class="italic mt-3 text-center text-gray-500 text-sm">{{ $viewPhoto->description }}</div>
					@endif
				</div>
			</x-slot>
		@endif
	</x-dialog-modal>
</div>
