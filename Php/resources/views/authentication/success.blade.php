@extends('layout')
@section('content')
<div class="container">
    <div class="text-center">
        <h1>Thank you for registering</h1>
        <a href="{{ route('contact.index') }}" class="btn btn-primary">Continue</a>
    </div>
</div>
@endsection
