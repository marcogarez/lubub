<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        $request->request->add(['username', Str::slug($request->username)]);

        $this->validate($request, [
            'username' => ['required', 'unique:users,username,' . auth()->user()->id, 'min:3', 'max:20', 'not_in:editar-perfil'],
            'email' => ['required', 'unique:users,email,' . auth()->user()->id, 'email'],
        ]);

        if ($request->imagen) {
            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);

            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        $new_password = false;

        if ($request->password) {
            if (!auth()->attempt($request->only('email', 'password'))) {
                return back()->with('mensaje', 'La contraseña es incorrecta');
            }

            $this->validate($request, [
                'new_password' => 'required|confirmed|min:8'
            ]);

            $new_password = Hash::make($request->new_password);
        }

        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->email = $request->email;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? '';
        if ($new_password) {
            $usuario->password = $new_password;
        }
        $usuario->save();

        return redirect()->route('posts.index', $usuario->username)->with('mensaje', 'Datos actualizados correctamente!');
    }
}
