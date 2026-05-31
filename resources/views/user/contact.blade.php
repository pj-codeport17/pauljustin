@extends('layouts.app')
@section('title','Contact Us')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">

        <div class="text-center mb-4">
            <div style="font-size:3rem;color:var(--accent);line-height:1">
                <i class="bi bi-chat-heart-fill"></i>
            </div>
            <div class="page-header-title mt-2">Get in Touch</div>
            <div class="page-header-sub">Have a question or feedback? We'd love to hear from you.</div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger mb-3">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif

        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Your Name</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', auth()->user()->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email', auth()->user()->email) }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control"
                               value="{{ old('subject') }}"
                               placeholder="e.g. Bug Report, Suggestion..." required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Message</label>
                        <textarea name="message" class="form-control" rows="6"
                                  placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="bi bi-send-fill me-2"></i>Send Message
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
