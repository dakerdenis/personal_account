<div id="row-{{isset($image) ? $image->id : $id}}" style="cursor:move;" class="image-attribute card mt-3">
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                <li class="nav-item">
                    <a class="nav-link {{$loop->first ? 'active' : ''}}"
                       id="{{ $localeCode }}-tab-{{isset($image) ? $image->id : $id}}" data-bs-toggle="tab"
                       href="#{{ $localeCode }}-{{isset($image) ? $image->id : $id}}" role="tab"
                       aria-controls="{{ $localeCode }}-{{ isset($image) ? $image->id : $id}}"
                       aria-selected="true">{{ mb_convert_case($properties['native'], MB_CASE_TITLE, "UTF-8") }}</a>
                </li>
            @endforeach
                <button data-id="{{isset($image) ? $image->id : $id }}" class="remove-row btn btn-outline-danger border-0" style="margin-left: auto" type="button" title="" data-bs-original-title="btn btn-outline-danger" data-original-title="btn btn-outline-danger">Remove</button>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-0 m-t-30">
                        <div class="form-group">
                            <img height="95px" src="{{$image->getFullUrl('fullHD')}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 tab-content">
                    @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                        <div class="tab-pane fade {{$loop->first ? 'active show' : ''}}"
                             id="{{$localeCode}}-{{isset($image) ? $image->id : $id}}" role="tabpanel"
                             aria-labelledby="{{$localeCode}}-tab">
                            <div class="mb-0 m-t-30">
                                <div class="form-group mt-3">
                                    <label for="file[{{isset($image) ? $image->id : $id}}][caption:{{$localeCode}}]" class="col-form-label">Caption</label>
                                    <input
                                        class="form-control "
                                        type="text" name="files[{{isset($image) ? $image->id : $id}}][caption:{{$localeCode}}]"
                                        placeholder="Caption"
                                        value="{{isset($image) && $image->translate($localeCode) ? $image->translate($localeCode)->caption : ''}}"
                                        id="file[{{isset($image) ? $image->id : $id}}][caption:{{$localeCode}}]">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
