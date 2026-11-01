<nav class="border-b border-slate-200 bg-white">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('products.index') }}" class="text-xl font-bold tracking-tight text-indigo-700">LaraStock</a>

        <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm font-medium">
            <a href="{{ route('dashboard') }}" class="text-slate-700 hover:text-indigo-700">Tableau de bord</a>
            <a href="{{ route('products.index') }}" class="text-slate-700 hover:text-indigo-700">Produits</a>
            @if (Route::has('categories.index'))
                <a href="{{ route('categories.index') }}" class="text-slate-700 hover:text-indigo-700">Catégories</a>
            @else
                <span class="text-slate-400">Catégories</span>
            @endif
            <a href="{{ route('profile.edit') }}" class="text-slate-700 hover:text-indigo-700">Mon profil</a>
            <span class="hidden text-slate-500 sm:inline">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="font-semibold text-red-700 hover:text-red-800">Déconnexion</button>
            </form>
        </div>
    </div>
</nav>
