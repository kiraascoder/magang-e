@extends('layouts.app')

@section('title', 'Logbook')
@section('page_title', 'Logbook')

@section('content')
    <div class="space-y-4">

        {{-- top action (kiri/kanan) --}}
        <div class="flex items-center justify-between">
            <div class="w-28 h-8 bg-gray-200 border border-gray-300 rounded"></div>
            <div class="w-24 h-8 bg-gray-200 border border-gray-300 rounded"></div>
        </div>

        {{-- container list --}}
        <div class="border border-gray-300 bg-white rounded">
            @for ($i = 0; $i < 2; $i++)
                <div class="p-4 border-b border-gray-200 last:border-b-0">
                    <div class="grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-4">
                            <div class="h-10 bg-gray-200 border border-gray-300 rounded"></div>
                        </div>

                        <div class="col-span-3 flex justify-center">
                            <div class="w-24 h-20 bg-gray-200 border border-gray-300 rounded"></div>
                        </div>

                        <div class="col-span-4">
                            <div class="h-10 bg-gray-200 border border-gray-300 rounded"></div>
                        </div>

                        <div class="col-span-1 flex justify-end">
                            <div class="w-12 h-10 bg-gray-200 border border-gray-300 rounded"></div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

    </div>
@endsection
