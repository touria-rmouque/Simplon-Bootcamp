@extends('layouts.app')

@section('content')
<div class="py-10 bg-[#f8fafc] min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <a href="{{ route('tasks.index') }}" class="text-slate-500 hover:text-slate-900 flex items-center text-sm font-bold transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour à la liste
            </a>
        </div>

        <div class="bg-white shadow-[0_20px_25px_-5px_rgba(0,0,0,0.05)] rounded-3xl overflow-hidden border border-slate-100">
            <div class="p-8 md:p-12">
                <div class="mb-6">
                    @php
                        $statusStyle = [
                            'done' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                            'in_progress' => 'bg-amber-50 text-amber-700 border-amber-100',
                            'todo' => 'bg-slate-50 text-slate-500 border-slate-100'
                        ];
                        $statusLabel = ['done' => 'Terminé', 'in_progress' => 'En cours', 'todo' => 'En attente'];
                    @endphp
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold border {{ $statusStyle[$task->status] ?? $statusStyle['todo'] }}">
                        <span class="w-2 h-2 rounded-full bg-current mr-2"></span>
                        {{ $statusLabel[$task->status] ?? $task->status }}
                    </span>
                </div>

                <h1 class="text-3xl font-black text-slate-900 tracking-tight mb-4">
                    {{ $task->title }}
                </h1>

                <div class="flex flex-wrap gap-6 mb-8 pb-8 border-b border-slate-100">
                    <div class="flex items-center text-sm text-slate-500 font-medium">
                        <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                        {{ $task->category->name ?? 'Général' }}
                    </div>
                    <div class="flex items-center text-sm text-slate-500 font-medium">
                        <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Échéance : {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d F, Y') : 'Non définie' }}
                    </div>
                </div>

                <div class="prose prose-slate max-w-none">
                    <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-3">Description</h3>
                    <p class="text-slate-600 leading-relaxed text-lg">
                        {{ $task->description ?? 'Aucune description fournie pour cette mission.' }}
                    </p>
                </div>

                <div class="mt-12 pt-8 border-t border-slate-100 flex justify-end gap-4">
                    <a href="{{ route('tasks.edit', $task) }}" class="px-6 py-3 text-sm font-bold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">
                        Modifier la mission
                    </a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ?')">
                        @csrf @method('DELETE')
                        <button class="px-6 py-3 text-sm font-bold text-white bg-rose-500 rounded-xl hover:bg-rose-600 shadow-lg shadow-rose-200 transition-all">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection