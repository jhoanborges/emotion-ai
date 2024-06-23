<!-- resources/views/livewire/emotion.blade.php -->
<div>

    <div class="container my-5">
        <div class="row">

            {{--
            <div wire:loading>
                Processing Payment...
            </div>
            --}}

            <div class="col-sm-4 my-2">
                <button wire:loading.attr="disabled" class="btn btn-primary" wire:click="fetchEmotionData">What do you know
                    about me?</button>
                @empty($emotionResult)
                @else
                    <p class="h5">This is how are you feeling based on what you post:</p>
                    {!! $emotionResult !!}
                @endempty
            </div>



            <div class="col-sm-4 my-2">
                <button wire:loading.attr="disabled" class="btn btn-primary" wire:click="whoYouAreFunction">What am i
                    according to what i
                    post?</button>
                @empty($whoYouAre)
                @else
                    <p class="h5">This is who you are according to what you post:</p>
                    {!! $whoYouAre !!}
                @endempty
            </div>

            <div class="col-sm-4 my-2">
                <button wire:loading.attr="disabled" class="btn btn-primary" wire:click="whatCanBeSellFunction">what
                    would i sell you to make you
                    feel
                    better?</button>
                @empty($whatCanBeSell)
                @else
                    <p class="h5">This is what would i sell you to make you feel better:</p>
                    {!! $whatCanBeSell !!}
                @endempty

            </div>

        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.hook('beforeSend', (xhr, component) => {
                // Show loading overlay before Livewire request
                $.LoadingOverlay("show");
            });

            Livewire.hook('afterError', (xhr, component, error) => {
                // Hide loading overlay on Livewire request error
                $.LoadingOverlay("hide");
            });

            Livewire.hook('afterResponse', (response, component) => {
                // Hide loading overlay after Livewire request completes
                $.LoadingOverlay("hide");
            });

        });
    </script>
</div>
