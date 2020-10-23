@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
	{{ $image ?? '' }}

	@if($content ?? null)
		<div class="px-6 py-3">
			@if($title ?? null)
				<div class="mb-3 text-lg">
					{{ $title ?? '' }}
				</div>
			@endif

			{{ $content ?? '' }}
		</div>
	@endif

	@if($footer ?? null)
		<div class="px-6 py-3 bg-gray-100 text-right">
			{{ $footer ?? '' }}
		</div>
	@endif
</x-modal>
