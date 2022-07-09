@extends('layouts.app')

@section('titulo', $user->username)

@section('contenido')
    @if (session('mensaje'))
        <div class="flex justify-center">
            <p class="bg-green-500 text-white my-2 rounded-lg text-xl p-2 text-center w-1/2">{{ session('mensaje') }}</p>
        </div>
    @endif
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            <div class="w-8/12 lg:w-6/12 px-5">
                <img src="{{ $user->imagen ? asset('perfiles' . '/' . $user->imagen) : asset('img/usuario.svg') }}"
                    alt="Imagen usuario">
            </div>
            <div class="md:w-8/12 lg:w-6/12 px-5 flex flex-col items-center md:justify-center md:items-start py-10 md:py-10">
                <div class="flex items-center gap-4">
                    <p class="text-gray-700 text-2xl">{{ $user->username }}</p>

                    @auth
                        @if ($user->id === auth()->user()->id)
                            <a class="text-gray-500 hover:text-gray-600 cursor-pointer" href="{{ route('perfil.index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </a>
                        @endif
                    @endauth
                </div>

                <p class="text-gray-800 text-sm mb-3 font-bold mt-5">
                    <span class="font-normal">{{$user->followers->count()}} Seguidores</span>
                </p>
                <p class="text-gray-800 text-sm mb-3 font-bold">
                    <span class="font-normal">0 Siguiendo</span>
                </p>
                <p class="text-gray-800 text-sm mb-3 font-bold">
                    <span class="font-normal">{{ $user->posts->count() }} posts</span>
                </p>

                @auth
                    @if ($user->id != auth()->user()->id)
                        <form action="{{ route('users.follow', $user) }}" method="POST">
                            @csrf
                            <input type="submit"
                                class="bg-blue-600 text-white uppercase rounded-lg px-4 py-1 text-xs font-bold cursor-pointer"
                                value="Seguir">
                        </form>
                        <form action="{{ route('users.unfollow', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit"
                                class="bg-red-600 text-white uppercase rounded-lg px-4 py-1 text-xs font-bold cursor-pointer"
                                value="Dejar de seguir">
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <section class="container mx-auto mt-10">
        <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>

        @if ($posts->count())
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($posts as $post)
                    <div>
                        <a href="{{ route('posts.show', ['user' => $user, 'post' => $post]) }}">
                            <img src="{{ asset('uploads') . '/' . $post->imagen }}"
                                alt="Imagen del post {{ $post->titulo }}">
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="my-10">
                {{ $posts->links() }}
            </div>
        @else
            <p class="text-gray-600 uppercase text-sm text-center font-black">No hay posts</p>
        @endif

    </section>
@endsection
