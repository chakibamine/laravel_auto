<x-layouts.base>
    {{-- Navigation --}}
    @include('layouts.nav')
    
    {{-- Menu Latéral --}}
    @include('layouts.sidenav')
    
    <main class="content">
        {{-- TopBar --}}
        @include('layouts.topbar')
        
        <div class="py-4">
            @livewire('comptabilite')
        </div>

        {{-- Pied de page --}}
        @include('layouts.footer')
    </main>
</x-layouts.base> 