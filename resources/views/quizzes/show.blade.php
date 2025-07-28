<x-layouts.base>
    {{-- Nav --}}
    @include('layouts.nav')
    
    {{-- SideNav --}}
    @include('layouts.sidenav')
    
    <main class="content">
        {{-- TopBar --}}
        @include('layouts.topbar')
        
        <div class="py-4">
            <h2 class="h4">Détails du Quiz</h2>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $quiz->result }}</h5>
                    <p class="card-text">{{ $quiz->description }}</p>
                    <img src="{{ Storage::url($quiz->image_url) }}" class="img-fluid" alt="Quiz Image">
                    <audio controls>
                        <source src="{{ Storage::url($quiz->audio) }}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                    <div class="mt-3">
                        <a href="{{ route('quizzes.index') }}" class="btn btn-secondary">Retour à la liste</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.base> 