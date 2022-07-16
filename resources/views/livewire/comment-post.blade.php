<div>
    @auth
        <p class="text-xl font-bold text-center mb-4">Agrega un nuevo comentario</p>

        @if (session('mensaje'))
            <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                {{ session('mensaje') }}
            </div>
        @endif

        <form wire:submit.prevent='saveComment' method="POST">

            @csrf

            <div class="mb-5">
                <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">Añade un
                    comentario</label>
                <textarea placeholder="Agrega un comentario"
                    class="border p-3 w-full rounded-lg @error('comentario') border-red-500 @enderror" wire:model='comentario'
                    name="comentario" id="comentario"></textarea>
                @error('comentario')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <input type="submit" value="Comentar"
                class="bg-sky-600 hover:bg-sky-700 transition-colors uppercase font-bold w-full p-3 text-white rounded-lg">
        </form>
    @endauth

    <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10">
        @if ($post->comentarios->count())
            @foreach ($post->comentarios as $comentario)
                <div class="p-5 border-gray-300 border-b">
                    <a href="{{ route('posts.index', ['user' => $comentario->user]) }}"
                        class="font-bold">{{ $comentario->user->username }}</a>
                    <p>{{ $comentario->comentario }}</p>
                    <p class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</p>
                </div>
            @endforeach
        @else
            <p class="p-10 text-center">No hay comentarios aún</p>
        @endif
    </div>
</div>
