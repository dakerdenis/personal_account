<div style="cursor: pointer" id="line-part-{{isset($featureLine) ? (is_array($featureLine) ? $id : $featureLine->id) : $id}}" class="card">
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
            <button data-id="{{isset($featureLine) ? (is_array($featureLine) ? $id : $featureLine->id) : $id}}" class="remove-part-line btn btn-outline-danger border-0" style="margin-left: auto" type="button" title="" data-bs-original-title="btn btn-outline-danger" data-original-title="btn btn-outline-danger">Remove</button>
        </ul>
        <div class="tab-content" id="myTabContent">
            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                <div class="tab-pane fade {{$loop->first ? 'active show' : ''}}"
                     id="{{$localeCode}}-{{$id}}-spec" role="tabpanel"
                     aria-labelledby="{{$localeCode}}-tab-{{$id}}-spec">
                    <div class="mb-0 m-t-30 row">
                        <div class="col-md-12">
                            <label for="featureBlocks[{{ $featureId }}][featureLines][{{isset($featureLine) ? (is_array($featureLine) ? $id : $featureLine->id) : $id}}][description:{{$localeCode}}]"
                                   class="col-form-label">Description</label>
                            <textarea id="featureBlocks[{{ $featureId }}][featureLines][{{isset($featureLine) ? (is_array($featureLine) ? $id : $featureLine->id) : $id}}][description:{{$localeCode}}]"
                                      class="form-control editor-cke-low"
                                      name="featureBlocks[{{ $featureId }}][featureLines][{{isset($featureLine) ? (is_array($featureLine) ? $id : $featureLine->id) : $id}}][description:{{$localeCode}}]" cols="30"
                                      rows="1">{{ isset($featureLine) ? $featureLine->translate($localeCode)?->description : '' }}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
