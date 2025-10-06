<div class="mt-5 text-center custom-pagination">
    <div class="text-muted mb-2">
        Showing <strong>{{ $items->firstItem() }}</strong>
        to <strong>{{ $items->lastItem() }}</strong>
        of <strong>{{ $items->total() }}</strong> results
    </div>
    <div class="d-inline-block">
        {{ $items->links() }}
    </div>
</div>
