<div class="card" id="textrow-{{$id}}" style="cursor: move">
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                <li class="nav-item">
                    <a class="nav-link {{$loop->first ? 'active' : ''}}"
                       id="{{ $localeCode }}-tab-{{$id}}" data-bs-toggle="tab"
                       href="#{{ $localeCode }}-{{$id}}" role="tab"
                       aria-controls="{{ $localeCode }}-{{$id}}"
                       aria-selected="true">{{ mb_convert_case($properties['native'], MB_CASE_TITLE, "UTF-8") }}</a>
                </li>
            @endforeach
            <button data-id="{{$id}}" class="remove-partText btn btn-outline-danger border-0"
                    style="margin-left: auto" type="button" title="" data-bs-original-title="btn btn-outline-danger"
                    data-original-title="btn btn-outline-danger">Remove
            </button>
        </ul>
        <div class="tab-content" id="myTabContent">
            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                <div class="tab-pane fade {{$loop->first ? 'active show' : ''}}"
                     id="{{$localeCode}}-{{$id}}" role="tabpanel"
                     aria-labelledby="{{$localeCode}}-tab-{{$id}}">
                    <div class="mb-0 m-t-30">
                        <div class="row">
                            <div class="form-group mt-3 col-12">
                                <label for="blocks[{{$id}}][description:{{$localeCode}}]" class="col-form-label">Description <sup style="color: red">*</sup></label>
                                <textarea id="blocks[{{$id}}][description:{{$localeCode}}]" class="@error('description:'.$localeCode)is-invalid @enderror editor-cke form-control" name="blocks[{{$id}}][description:{{$localeCode}}]" cols="30" rows="3">{{isset($block) ? $block->translate($localeCode)?->description : ''}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="card-footer">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="blocks[{{$id}}][product_title_id]" class="col-form-label">Text Title <sup style="color: red">*</sup></label>
                    <select required class="form-control form-select" id="blocks[{{$id}}][product_title_id]" name="blocks[{{$id}}][product_title_id]">
                        <option value="">Select Title</option>
                        @foreach($titles as $title)
                            <option
                                {{isset($block) && $block->product_title_id == $title->id ? 'selected' : '' }} value="{{$title->id}}">{{$title->title}}</option>
                        @endforeach
                    </select>
                    @error("blocks[{{$id}}][product_title_id]")
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>@enderror
                </div>
            </div>
        </div>
    </div>
</div>
