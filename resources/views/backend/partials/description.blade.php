<div style="cursor: pointer" id="part-feature-{{isset($feature) ? (is_array($feature) ? $id : $feature->id) : $id}}" class="card">
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                <li class="nav-item">
                    <a class="nav-link {{$loop->first ? 'active' : ''}}"
                       id="{{ $localeCode }}-tab-{{$id}}-spec" data-bs-toggle="tab"
                       href="#{{ $localeCode }}-{{$id}}-spec" role="tab"
                       aria-controls="{{ $localeCode }}-{{$id}}-spec"
                       aria-selected="true">{{ mb_convert_case($properties['native'], MB_CASE_TITLE, "UTF-8") }}</a>
                </li>
            @endforeach
            <button class="handle btn btn-outline-info border-0" style="margin-left: auto; cursor: move" type="button" title="" >Hold to drag</button>
            <button data-id="{{isset($feature) ? (is_array($feature) ? $id : $feature->id) : $id}}" class="remove-part-feature btn btn-outline-danger border-0" style="margin-left: auto" type="button" title="" data-bs-original-title="btn btn-outline-danger" data-original-title="btn btn-outline-danger">Remove</button>
        </ul>
        <div class="tab-content" id="myTabContent">
            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                <div class="tab-pane fade {{$loop->first ? 'active show' : ''}}"
                     id="{{$localeCode}}-{{$id}}-spec" role="tabpanel"
                     aria-labelledby="{{$localeCode}}-tab-{{$id}}-spec">
                    <div class="mb-0 m-t-30 row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="featureBlocks[{{isset($feature) ? (is_array($feature) ? $id : $feature->id) : $id}}][title:{{$localeCode}}]" class="col-form-label">Title</label>
                                <input
                                    class="form-control"
                                    type="text" name="featureBlocks[{{isset($feature) ? (is_array($feature) ? $id : $feature->id) : $id}}][title:{{$localeCode}}]"
                                    value="{{isset($feature) && is_object($feature) && $feature->translate($localeCode) ? ($feature->translate($localeCode)->title ?? '') : (isset($feature) && is_array($feature) && isset($feature['title:'.$localeCode]) ? $feature['title:'.$localeCode] : '')}}"
                                    id="featureBlocks[{{isset($feature) ? (is_array($feature) ? $id : $feature->id) : $id}}][title:{{$localeCode}}]">
                            </div>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-12">
                            <label for="featureBlocks[{{isset($feature) ? (is_array($feature) ? $id : $feature->id) : $id}}][description:{{$localeCode}}]"
                                   class="col-form-label">Description</label>
                            <textarea id="featureBlocks[{{isset($feature) ? (is_array($feature) ? $id : $feature->id) : $id}}][description:{{$localeCode}}]"
                                      class="form-control"
                                      name="featureBlocks[{{isset($feature) ? (is_array($feature) ? $id : $feature->id) : $id}}][description:{{$localeCode}}]" cols="30"
                                      rows="5">{{ isset($feature) ? $feature->translate($localeCode)?->description : '' }}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-sm-12 class-repaatables-line" id="repeatables-{{isset($feature) ? (is_array($feature) ? $id : $feature->id) : $id}}">
                @isset($feature)
                    @foreach($feature->featureLines()->ordered()->get() as $block)
                        @include('backend.partials.feature_line', ['id' => $block->id, 'featureId' => $feature->id, 'featureLine' => $block])
                    @endforeach
                @endisset
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-2 text-center">
                <button class="btn btn-outline-success repeatables-feature-lines" type="button"
                        data-link="{{route('backend.products.get-feature-line-block', ['featureId' => isset($feature) ? (is_array($feature) ? $id : $feature->id) : $id])}}">
                    Add
                </button>
            </div>
        </div>
    </div>
</div>
