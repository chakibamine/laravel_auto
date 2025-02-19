<div>
    @if($showModal)
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <button wire:click="cancel" type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ $message }}</p>
                </div>
                <div class="modal-footer">
                    <button wire:click="cancel" type="button" class="btn btn-link text-gray ms-auto">{{ $cancelButtonText }}</button>
                    <button wire:click="confirm" type="button" class="btn {{ $confirmButtonClass }}">{{ $confirmButtonText }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif
</div> 