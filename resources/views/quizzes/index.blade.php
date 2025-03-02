<x-layouts.base>
    {{-- Nav --}}
    @include('layouts.nav')
    
    {{-- SideNav --}}
    @include('layouts.sidenav')
    
    <main class="content">
        {{-- TopBar --}}
        @include('layouts.topbar')
        
        <div class="py-4">
            {{-- Include the Quiz Component --}}
            @livewire('quiz-component')
        </div>
    </main>
</x-layouts.base> 