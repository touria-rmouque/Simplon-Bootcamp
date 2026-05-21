@extends('layouts.app')

@section('content')
<div class="py-10 bg-[#f8fafc] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="mt-2 text-slate-500 font-medium">
                    Bienvenue, <span class="text-indigo-600">{{ Auth::user()->name }}</span> ! Voici l'état actuel de vos missions.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            <div class="bg-white p-8 rounded-3xl shadow-[0_20px_25px_-5px_rgba(0,0,0,0.05)] border border-slate-100 flex flex-col items-center text-center group hover:border-slate-200 transition-all">
                <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">À faire</p>
                <p class="text-4xl font-black text-slate-900 mt-2">{{ $counts['todo'] }}</p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-[0_20px_25px_-5px_rgba(0,0,0,0.05)] border border-indigo-50 flex flex-col items-center text-center group hover:border-indigo-100 transition-all">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">En cours</p>
                <p class="text-4xl font-black text-indigo-600 mt-2">{{ $counts['in_progress'] }}</p>
            </div>


            <div class="bg-white p-8 rounded-3xl shadow-[0_20px_25px_-5px_rgba(0,0,0,0.05)] border border-emerald-50 flex flex-col items-center text-center group hover:border-emerald-100 transition-all">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Terminées</p>
                <p class="text-4xl font-black text-emerald-600 mt-2">{{ $counts['done'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-[0_20px_25px_-5px_rgba(0,0,0,0.05)] border border-slate-100 p-10">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="p-6 bg-indigo-50 rounded-2xl">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h3 class="text-xl font-bold text-slate-900">Prêt à organiser votre journée ?</h3>
                    <p class="text-slate-500 mt-1">Accédez à votre liste complète pour modifier ou ajouter de nouvelles missions.</p>
                </div>
                <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-8 py-4 border border-transparent text-sm font-bold rounded-xl text-white bg-slate-900 hover:bg-slate-800 shadow-xl transition-all hover:-translate-y-1">
                    Gérer mes tâches
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection