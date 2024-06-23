@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}

                        <!-- Link to view Facebook posts -->
                        <div class="mt-4">
                            <a href="{{ route('facebook.posts') }}" class="btn btn-primary">
                                Go to my Posts and images
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
