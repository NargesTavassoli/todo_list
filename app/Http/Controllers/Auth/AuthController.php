<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\User;
use App\Models\User;
use Auth;
use Hash;
use App\Models\Task;
class AuthController extends Controller
{
    public function register()
    {

        return view('auth.register');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/tasks/create');
    }

    public function login()
    {

        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/tasks/create');
        }

        return redirect('login')->with('error', 'Oppes! You have entered invalid credentials');
    }

    public function logout() {
        Auth::logout();

        return redirect('login');
    }

    public function home()
    {
        return view('home');
    }

    public function index()
    {
        return Task::where('archive', 0)
            ->orderBy('id', 'desc')->get();
    }
    public function archived()
    {
        return Task::where('archive', 1)
            ->orderBy('id', 'desc')->get();
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|max:500'
        ]);
        return Task::create(['body' => request('body')]);
    }
    public function edit(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|max:500'
        ]);
        $task = Task::findOrFail($request->id);
        $task->body = $request->body;
        $task->save();
    }
    public function archive($id)
    {
        $task = Task::findOrFail($id);
        $task->archive = ! $task->archive;
        $task->save();
    }
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
    }
}


