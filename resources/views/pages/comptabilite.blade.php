<x-layouts.base>
    {{-- Nav --}}
    @include('layouts.nav')
    
    {{-- SideNav --}}
    @include('layouts.sidenav')
    
    <main class="content">
        {{-- TopBar --}}
        @include('layouts.topbar')
        
        <div class="py-4">
            @livewire('comptabilite')
        </div>

        {{-- Footer --}}
        @include('layouts.footer')
    </main>
</x-layouts.base> 