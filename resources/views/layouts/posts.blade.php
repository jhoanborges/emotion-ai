@extends('layouts.app')

@section('content')
    {{--
     <div class="container">
        <div class="col-sm-4">

            <div class="row">
                @include('layouts.chatgpt.index')
            </div>
        </div>
    </div>
    --}}
    @livewire('emotion')

    <div class="container">
        <div class="row">
            @foreach ($posts as $post)
                @if (!empty($post['description']) && !empty($post['name']))
                    <div class="col-md-4">
                        <div class="card mb-4">
                            @if (!empty($post['full_picture']))
                                <img src="{{ $post['full_picture'] }}" class="card-img-top" alt="Post Image">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $post['name'] }}</h5>
                                <p class="card-text">{{ $post['description'] }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
