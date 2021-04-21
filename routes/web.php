<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Models\Task;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/register', 'App\Http\Controllers\Auth\AuthController@register')->name('register');
Route::post('/register', 'App\Http\Controllers\Auth\AuthController@storeUser');

Route::get('/login', 'App\Http\Controllers\Auth\AuthController@login')->name('login');
Route::post('/login', 'App\Http\Controllers\Auth\AuthController@authenticate');
Route::get('/logout', 'App\Http\Controllers\Auth\AuthController@logout')->name('logout');

Route::get('/home', 'App\Http\Controllers\Auth\AuthController@home')->middleware('auth');



///////////
Route::get('/tasks/create', function (){
    if($_GET){
        dd($_GET);
    }
    return view('create', [
        'task' => Task::all()
    ]);
})->middleware('auth');
Route::post('/tasks/create', function () {
     //  dd(Request::all());
      // dd($id = Auth::user()->id);
        $validator = Validator::make(request()->all() , [
            'task' => 'required|max:50',
        ]);

        if($validator->fails()){
            return redirect()
                        ->back()
                        ->withErrors($validator);
        }
        // $id = Auth::user()->id;

    Task::create([
            'name' =>  request('task'),
            'user_id' => Auth::user()->id
        ]);

        return redirect('/tasks/create');
});
Route::get('/tasks/{id}/edit', function ($id){
    $task = Task::findOrFail($id);
    return view('edit' , [
        'task' => $task
    ]);
});

Route::put('/tasks/{id}/edit', function ($id){

  //  $validator = Validator::make(request()->all() , [
  //      'task' => 'required|max:50',
   // ]);

 //   if($validator->fails()){
 //       return redirect()
   //         ->back()
   //         ->withErrors($validator);
 //   }
    $task = Task::findOrFail($id);
    $task->update([
        'name' =>  request('task')
    ]);
    return redirect('/tasks/create');
});

Route::delete('/tasks/{id}', function ($id){
    $task = Task::findOrFail($id);
    $task->delete();
    return redirect('/tasks/create');
});
