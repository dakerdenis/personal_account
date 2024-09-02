<div style="cursor: pointer" id="ins-{{isset($insuranceCondition) ? (is_array($insuranceCondition) ? $id : $insuranceCondition->id) : $id}}" class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-0 m-t-30">
                    <div class="form-group">
                        <label for="insuranceBlocks[{{isset($insuranceCondition) ? (is_array($insuranceCondition) ? $id : $insuranceCondition->id) : $id}}][preview]" class="col-form-label">Image</label>
                        <input type="hidden" name="image[{{isset($insuranceCondition) ? (is_array($insuranceCondition) ? $id : $insuranceCondition->id) : $id}}]" value="{{old('image.'.$id, isset($insuranceCondition) && is_object($insuranceCondition) && $insuranceCondition->getFirstMediaUrl('preview') ? $insuranceCondition->getFirstMediaUrl('preview') : '')}}">
                        <input type="hidden" class="url" name="insuranceBlocks[{{isset($insuranceCondition) ? (is_array($insuranceCondition) ? $id : $insuranceCondition->id) : $id}}][preview_url]" id="preview_url-{{$id}}">
                        <input type="file" name="insuranceBlocks[{{isset($insuranceCondition) ? (is_array($insuranceCondition) ? $id : $insuranceCondition->id) : $id}}][preview]" id="input-file-now-{{$id}}" class="dropify" data-default-file="{{ isset($insuranceCondition) ? $insuranceCondition->getFirstMediaUrl('preview') : '' }}" data-show-remove="false"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
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
            <button data-id="{{isset($insuranceCondition) ? (is_array($insuranceCondition) ? $id : $insuranceCondition->id) : $id}}" class="remove-partTextIns btn btn-outline-danger border-0" style="margin-left: auto" type="button" title="" data-bs-original-title="btn btn-outline-danger" data-original-title="btn btn-outline-danger">Remove</button>
        </ul>
        <div class="tab-content" id="myTabContent">
            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                <div class="tab-pane fade {{$loop->first ? 'active show' : ''}}"
                     id="{{$localeCode}}-{{$id}}-spec" role="tabpanel"
                     aria-labelledby="{{$localeCode}}-tab-{{$id}}-spec">
                    <div class="mb-0 m-t-30 row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="insuranceBlocks[{{isset($insuranceCondition) ? (is_array($insuranceCondition) ? $id : $insuranceCondition->id) : $id}}][title:{{$localeCode}}]" class="col-form-label">Title</label>
                                <input
                                    class="form-control"
                                    type="text" name="insuranceBlocks[{{isset($insuranceCondition) ? (is_array($insuranceCondition) ? $id : $insuranceCondition->id) : $id}}][title:{{$localeCode}}]"
                                    value="{{isset($insuranceCondition) && is_object($insuranceCondition) && $insuranceCondition->translate($localeCode) ? ($insuranceCondition->translate($localeCode)->title ?? '') : (isset($insuranceCondition) && is_array($insuranceCondition) && isset($insuranceCondition['title:'.$localeCode]) ? $insuranceCondition['title:'.$localeCode] : '')}}"
                                    id="insuranceBlocks[{{isset($insuranceCondition) ? (is_array($insuranceCondition) ? $id : $insuranceCondition->id) : $id}}][title:{{$localeCode}}]">
                            </div>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-12">
                            <label for="insuranceBlocks[{{isset($insuranceCondition) ? (is_array($insuranceCondition) ? $id : $insuranceCondition->id) : $id}}][description:{{$localeCode}}]"
                                   class="col-form-label">Description</label>
                            <textarea id="insuranceBlocks[{{isset($insuranceCondition) ? (is_array($insuranceCondition) ? $id : $insuranceCondition->id) : $id}}][description:{{$localeCode}}]"
                                      class="form-control"
                                      name="insuranceBlocks[{{isset($insuranceCondition) ? (is_array($insuranceCondition) ? $id : $insuranceCondition->id) : $id}}][description:{{$localeCode}}]" cols="30"
                                      rows="5">{{ isset($insuranceCondition) ? $insuranceCondition->translate($localeCode)?->description : '' }}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
