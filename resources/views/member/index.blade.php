<div>
	@if($this->members->count() === 0)
		<x-card>
			<x-slot name="content">
				<div class="text-center">
					<div class="text-gray-600 text-lg">{{ __('dashboard/index.text.create-member') }}</div>
					<div class="flex mt-3 justify-center">
						<a href="{{ route('member.create') }}">
							<x-button>{{ __('member/create.title') }}</x-button>
						</a>
					</div>
				</div>
			</x-slot>
		</x-card>
	@else
		<!-- options -->
		@if(auth()->user()->canUpload())
			<div class="flex justify-end mb-5 px-6 sm:px-0">
				<a href="{{ route('member.create') }}"><x-button>{{ __('member/create.title') }}</x-button></a>
			</div>
		@endif
		<!-- list -->
		<div class="gap-5 grid grid-cols-2 md:grid-cols-4">
			@foreach($this->members as $member)
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
						<div class="text-gray-500 text-sm">
							<div><strong>{{ __('member/show.form.edit-member.details.birthday') }}:</strong> {{ $member->birthday->format('jS F Y') }}</div>
							<div>{{ $member->description }}</div>
						</div>
					</x-slot>
				</x-card>
			@endforeach
		</div>

		@if($this->members->hasPages())
			<div class="mt-5">
				{{ $this->members->links() }}
			</div>
		@endif
	@endif
</div>
