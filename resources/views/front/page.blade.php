@extends('layouts.app')

@section('title', $pageData['title'] . ' - ' . setting('site_name', 'SmartNews'))

@section('content')
<main id="mainContent" class="main-layout single-layout">
    <div class="container">
        <div class="main-layout__grid">
            
            <article class="main-content single-content">
                <nav class="breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb__list">
                        <li class="breadcrumb__item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb__sep"><i class="fas fa-chevron-right"></i></li>
                        <li class="breadcrumb__item breadcrumb__item--active">{{ $pageData['title'] }}</li>
                    </ol>
                </nav>

                <h1 class="single-title" style="margin-bottom: 8px;">{{ $pageData['title'] }}</h1>
                @if(isset($pageData['subtitle']))
                    <p style="color: var(--color-primary); font-weight: 600; font-size: 15px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color);">
                        {{ $pageData['subtitle'] }}
                    </p>
                @endif

                <div class="article-body">
                    {!! $pageData['content'] !!}
                </div>
            </article>

            @include('partials.sidebar')
        </div>
    </div>
</main>
@endsection
