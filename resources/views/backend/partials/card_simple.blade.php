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
                    <div class="mb-0 m-t-30 row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][data:{{$localeCode}}][prefix]" class="col-form-label">Prefix</label>
                                <input
                                    class="form-control @error('repeatable.' . (isset($repeatable) ? ((is_array($repeatable) ? $id : $repeatable->id)) : $id) . '.data:' .$localeCode . '.prefix')is-invalid @enderror "
                                    type="text" name="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][data:{{$localeCode}}][prefix]"
                                    placeholder="Prefix"
                                    value="{{isset($repeatable) && is_object($repeatable) && $repeatable->translate($localeCode) ? ($repeatable->translate($localeCode)->data['prefix'] ?? '') : (isset($repeatable) && is_array($repeatable) && isset($repeatable['data:'. $localeCode]['prefix']) ? $repeatable['data:'. $localeCode]['prefix'] : '')}}"
                                    id="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][data:{{$localeCode}}][prefix]">
                                @error('repeatable.'.(isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id).'data'.$localeCode.'.prefix')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][data:{{$localeCode}}][suffix]" class="col-form-label">Suffix</label>
                                <input
                                    class="form-control @error('repeatable.' . (isset($repeatable) ? ((is_array($repeatable) ? $id : $repeatable->id)) : $id) .'.data'.$localeCode.'.suffix')is-invalid @enderror "
                                    type="text" name="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][data:{{$localeCode}}][suffix]"
                                    placeholder="Suffix"
                                    value="{{isset($repeatable) && is_object($repeatable) && $repeatable->translate($localeCode) ? ($repeatable->translate($localeCode)->data['suffix'] ?? '') : (isset($repeatable) && is_array($repeatable) && isset($repeatable['data:'. $localeCode]['suffix']) ? $repeatable['data:'. $localeCode]['suffix'] : '')}}"
                                    id="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][data:{{$localeCode}}][suffix]">
                                @error('repeatable.'.(isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id).'.data'.$localeCode.'.suffix')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
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
                </div>
            @endforeach
        </div>
    </div>
    <div class="card-footer">
        <div class="form-row row">
            <div class="form-group">
                <label for="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][meta][number]" class="col-form-label">Number</label>
                <input
                    class="form-control @error('repeatable.'.(isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id).'.meta.number')is-invalid @enderror "
                    type="text" name="repeatable[{{isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id}}][meta][number]"
                    placeholder="number"
                    value="{{isset($repeatable) && is_object($repeatable) && isset($repeatable->meta['number']) ? $repeatable->meta['number'] : (isset($repeatable) && is_array($repeatable) && isset($repeatable['meta']['number']) ? $repeatable['meta']['number'] : '')}}"
                    id="link">
                @error('repeatable.'.(isset($repeatable) ? (is_array($repeatable) ? $id : $repeatable->id) : $id).'.meta.number')
                <div class="invalid-feedback">
                    {{$message}}
                </div>@enderror
            </div>
        </div>
    </div>
</div>
