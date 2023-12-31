<div class="icon-btn">
    @if(!empty($show))
    <a href="{{ $show }}" data-toggle="tooltip" title="Details" class="btn btn-outline-primary ml-1"><i class="fas fa-eye"></i>
    </a>
    @endif

    @if(!empty($edit))
    <a href="{{ $edit }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning ml-1"><i class="fas fa-pen"></i>
    </a>
    @endif

    @if(!empty($delete))
    <form action="{{ $delete }}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger btn-sm delete ml-1"><i class="fas fa-trash"></i></button>
    </form>
    @endif

</div>