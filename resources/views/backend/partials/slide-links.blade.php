<div style="cursor: pointer" id="part-slide-{{isset($slideLink) ? (is_array($slideLink) ? $id : $slideLink->id) : $id}}" class="card">
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
            <button data-id="{{isset($slideLink) ? (is_array($slideLink) ? $id : $slideLink->id) : $id}}" class="remove-slide-link btn btn-outline-danger border-0" style="margin-left: auto" type="button" title="" data-bs-original-title="btn btn-outline-danger" data-original-title="btn btn-outline-danger">Remove</button>
        </ul>
        <div class="tab-content" id="myTabContent">
            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                <div class="tab-pane fade {{$loop->first ? 'active show' : ''}}"
                     id="{{$localeCode}}-{{$id}}-spec" role="tabpanel"
                     aria-labelledby="{{$localeCode}}-tab-{{$id}}-spec">
                    <div class="mb-0 m-t-30 row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="slides[{{ $slideId }}][links][{{isset($slideLink) ? (is_array($slideLink) ? $id : $slideLink->id) : $id}}][title:{{$localeCode}}]" class="col-form-label">Title</label>
                                <input
                                    class="form-control"
                                    type="text" name="slides[{{ $slideId }}][links][{{isset($slideLink) ? (is_array($slideLink) ? $id : $slideLink->id) : $id}}][title:{{$localeCode}}]"
                                    value="{{isset($slideLink) && is_object($slideLink) && $slideLink->translate($localeCode) ? ($slideLink->translate($localeCode)->title ?? '') : (isset($slideLink) && is_array($slideLink) && isset($slideLink['title:'.$localeCode]) ? $slideLink['title:'.$localeCode] : '')}}"
                                    id="slides[{{ $slideId }}][links][{{isset($slideLink) ? (is_array($slideLink) ? $id : $slideLink->id) : $id}}][title:{{$localeCode}}]">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="slides[{{ $slideId }}][links][{{isset($slideLink) ? (is_array($slideLink) ? $id : $slideLink->id) : $id}}][link:{{$localeCode}}]" class="col-form-label">Link</label>
                                <input
                                    class="form-control"
                                    type="text" name="slides[{{ $slideId }}][links][{{isset($slideLink) ? (is_array($slideLink) ? $id : $slideLink->id) : $id}}][link:{{$localeCode}}]"
                                    value="{{isset($slideLink) && is_object($slideLink) && $slideLink->translate($localeCode) ? ($slideLink->translate($localeCode)->link ?? '') : (isset($slideLink) && is_array($slideLink) && isset($slideLink['link:'.$localeCode]) ? $slideLink['link:'.$localeCode] : '')}}"
                                    id="slides[{{ $slideId }}][links][{{isset($slideLink) ? (is_array($slideLink) ? $id : $slideLink->id) : $id}}][link:{{$localeCode}}]">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
