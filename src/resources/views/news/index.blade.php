@extends('layouts.app')

@section('title', 'Все новости')

@section('content')
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Новости компании</h1>

    @forelse($news as $item)
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 hover:shadow-lg transition">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">
                    <a href="{{ route('news.show', $item->id) }}" class="hover:text-blue-600 transition">
                        {{ $item->title }}
                    </a>
                </h2>
                <div class="flex items-center text-sm text-gray-500 mb-4 space-x-4">
                    <span>✍️ {{ $item->author }}</span>
                    <span>📅 {{ $item->created_at->format('d.m.Y H:i') }}</span>
                </div>
                <p class="text-gray-700 mb-4">{{ Str::limit($item->description, 200) }}</p>
                <a href="{{ route('news.show', $item->id) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Читать далее →
                </a>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-md p-8 text-center text-gray-500">
            Пока нет новостей.
        </div>
    @endforelse
@endsection
