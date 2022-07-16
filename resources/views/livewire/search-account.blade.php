<div>
    <div class="border border-gray-300 p-2 rounded-lg flex gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input type="text" placeholder="Buscar..." class="focus: outline-none" wire:model='searchQuery'>
    </div>

    @if ($searchQuery)
        <div class="bg-white p-3 absolute border border-gray-300 rounded-lg">
            @forelse ($accounts as $account)
                <a href="{{ route('posts.index', $account->username) }}" class="flex gap-3 items-center mb-2">
                    <img src="{{ $account->imagen ? asset('perfiles/' . $account->imagen) : asset('img/usuario.svg') }}"
                        class="w-10 rounded-full">
                    <p>{{ $account->username }}</p>
                </a>
            @empty
                <p>No se encontraron usuarios</p>
            @endforelse
        </div>
    @endif
</div>
