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
		<div class="mt-5">
			{{ $photos->links() }}
		</div>
	@endif

	<!-- viewing photo modal -->
	<x-dialog-modal wire:model="showViewingPhotoModal">
		@if($viewPhoto)
			<x-slot name="image"><img src="{{ $viewPhoto->photoUrl }}" /></x-slot>

			@if($viewPhoto->description != null)
				<x-slot name="content">
					<div class="italic text-center text-gray-500 text-sm">
						{{ $viewPhoto->description }}
					</div>
				</x-slot>
			@endif
		@endif
	</x-dialog-modal>
</div>
