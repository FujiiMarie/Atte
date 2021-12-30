@extends('layouts.default')

@section('title', 'Atte')

@include('layouts.header')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Atte') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-xl font-bold text-center space-y-10">
                <div class="flex flex-wrap justify-center space-x-10"> 
                    <div class="py-20 px-48 bg-white">
                        勤務開始
                    </div>
                    <div class="py-20 px-48 bg-white">
                        勤務終了
                    </div>
                </div>
                <div class="flex flex-wrap justify-center space-x-10"> 
                    <div class="py-20 px-48 bg-white">
                        休憩開始
                    </div>
                    <div class="py-20 px-48 bg-white">
                        休憩終了
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@include('layouts.footer')
