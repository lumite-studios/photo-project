<x-guest-layout>
	<x-screen-center>
		<form class="w-full sm:w-1/2 md:w-1/3 xl:w-1/4" method="POST" action="{{ route('auth.register') }}">
			@csrf
			<x-card>
				<x-slot name="title">{{ __('auth/register.title') }}</x-slot>
				<x-slot name="content">
					<x-validation-errors class="mb-3" />
					<!-- name -->
					<div class="mb-3">
						<x-label for="name">{{ __('auth/register.form.name') }} *</x-label>
						<x-input name="name" type="text" value="{{ old('name') }}" />
					</div>
					<!-- email address -->
					<div class="mb-3">
						<x-label for="email_address">{{ __('auth/register.form.email_address') }} *</x-label>
						<x-input name="email_address" type="text" value="{{ old('email_address') }}" />
					</div>
					<!-- password -->
					<div class="mb-3">
						<x-label for="password">{{ __('auth/register.form.password') }} *</x-label>
						<x-input name="password" type="password" />
					</div>
					<!-- confirm password -->
					<div>
						<x-label for="password_confirmation">{{ __('auth/register.form.password_confirmation') }} *</x-label>
						<x-input name="password_confirmation" type="password" />
					</div>
					@if(config('app.invite_code'))
						<div class="mt-3">
							<x-label for="invite_code">{{ __('auth/register.form.invite_code') }} *</x-label>
							<x-input name="invite_code" type="text" value="{{ old('invite_code') }}" />
						</div>
					@endif
				</x-slot>
				<x-slot name="footer">
					<div class="flex-grow">
						<a href="{{ route('auth.login') }}">{{ __('auth/register.links.login') }}</a>
					</div>
					<x-button type="submit">{{ __('auth/register.form.submit') }}</x-button>
				</x-slot>
			</x-card>
		</form>
	</x-screen-center>
</x-guest-layout>
