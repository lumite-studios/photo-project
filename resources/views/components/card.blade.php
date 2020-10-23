@props(['link' => null])

@if($link === null)
	<div {{ $attributes->merge(['class' => 'bg-white overflow-hidden shadow text-gray-900 sm:rounded-lg hover:shadow-md']) }}>
		{{ $image ?? null }}

		@if($title ?? null)
			<div class="bg-gray-100 border-b border-gray-200 font-bold px-6 py-3 text-xl">
				{{ $title ?? '' }}
			</div>
		@endif
		@if($content ?? null)
			<div class="p-6">
				{{ $content }}
			</div>
		@endif

		@if($footer ?? null)
			<div class="bg-gray-100 border-t border-gray-200 flex items-center justify-end px-6 py-3 text-gray-600">
				{{ $footer ?? '' }}
			</div>
		@endif
	</div>
@else
	<a href="{{ $link }}" {{ $attributes->merge(['class' => 'bg-white block overflow-hidden shadow text-gray-900 sm:rounded-lg hover:shadow-md']) }}>
		{{ $image ?? null }}

		@if($title ?? null)
			<div class="bg-gray-100 border-b border-gray-200 font-bold px-6 py-3 text-xl">
				{{ $title ?? '' }}
			</div>
		@endif
		@if($content ?? null)
			<div class="p-6">
				{{ $content }}
			</div>
		@endif

		@if($footer ?? null)
			<div class="bg-gray-100 border-t border-gray-200 flex items-center justify-end px-6 py-3 text-gray-600">
				{{ $footer ?? '' }}
			</div>
		@endif
	</a>
@endif
