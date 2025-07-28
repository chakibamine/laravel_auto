<x-layouts.base>
    {{-- Nav --}}
    @include('layouts.nav')
    
    {{-- SideNav --}}
    @include('layouts.sidenav')
    
    <main class="content">
        {{-- TopBar --}}
        @include('layouts.topbar')
        
        <div class="py-4">
            <h2 class="h4">Select Number of Questions</h2>
            <form wire:submit.prevent="selectNumberOfQuestions">
                <div class="mb-3">
                    <label for="numberOfQuestions" class="form-label">Number of Questions:</label>
                    <input type="number" id="numberOfQuestions" wire:model="numberOfQuestions" class="form-control" min="1" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        {{-- Footer --}}
        @include('layouts.footer')
    </main>
</x-layouts.base> 