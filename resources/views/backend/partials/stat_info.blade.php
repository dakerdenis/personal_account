<div style="cursor: pointer" id="part-i-{{isset($statInfo) ? (is_array($statInfo) ? $id : $statInfo->id) : $id}}" class="card">
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                <li class="nav-item">
                    <a class="nav-link {{$loop->first ? 'active' : ''}}"
                       id="inf-{{ $localeCode }}-tab-{{$id}}-{{isset($statInfo) ? (is_array($statInfo) ? $id : $statInfo->id) : $id}}" data-bs-toggle="tab"
                       href="#inf-{{ $localeCode }}-{{$id}}-{{isset($statInfo) ? (is_array($statInfo) ? $id : $statInfo->id) : $id}}" role="tab"
                       aria-controls="inf-{{ $localeCode }}-{{$id}}"
                       aria-selected="true">{{ mb_convert_case($properties['native'], MB_CASE_TITLE, "UTF-8") }}</a>
                </li>
            @endforeach
            <button data-id="{{isset($statInfo) ? (is_array($statInfo) ? $id : $statInfo->id) : $id}}" class="remove-part-i btn btn-outline-danger border-0" style="margin-left: auto" type="button" title="" data-bs-original-title="btn btn-outline-danger" data-original-title="btn btn-outline-danger">Remove</button>
        </ul>
        <div class="tab-content" id="myTabContent">
            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                <div class="tab-pane fade {{$loop->first ? 'active show' : ''}}"
                     id="inf-{{$localeCode}}-{{$id}}-{{isset($statInfo) ? (is_array($statInfo) ? $id : $statInfo->id) : $id}}" role="tabpanel"
                     aria-labelledby="inf-{{$localeCode}}-tab-{{$id}}-{{isset($statInfo) ? (is_array($statInfo) ? $id : $statInfo->id) : $id}}">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="mb-0">
                                <div class="form-group">
                                    <label for="stat[{{ $statId }}][statInfo][{{isset($statInfo) ? (is_array($statInfo) ? $id : $statInfo->id) : $id}}][title:{{$localeCode}}]" class="col-form-label">Title</label>
                                    <input
                                        class="form-control"
                                        type="text" name="stat[{{ $statId }}][statInfo][{{isset($statInfo) ? (is_array($statInfo) ? $id : $statInfo->id) : $id}}][title:{{$localeCode}}]"
                                        placeholder="use @@text@@ to bold text"
                                        value="{{isset($statInfo) && is_object($statInfo) && $statInfo->translate($localeCode) ? $statInfo->translate($localeCode)->title : (isset($statInfo) && is_array($statInfo) && isset($statInfo['title:'. $localeCode]) ? $statInfo['title:'. $localeCode] : '')}}"
                                        id="stat[{{ $statId }}][statInfo][{{isset($statInfo) ? (is_array($statInfo) ? $id : $statInfo->id) : $id}}][title:{{$localeCode}}]">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="stat[{{ $statId }}][statInfo][{{isset($statInfo) ? (is_array($statInfo) ? $id : $statInfo->id) : $id}}][description:{{$localeCode}}]" class="col-form-label">Text</label>
                            <textarea
                                class="form-control"
                                name="stat[{{ $statId }}][statInfo][{{isset($statInfo) ? (is_array($statInfo) ? $id : $statInfo->id) : $id}}][description:{{$localeCode}}]"
                                id="stat[{{ $statId }}][statInfo][{{isset($statInfo) ? (is_array($statInfo) ? $id : $statInfo->id) : $id}}][description:{{$localeCode}}]"
                                cols="30" rows="5">{{isset($statInfo) && is_object($statInfo) && $statInfo->translate($localeCode) ? ($statInfo->translate($localeCode)->description ?? '') : (isset($statInfo) && is_array($statInfo) && isset($statInfo['description:'. $localeCode]) ? $statInfo['description:'. $localeCode] : '')}}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
