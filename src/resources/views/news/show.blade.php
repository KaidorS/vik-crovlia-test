@extends('layouts.app')

@section('title', $news->title)

@section('content')
    <article class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6 md:p-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $news->title }}</h1>
            <div class="flex items-center text-sm text-gray-500 mb-6 space-x-4 border-b border-gray-100 pb-4">
                <span>✍️ {{ $news->author }}</span>
                <span>📅 {{ $news->created_at->format('d.m.Y H:i') }}</span>
            </div>

            <div class="prose max-w-none text-gray-700">
                {!! $news->content !!}
            </div>

            <div class="mt-8 pt-4 border-t border-gray-100">
                <a href="{{ route('news.index') }}" class="text-blue-600 hover:underline flex items-center gap-1">
                    ← Назад к списку новостей
                </a>
            </div>
        </div>
    </article>
@endsection
