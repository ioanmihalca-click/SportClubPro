<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Mobile Ad (apare doar pe mobile) -->
            {{-- <div class="mb-6 lg:hidden">
                <div class="w-full h-32 bg-gray-100 rounded-lg dark:bg-gray-700">
                  
                    <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-4375168668507865"
                        data-ad-slot="5710411733" data-ad-format="auto" data-full-width-responsive="true"></ins>
                </div>
            </div> --}}

            <!-- Flex container pentru conținut și sidebar -->
            <div class="flex gap-6">
                <!-- Main content -->
                <div class="flex-1">
                    @if (!auth()->user()->club_id)
                        <livewire:create-club />
                    @else
                        <livewire:dashboard />
                    @endif
                </div>

                <!-- Desktop Sidebar Ads -->
                {{-- <div class="hidden w-64 lg:block">
                    <div class="sticky top-4">
                        <div class="w-full bg-gray-100 rounded-lg h-96 dark:bg-gray-700">
                            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-4375168668507865"
                                data-ad-slot="4892052455" data-ad-format="auto" data-full-width-responsive="true"></ins>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</x-app-layout>
