@extends('layouts.app')

@section('title', 'Instansi')
@section('page_title', 'Instansi')

@section('content')
    <div class="space-y-4">
        {{-- versi mockup yang ada 2 card kecil + 1 card besar --}}
        <div class="flex gap-4">
            <div class="w-56 h-12 bg-gray-200 border border-gray-300 rounded"></div>
            <div class="w-56 h-12 bg-gray-200 border border-gray-300 rounded"></div>
        </div>

        <div class="w-[520px] max-w-full h-40 bg-gray-200 border border-gray-300 rounded"></div>
    </div>
@endsection
