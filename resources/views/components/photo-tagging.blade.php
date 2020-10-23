@props(['allowCreateTag' => false])

<div>
	<div class="relative cursor-pointer">
		<div x-on:click="{{ $allowCreateTag ? '$wire.startNewTag(
			$event.target.offsetWidth,
			$event.clientX - $event.target.getBoundingClientRect().left,
			$event.target.offsetHeight,
			$event.clientY - $event.target.getBoundingClientRect().top,
		)' : null }}">{{ $image }}</div>
		{{ $slot }}
	</div>
</div>
