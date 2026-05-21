@extends('layouts.app')

@section('content')
<div class="py-12 bg-[#f8fafc] min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex items-center justify-between">
            <a href="{{ route('tasks.index') }}" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à la liste
            </a>
            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Édition de mission</span>
        </div>

        <div class="bg-white shadow-[0_20px_25px_-5px_rgba(0,0,0,0.05)] rounded-[2.5rem] border border-slate-100 overflow-hidden">
            <div class="bg-slate-900 p-8 md:p-10">
                <h2 class="text-2xl font-black text-white tracking-tight leading-tight">
                    Modifier : <span class="text-indigo-400">{{ $task->title }}</span>
                </h2>
                <p class="text-slate-400 mt-2 font-medium">Mettez à jour les paramètres de votre tâche ci-dessous.</p>
            </div>

            <form action="{{ route('tasks.update', $task) }}" method="POST" class="p-8 md:p-10 space-y-8">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Titre de la mission</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <input type="text" name="title" id="title" 
                            class="block w-full pl-11 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500/20 text-slate-700 font-semibold placeholder-slate-300 transition-all" 
                            value="{{ old('title', $task->title) }}" required>
                    </div>
                    @error('title') <p class="text-rose-500 text-[11px] mt-2 font-bold uppercase tracking-wide">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Description détaillée</label>
                    <textarea name="description" id="description" rows="4" 
                        class="block w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500/20 text-slate-700 font-medium placeholder-slate-300 transition-all" 
                        placeholder="Quels sont les détails de cette mission ?">{{ old('description', $task->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="category_id" class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Catégorie</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                            </div>
                            <select name="category_id" id="category_id" 
                                class="block w-full pl-11 pr-10 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500/20 text-slate-700 font-semibold cursor-pointer appearance-none transition-all">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $task->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="status" class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">État d'avancement</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <select name="status" id="status" 
                                class="block w-full pl-11 pr-10 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500/20 text-slate-700 font-semibold cursor-pointer appearance-none transition-all">
                                <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>À faire</option>
                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>En cours</option>
                                <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Terminé</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="due_date" class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Date d'échéance</label>
                    <div class="relative max-w-sm">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input type="date" name="due_date" id="due_date" 
                            class="block w-full pl-11 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500/20 text-slate-700 font-semibold transition-all" 
                            value="{{ old('due_date', $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}">
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-end gap-4 pt-6 border-t border-slate-50">
                    <a href="{{ route('tasks.index') }}" class="w-full md:w-auto text-center px-8 py-4 text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-widest">
                        Annuler
                    </a>
                    <button type="submit" class="w-full md:w-auto px-10 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-[0_10px_20px_-5px_rgba(79,70,229,0.4)] hover:bg-indigo-700 hover:-translate-y-1 transition-all active:scale-95">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection