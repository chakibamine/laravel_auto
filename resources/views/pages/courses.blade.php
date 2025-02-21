<x-layouts.base>
    {{-- Nav --}}
    @include('layouts.nav')
    
    {{-- SideNav --}}
    @include('layouts.sidenav')
    
    <main class="content">
        {{-- TopBar --}}
        @include('layouts.topbar')
        
        {{-- Course List Component --}}
        <livewire:cour-list />

        {{-- Footer --}}
        @include('layouts.footer')
    </main>

    {{-- Add Course Modal Component --}}
    <livewire:components.add-cour-modal />
</x-layouts.base>

@push('scripts')
<script>
    window.addEventListener('closeModal', event => {
        document.querySelectorAll('.modal').forEach(modal => {
            modal.style.display = 'none';
        });
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.remove();
        });
    });
</script>
@endpush 