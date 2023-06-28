<?php

use App\Http\Requests\TaskRequest;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function(){
  return redirect()->route('tasks.index');

});

Route::get('/tasks', function ()  {
    return view('index', [
       'tasks'=> Tarefa::latest()->paginate(10)
    ]);
    
})->name('tasks.index');

Route:: view('/tasks/create', 'create')
  ->name('tasks.create');

  Route:: get('/tasks/{task}/edit', function (Tarefa $task) {
    return view('edit', [
      'task' => $task
  ]);
})->name('tasks.edit');


Route:: get('/tasks/{task}', function (Tarefa $task) {
    return view('show', [
      'task' => $task
  ]);
})->name('tasks.show');


Route::post('/tasks', function (TaskRequest $request) {
  $task = Tarefa::create($request-> validated());

  return redirect()->route('tasks.show', ['task' =>$task ->id])
     ->with('success', 'Task created successfuly!');
})->name('tasks.store');

Route::put('/tasks/{task}', function (Tarefa $task, TaskRequest $request) {
  $task->update($request-> validated());
  
  return redirect()->route('tasks.show', ['task' =>$task ->id])
     ->with('success', 'Task updated successfuly!');
})->name('tasks.update');

Route:: delete('/tasks/{task}', function (Tarefa $task) {
    $task->delete();

    return redirect()->route('tasks.index')
    ->with('success', 'Task deleted successfully!');
})->name('tasks.destroy');

Route:: put('tasks/{task}/toggle-complete', function(Tarefa $task){
      $task->toggleComplete();

  return redirect()->back()->with('successfuly!');
})->name('tasks.toggle-complete');

//Route::get('/xxx', function () {
  //  return 'ola';
//})->name('ola');

//Route::get('/olaa', function () {
  //  return redirect()->route('ola');
//});

//Route::get('/greet/{nome}', function ($nome) {
  //  return 'Ola meu Jovem ' . $nome . '!' ;
//});

Route::fallback(function () {
    return 'O ficheiro não se encontra aqui!' ;
});

