<?php
use App\Models\Task;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController; 
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $counts = [
        'todo' => Task::where('user_id', Auth::id())->where('status', 'todo')->count(),
        'in_progress' => Task::where('user_id', Auth::id())->where('status', 'in_progress')->count(),
        'done' => Task::where('user_id', Auth::id())->where('status', 'done')->count(),
    ];

    return view('dashboard', compact('counts'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');
    Route::resource('tasks', TaskController::class);
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    
});

require __DIR__.'/auth.php';