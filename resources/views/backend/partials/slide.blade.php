<div class="card" id="slide-{{$id}}">
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
            <button class="handle btn btn-outline-info border-0" style="margin-left: auto; cursor: move" type="button" title="" >Hold to drag</button>
            <button data-id="{{$id}}" class="remove-additional_info btn btn-outline-danger border-0"
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
                            <div class="form-group col-md-6">
                                <label for="slides[{{$id}}][title:{{$localeCode}}]" class="col-form-label">Title<sup style="color: red">*</sup></label>
                                <input id="slides[{{$id}}][title:{{$localeCode}}]"
                                       class="@error('slides.'.$id.'.title:'.$localeCode)is-invalid @enderror form-control"
                                       name="slides[{{$id}}][title:{{$localeCode}}]"
                                       value="{{old('slides.'.$id.'title:'.$localeCode, (isset($slide) && $slide->translate($localeCode)) ? $slide->translate($localeCode)->title : '')}}">
                                @error('slides.' . $id . '.title:'.$localeCode)
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="slides[{{$id}}][link:{{$localeCode}}]" class="col-form-label">Link</label>
                                <input id="slides[{{$id}}][link:{{$localeCode}}]"
                                       class="@error('slides.'.$id.'.link:'.$localeCode)is-invalid @enderror form-control"
                                       name="slides[{{$id}}][link:{{$localeCode}}]"
                                       value="{{old('slides.'.$id.'link:'.$localeCode, (isset($slide) && $slide->translate($localeCode)) ? $slide->translate($localeCode)->link : '')}}">
                                @error('slides.'.$id.'link:'.$localeCode)
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>@enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mt-3 col-12">
                                <label for="slides[{{$id}}][description:{{$localeCode}}]" class="col-form-label">Description</label>
                                <textarea id="slides[{{$id}}][description:{{$localeCode}}]"
                                          class="@error('description:'.$localeCode)is-invalid @enderror form-control"
                                          name="slides[{{$id}}][description:{{$localeCode}}]" cols="30"
                                          rows="3">{{old('description:'.$localeCode, (isset($slide) && $slide->translate($localeCode)) ? $slide->translate($localeCode)->description : '')}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="card-footer">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="slug" class="col-form-label">Image<sup style="color: red">*</sup></label>
                    <input type="hidden" name="delete_images[]" id="deleteImages">
                    <input type="hidden" class="url" name="slides[{{$id}}][preview_url]" id="preview_url-{{$id}}">
                    <input type="file"
                           data-file-id="{{isset($slide) && $slide->getFirstMedia('preview') ? $slide->getFirstMedia('preview')->id : '' }}"
                           name="slides[{{$id}}][preview]" id="input-file-now-{{$id}}" class="dropify"
                           data-default-file="{{isset($slide) && $slide->getFirstMediaUrl('preview') ? $slide->getFirstMediaUrl('preview') : '' }}"
                           data-show-remove="false"/>
                </div>
            </div>
        </div>
    </div>
</div>
