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
                        <div class="row">
                            <a href="{{ route('input') }}" class="btn btn-info col-md-4">Input</a>
                            <span class="col-md-4"></span>
                            <a href="{{ route('output') }}" class="btn btn-danger col-md-4">Output</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
