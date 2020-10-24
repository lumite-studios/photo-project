<div>
	@if(count($this->photos) === 0)
		<x-card class="text-center">
			<x-slot name="content">
				<div class="mb-3 text-gray-600 text-lg">{{ __('album/show.text.no-photos') }}</div>
				<x-button wire:click="$emit('toggleUploadingPhotosModal')">{{ __('album/show.links.upload-photos') }}</x-button>
			</x-slot>
		</x-card>
	@else
		<div class="flex flex-col space-y-5">
			@foreach($this->photos as $date => $group)
				<div>
					<div class="mt-1 px-6 text-gray-600 text-2xl sm:px-0">{{ $date }}</div>
					<div class="gap-5 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
						@foreach($group as $photo)
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
				</div>
			@endforeach
		</div>
	@endif

	@if($count < $total)
		<x-secondary-button class="justify-center mt-5 text-base w-full" wire:click="loadMorePhotos" wire:target="loadMorePhotos" wire:loading.attr="disabled">
			<span wire:loading wire:target="loadMorePhotos"><em class="fas fa-circle-notch fa-spin"></em></span>
			<span wire:loading.remove wire:target="loadMorePhotos">{{ __('member/show.links.load-more') }}</span>
		</x-secondary-button>
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
