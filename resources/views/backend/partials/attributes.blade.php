@foreach($attributes as $attribute)
    @switch($attribute->type)
        @case(\App\Models\Attribute::NUMBER)
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label for="attributes[{{ $attribute->id }}]" class="col-form-label">
                        {{ $attribute->title }} @if($attribute->measure) {{ $attribute->measure }} @endif
                    </label>
                    <input
                        class="form-control @error('slug')is-invalid @enderror "
                        type="text" name="attributes[{{ $attribute->id }}]"
                        value="{{ old('attributes.'.$attribute->id, isset($product) ? $attribute->pivot->value : '') }}"
                        id="attributes[{{ $attribute->id }}]">
                </div>
            </div>
            @break
        @case(\App\Models\Attribute::STRING)
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label for="attributes[{{ $attribute->id }}]" class="col-form-label">
                        {{ $attribute->title }} @if($attribute->measure) {{ $attribute->measure }} @endif
                    </label>
                    <input
                        class="form-control @error('slug')is-invalid @enderror "
                        type="text" name="attributes[{{ $attribute->id }}]"
                        value="{{ old('attributes.'.$attribute->id, isset($product) ? $attribute->pivot->value : '') }}"
                        id="attributes[{{ $attribute->id }}]">
                </div>
            </div>
            @break
        @case(\App\Models\Attribute::SELECT)
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label for="attributes[{{ $attribute->id }}]" class="col-form-label">{{ $attribute->title }} @if($attribute->measure) {{ $attribute->measure }} @endif</label>
                    <select
                        class="form-control js-example-basic-single form-control @error('attributes.'.$attribute->id)is-invalid @enderror  form-select"
                        id="attributes[{{ $attribute->id }}]" name="attributes[{{ $attribute->id }}]">
                        <option value="">Select option</option>
                        @foreach($attribute->values as $value)
                            <option {{ old('attributes.'.$attribute->id, isset($product) ? $attribute->pivot->value_id : '') === $value->id ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @break
    @endswitch
@endforeach
