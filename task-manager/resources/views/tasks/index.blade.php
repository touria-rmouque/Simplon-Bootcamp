@extends('layouts.app')

@section('content')
<div class="py-10 bg-[#f8fafc] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Gestion des Missions
                </h2>
                <p class="mt-2 text-slate-500 font-medium">
                    Suivez vos objectifs et optimisez votre productivité.
                </p>
            </div>
            <div class="mt-6 md:mt-0">
                <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-[0_10px_15px_-3px_rgba(79,70,229,0.3)] transition-all hover:-translate-y-0.5">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nouvelle Tâche
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-2 mb-8">
            <form action="{{ route('tasks.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
                <div class="flex-1 min-w-[200px] flex items-center px-4 border-r border-slate-100">
                    <span class="text-slate-400 mr-3">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </span>
                    <select name="status" class="border-none focus:ring-0 text-sm font-semibold text-slate-700 w-full cursor-pointer bg-transparent">
                        <option value="">Tous les statuts</option>
                        <option value="todo" {{ request('status') == 'todo' ? 'selected' : '' }}>En attente</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>En cours</option>
                        <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Terminé</option>
                    </select>
                </div>

                <div class="flex-1 min-w-[200px] flex items-center px-4 border-r border-slate-100">
                    <span class="text-slate-400 mr-3">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                        </svg>
                    </span>
                    <select name="category_id" class="border-none focus:ring-0 text-sm font-semibold text-slate-700 w-full cursor-pointer bg-transparent">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="p-2 flex items-center gap-2">
                    <button type="submit" class="bg-slate-900 text-white px-5 py-2.5 rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-slate-800 transition shadow-md">
                        Appliquer
                    </button>
                    <a href="{{ route('tasks.index') }}" class="px-3 py-2 text-xs font-bold text-slate-400 hover:text-slate-600 transition uppercase tracking-widest">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white shadow-[0_20px_25px_-5px_rgba(0,0,0,0.05)] rounded-3xl overflow-hidden border border-slate-100">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Détails de la mission</th>
                            <th class="px-8 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Catégorie</th>
                            <th class="px-8 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Statut interactif</th>
                            <th class="px-8 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Échéance</th>
                            <th class="px-8 py-5"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($tasks as $task)
                        <tr class="hover:bg-slate-50/80 transition-all group">
                            
                            <td class="px-8 py-6">
                                <div class="text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">
                                    {{ $task->title }}
                                </div>
                                <div class="text-xs text-slate-400 mt-1 max-w-xs truncate">
                                    {{ $task->description ?? 'Aucune description' }}
                                </div>
                            </td>
                            
                            <td class="px-8 py-6">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-slate-50 text-slate-500 border border-slate-200">
                                    {{ $task->category->name ?? 'Général' }}
                                </span>
                            </td>

                            <td class="px-8 py-6">
                                <form action="{{ route('tasks.update-status', $task) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    
                                    @php
                                        $statusColors = [
                                            'done' => 'text-emerald-700 bg-emerald-50 border-emerald-100',
                                            'in_progress' => 'text-amber-700 bg-amber-50 border-amber-100',
                                            'todo' => 'text-slate-500 bg-slate-50 border-slate-100'
                                        ];
                                    @endphp

                                    <div class="relative inline-flex items-center">
                                        <select name="status" 
                                            onchange="this.form.submit()"
                                            class="appearance-none bg-none pl-3 pr-8 py-1.5 rounded-full text-[11px] font-bold border transition-all cursor-pointer focus:ring-2 focus:ring-indigo-500/20 {{ $statusColors[$task->status] ?? $statusColors['todo'] }}">
                                            <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>En attente</option>
                                            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>En cours</option>
                                            <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Terminé</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-current opacity-50">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </form>
                            </td>

                            <td class="px-8 py-6">
                                <div class="flex items-center text-xs font-semibold {{ $task->due_date && $task->due_date < now() && $task->status != 'done' ? 'text-rose-500' : 'text-slate-500' }}">
                                    <svg class="mr-2 h-3.5 w-3.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M, Y') : '--' }}
                                </div>
                            </td>

                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <a href="{{ route('tasks.show', $task) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 px-3 py-2 rounded-lg hover:bg-indigo-50 transition-colors">
                                        Voir détails
                                    </a>

                                    <div class="flex items-center gap-1 border-l border-slate-100 pl-3">
                                        <a href="{{ route('tasks.edit', $task) }}" class="p-2 text-slate-400 hover:text-slate-900 transition-colors" title="Modifier">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette mission ?')">
                                            @csrf @method('DELETE')
                                            <button class="p-2 text-slate-400 hover:text-rose-600 transition-colors" title="Supprimer">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="p-4 bg-slate-50 rounded-full mb-4 text-slate-300">
                                        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-slate-900 font-bold">Aucune tâche trouvée</h3>
                                    <p class="text-slate-500 text-sm mt-1">Commencez par créer une mission ou ajustez vos filtres.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tasks->hasPages())
            <div class="bg-slate-50/50 px-8 py-4 border-t border-slate-100">
                {{ $tasks->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection