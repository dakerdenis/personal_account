@php
    $name = null;
    $block = \App\Models\Block::find($id);
    if ($block) {
        $name = $block->title;
    }
@endphp
<div class="card" id="block-{{$id}}" style="cursor: pointer">
    <div class="card-body">
        <div class="form-group">
            <div class="d-flex justify-content-between">
                <label for="block-{{$id}}" class="col-form-label">Block</label>
                <button data-id="{{$id}}" class="remove-additional_info btn btn-outline-danger border-0" style="margin-left: auto" type="button" title="" data-bs-original-title="btn btn-outline-danger" data-original-title="btn btn-outline-danger">Remove</button>
            </div>
            <input id="block-{{$id}}" class="typeahead form-control" value="{{$name ?? ''}}" type="text" placeholder="Choose Option">
            <input type="hidden" class="hidden-value" value="{{$id}}" name="blocks[]" >
        </div>
    </div>
</div>
