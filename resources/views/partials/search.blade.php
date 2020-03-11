<form action="{{ route('product.search') }}" class="d-flex mr-3">
    <div class="form-group mb-0 mr-1">
        <input type="text"
               class="form-control " name="src" value="{{request()->src ?? ''}}" minlength="1" required>
    </div>
    <button type="submit" class="btn btn-info"><i class="icofont-search-1"></i></button>

</form>
