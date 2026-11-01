@if ($paginator->hasPages())
    <nav class="flex flex-wrap items-center justify-between gap-3" role="navigation" aria-label="Pagination des produits">
        <p class="text-sm text-slate-600">Page {{ $paginator->currentPage() }} sur {{ $paginator->lastPage() }} - {{ $paginator->total() }} produits</p>
        <div class="flex gap-2">
            @if ($paginator->onFirstPage())
                <span class="button-secondary cursor-not-allowed opacity-50" aria-disabled="true">Précédent</span>
            @else
                <a class="button-secondary" href="{{ $paginator->previousPageUrl() }}" rel="prev">Précédent</a>
            @endif

            @if ($paginator->hasMorePages())
                <a class="button-secondary" href="{{ $paginator->nextPageUrl() }}" rel="next">Suivant</a>
            @else
                <span class="button-secondary cursor-not-allowed opacity-50" aria-disabled="true">Suivant</span>
            @endif
        </div>
    </nav>
@endif
