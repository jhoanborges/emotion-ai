@extends('layouts.app')

@section('content')
<div id="facebook-posts"></div>
@endsection

@push('scripts')
    @viteReactRefresh
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <script type="module">
  import React from 'react';
  import ReactDOM from 'react-dom';
  import PostsComponent from '/resources/js/PostsComponent.jsx';

  ReactDOM.render(
    <React.StrictMode>
      <PostsComponent />
    </React.StrictMode>,
    document.getElementById('facebook-posts')
  );
</script>

@endpush
