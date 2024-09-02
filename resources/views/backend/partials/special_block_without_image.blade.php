<div id="row-{{isset($special) ? (is_array($special) ? $id : $special->id) : $id}}" style="cursor:move;" class="image-attribute card mt-3">
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                <li class="nav-item">
                    <a class="nav-link {{$loop->first ? 'active' : ''}}"
                       id="{{ $localeCode }}-tab-{{isset($special) ? (is_array($special) ? $id : $special->id) : $id}}" data-bs-toggle="tab"
                       href="#{{ $localeCode }}-{{isset($special) ? (is_array($special) ? $id : $special->id) : $id}}" role="tab"
                       aria-controls="{{ $localeCode }}-{{ isset($special) ? (is_array($special) ? $id : $special->id) : $id}}"
                       aria-selected="true">{{ mb_convert_case($properties['native'], MB_CASE_TITLE, "UTF-8") }}</a>
                </li>
            @endforeach
            <button data-id="{{isset($special) ? (is_array($special) ? $id : $special->id) : $id }}" class="btn btn-outline-danger border-0 remove-block"
                    style="margin-left: auto" type="button" title="" data-bs-original-title="btn btn-outline-danger"
                    data-original-title="btn btn-outline-danger">Remove
            </button>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="row">
                <div class="col-md-6 tab-content">
                    @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                        <div class="tab-pane fade {{$loop->first ? 'active show' : ''}}"
                             id="{{$localeCode}}-{{isset($special) ? (is_array($special) ? $id : $special->id) : $id}}" role="tabpanel"
                             aria-labelledby="{{$localeCode}}-tab">
                            <div class="mb-0 m-t-30">
                                <div class="form-group mt-3">
                                    <label for="special[{{isset($special) ? (is_array($special) ? $id : $special->id) : $id}}][title:{{$localeCode}}]"
                                           class="col-form-label">Title</label>
                                    <input
                                        class="form-control "
                                        type="text"
                                        name="special[{{isset($special) ? (is_array($special) ? $id : $special->id) : $id}}][title:{{$localeCode}}]"
                                        placeholder="Caption"
                                        value="{{isset($special) && is_object($special) && $special->translate($localeCode) ? $special->translate($localeCode)->title : (isset($special) && is_array($special) && isset($special['title:'. $localeCode]) ? $special['title:'. $localeCode] : '')}}"
                                        id="special[{{isset($special) ? (is_array($special) ? $id : $special->id) : $id}}][title:{{$localeCode}}]">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
