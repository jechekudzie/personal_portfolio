@extends('layouts.portfolio')

@section('title', 'Kudzai Nigel Jeche - Full Stack Developer & Digital Consultant')

@section('content')
    <!-- Hero Section -->
    @include('portfolio.sections.hero')

    <!-- About Section -->
    @include('portfolio.sections.about')

    <!-- Services Section -->
    @include('portfolio.sections.services')

    <!-- Portfolio Section -->
    @include('portfolio.sections.portfolio')

    <!-- Website Highlights Section -->
    @include('portfolio.sections.highlights')

    <!-- Contact Section -->
    @include('portfolio.sections.contact')
@endsection

@push('scripts')
<script>
    // Pass Laravel data to JavaScript
    window.portfolioData = {
        projects: @json($projects ?? []),
        services: @json($services ?? []),
        highlights: @json($highlights ?? []),
        csrfToken: '{{ csrf_token() }}',
        contactUrl: '{{ route('portfolio.contact') }}'
    };
</script>
@endpush