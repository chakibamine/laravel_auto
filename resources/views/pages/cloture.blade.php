<x-layouts.base>
    {{-- Nav --}}
    @include('layouts.nav')
    
    {{-- SideNav --}}
    @include('layouts.sidenav')
    
    <main class="content">
        <div class="py-4">
            @livewire('cloture')
        </div>

        {{-- Footer --}}
        @include('layouts.footer')
    </main>
</x-layouts.base> 