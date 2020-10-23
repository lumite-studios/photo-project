<x-guest-layout>
	<x-screen-center>
		<form class="w-full sm:w-1/2 md:w-1/3 xl:w-1/4" method="POST" action="{{ route('auth.login') }}">
			@csrf
			<x-card>
				<x-slot name="title">{{ __('auth/login.title') }}</x-slot>
				<x-slot name="content">
					<x-validation-errors class="mb-3" />
					<!-- email address -->
					<div class="mb-3">
						<x-label for="email_address">{{ __('auth/login.form.email_address') }}</x-label>
						<x-input name="email_address" type="text" />
					</div>
					<!-- password -->
					<div class="mb-3">
						<x-label for="password">{{ __('auth/login.form.password') }}</x-label>
						<x-input name="password" type="password" />
					</div>
					<!-- remember me -->
					<div class="text-center">
						<input name="remember_me" type="checkbox" />
						<x-label for="remember_me">{{ __('auth/login.form.remember_me') }}</x-label>
					</div>
				</x-slot>
				<x-slot name="footer">
					<div class="flex-grow">
						<a href="{{ route('auth.register') }}">{{ __('auth/login.links.register') }}</a>
					</div>
					<x-button>{{ __('auth/login.form.submit') }}</x-button>
				</x-slot>
			</x-card>
		</form>
	</x-screen-center>
</x-guest-layout>
