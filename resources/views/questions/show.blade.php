@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h2>
                                {{ $question->title }}
                            </h2>
                            <div class="ml-auto">
                                {{-- ml-auto so the button will be positioned at the right --}}
                                <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back to all
                                    questions</a>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="media">
                    <vote name="question" :model="{{ $question }}"></vote>
                        <div class="media-body">
                            {!! $question->body_html !!}
                            <div class="row">
                                <div class="col-4"></div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    {{-- @include('shared._author', [
                                        'model' => $question,
                                        'label' => 'Asked'
                                    ]) --}}
                                    <user-info :model="{{ $question }}" label="Asked"></user-info>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<answers :question="{{ $question }}"></answers>
    @include('answers._create')
</div>
@endsection
