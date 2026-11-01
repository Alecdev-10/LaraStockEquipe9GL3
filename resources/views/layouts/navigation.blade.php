<nav class="border-b border-slate-200 bg-white shadow-sm">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('dashboard') }}" class="flex items-center" aria-label="LaraStock — tableau de bord">
            <img src="{{ asset('images/larastock-logo.svg') }}" alt="LaraStock" class="h-8 w-auto">
        </a>

        <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm font-medium">
            @php($link = 'text-slate-600 transition hover:text-indigo-700')
            <a href="{{ route('dashboard') }}" class="{{ $link }} {{ request()->routeIs('dashboard') ? 'font-semibold text-indigo-700' : '' }}">Tableau de bord</a>
            <a href="{{ route('products.index') }}" class="{{ $link }} {{ request()->routeIs('products.*') ? 'font-semibold text-indigo-700' : '' }}">Produits</a>
            @if (Route::has('categories.index'))
                <a href="{{ route('categories.index') }}" class="{{ $link }} {{ request()->routeIs('categories.*') ? 'font-semibold text-indigo-700' : '' }}">Catégories</a>
            @else
                <span class="text-slate-400">Catégories</span>
            @endif
            @php($initials = collect(explode(' ', Auth::user()->name))->filter()->map(fn (string $word) => mb_strtoupper(mb_substr($word, 0, 1)))->take(2)->implode(''))
            <a href="{{ route('profile.edit') }}" title="Mon profil — {{ Auth::user()->name }}"
               class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 transition hover:bg-indigo-200 {{ request()->routeIs('profile.*') ? 'ring-2 ring-indigo-500 ring-offset-2' : '' }}">
                {{ $initials }}
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 font-semibold text-red-700 transition hover:bg-red-100">Déconnexion</button>
            </form>
        </div>
    </div>
</nav>
