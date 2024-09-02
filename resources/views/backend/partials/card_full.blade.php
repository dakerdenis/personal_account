<div style="cursor: pointer" id="part-{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}" class="card">
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
            <button data-id="{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}" class="remove-part btn btn-outline-danger border-0" style="margin-left: auto" type="button" title="" data-bs-original-title="btn btn-outline-danger" data-original-title="btn btn-outline-danger">Remove</button>
        </ul>
        <div class="tab-content" id="myTabContent">
            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                <div class="tab-pane fade {{$loop->first ? 'active show' : ''}}"
                     id="{{$localeCode}}-{{$id}}" role="tabpanel"
                     aria-labelledby="{{$localeCode}}-tab-{{$id}}">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="mb-0">
                                <div class="form-group">
                                    <label for="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][title:{{$localeCode}}]" class="col-form-label">Title</label>
                                    <input
                                        class="form-control @error('repeatable.' . (isset($repeatable) ? ((is_array($repeatable) ? $id : $repeatable->id)) : $id) .'.title:'.$localeCode)is-invalid @enderror "
                                        type="text" name="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][title:{{$localeCode}}]"
                                        placeholder="Title"
                                        value="{{isset($repeatable) && is_object($repeatable) && $repeatable->translate($localeCode) ? $repeatable->translate($localeCode)->title : (isset($repeatable) && is_array($repeatable) && isset($repeatable['title:'. $localeCode]) ? $repeatable['title:'. $localeCode] : '')}}"
                                        id="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][title:{{$localeCode}}]">
                                    @error('repeatable.'.(isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id).'.title:'.$localeCode)
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][data:{{$localeCode}}][button_text]" class="col-form-label">Button Text</label>
                                <input
                                    class="form-control @error('repeatable.' . (isset($repeatable) ? ((is_array($repeatable) ? $id : $repeatable->id)) : $id) . '.data:' .$localeCode . '.button_text')is-invalid @enderror "
                                    type="text" name="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][data:{{$localeCode}}][button_text]"
                                    placeholder="Prefix"
                                    value="{{isset($repeatable) && is_object($repeatable) && $repeatable->translate($localeCode) ? ($repeatable->translate($localeCode)->data['button_text'] ?? '') : (isset($repeatable) && is_array($repeatable) && isset($repeatable['data:'. $localeCode]['button_text']) ? $repeatable['data:'. $localeCode]['button_text'] : '')}}"
                                    id="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][data:{{$localeCode}}][button_text]">
                                @error('repeatable.'.(isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id).'data'.$localeCode.'.button_text')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>@enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][data:{{$localeCode}}][text]" class="col-form-label">Text</label>
                                <textarea
                                    class="form-control @error('repeatable.' . (isset($repeatable) ? ((is_array($repeatable) ? $id : $repeatable->id)) : $id) .'.data'.$localeCode.'.text')is-invalid @enderror "
                                    name="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][data:{{$localeCode}}][text]"
                                    id="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][data:{{$localeCode}}][text]"
                                     cols="30" rows="5">{{isset($repeatable) && is_object($repeatable) && $repeatable->translate($localeCode) ? ($repeatable->translate($localeCode)->data['text'] ?? '') : (isset($repeatable) && is_array($repeatable) && isset($repeatable['data:'. $localeCode]['text']) ? $repeatable['data:'. $localeCode]['text'] : '')}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="card-footer">
        <div class="form-row row">
            <div class="form-group">
                <label for="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][meta][link]" class="col-form-label">Link</label>
                <input
                    class="form-control @error('repeatable.'.(isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id).'.meta.link')is-invalid @enderror "
                    type="text" name="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][meta][link]"
                    placeholder="Link"
                    value="{{isset($repeatable) && is_object($repeatable) && isset($repeatable->meta['link']) ? $repeatable->meta['link'] : (isset($repeatable) && is_array($repeatable) && isset($repeatable['meta']['link']) ? $repeatable['meta']['link'] : '')}}"
                    id="link">
                @error('repeatable.'.(isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id).'.meta.link')
                <div class="invalid-feedback">
                    {{$message}}
                </div>@enderror
            </div>
        </div>
        <div class="form-row row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][preview]" class="col-form-label">Image</label>
                    <input type="hidden" name="image[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}]" value="{{old('image.'.(isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id), isset($repeatable) && is_object($repeatable) && $repeatable->getFirstMediaUrl($media_collection_name) ? $repeatable->getFirstMediaUrl($media_collection_name) : '')}}">
                    <input type="hidden" class="url" name="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][preview_url]" id="preview_url-{{$id}}">
                    <input type="file" name="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][preview]" id="input-file-now-{{$id}}" class="dropify" data-default-file="{{old('image.'.(isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id), isset($repeatable) && is_object($repeatable) && $repeatable->getFirstMediaUrl($media_collection_name) ? $repeatable->getFirstMediaUrl($media_collection_name) : '')}}" data-show-remove="false"/>
                </div>
            </div>
        </div>
    </div>
</div>
