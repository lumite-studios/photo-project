<nav x-data="{ open: false }" class="bg-white border-b border-gray-200">
    <!-- desktop navigation menu -->
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between h-16">
            <div class="flex">
				<!-- links -->
                <div class="hidden space-x-6 sm:-my-px sm:flex">
                    @include('layouts.partials.links')
                </div>
            </div>
        </div>
    </div>
</nav>
