<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Invitacion;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create(Request $request)
    {
        return view('auth.register'); // Vista de Breeze, ya puede acceder a $request->token si lo necesitas
    }

    public function store(Request $request)
    {
        // Validaciones mínimas porque ya pasamos por el middleware
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        //GETTING THE ROLE
        $token = $request->token;
        $invitacion = Invitacion::where('token', $token)->first();
        $idRole = $invitacion->idRole;

        // Crear usuario con el rol de la invitación
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'idRole' => $idRole,
            'password' => Hash::make($request->password),
        ]);

        // Marcar invitación como usada
        Invitacion::where('token', $token)->update(['is_used' => true]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->intended('/dashboard'); // o a donde prefieras
    }

    public function index(Request $request){
        // Retrieve users with their roles (using Eager Loading to optimize queries)
        $query = User::with(['roles']);

        if($request->filled('name')){
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        if($request->filled('email')){
            $query->where('email', 'like', '%'.$request->email.'%');
        }

        if($request->filled('idRole')){
            $query->where('idRole','=', $request->idRole);
        }

        $users = $query->orderBy('name', 'asc')
        ->paginate(10);
        //$roles = Role::all(); // Retrieve all roles
        $roles = Role::orderBy('name', 'asc')->get();

        return view('users.index', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'idRole' => 'required|exists:roles,id', // Ensure the role is valid
        ]);

        $user->idRole = $request->idRole;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
