<!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 class="mt-4 text-white">Are you sure you want to delete this Product?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-dismiss="modal">Cancel</button>

                <form method="POST" action="{{ url('delete/'.$product->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>






