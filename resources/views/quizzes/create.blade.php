<x-layouts.base>
    {{-- Nav --}}
    @include('layouts.nav')
    
    {{-- SideNav --}}
    @include('layouts.sidenav')
    
    <main class="content">
        {{-- TopBar --}}
        @include('layouts.topbar')
        
        <div class="py-4">
            <h2 class="h4">Ajouter un Nouveau Quiz</h2>
            <form wire:submit.prevent="create">
                <div class="row">
                    <div class="col">
                        <label class="form-label">Image :</label>
                        <input type="file" class="form-control @error('image_url') is-invalid @enderror" wire:model="image_url" accept="image/*">
                        @error('image_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col">
                        <label class="form-label">Audio :</label>
                        <input type="file" class="form-control @error('audio') is-invalid @enderror" wire:model="audio" accept="audio/*">
                        @error('audio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <label class="form-label">Résultat :</label>
                        <input type="text" class="form-control @error('result') is-invalid @enderror" wire:model="result">
                        @error('result') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <label class="form-label">Description :</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description"></textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Ajouter Quiz</button>
                </div>
            </form>
        </div>
    </main>
</x-layouts.base> 