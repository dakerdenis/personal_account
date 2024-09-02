<div style="cursor: pointer" id="part-s-{{isset($stat) ? (is_array($stat) ? $id : $stat->id) : $id}}" class="card">
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                <li class="nav-item">
                    <a class="nav-link {{$loop->first ? 'active' : ''}}"
                       id="ext-{{ $localeCode }}-tab-{{$id}}" data-bs-toggle="tab"
                       href="#ext-{{ $localeCode }}-{{$id}}" role="tab"
                       aria-controls="ext-{{ $localeCode }}-{{$id}}"
                       aria-selected="true">{{ mb_convert_case($properties['native'], MB_CASE_TITLE, "UTF-8") }}</a>
                </li>
            @endforeach
            <button data-id="{{isset($stat) ? (is_array($stat) ? $id : $stat->id) : $id}}" class="remove-part-s btn btn-outline-danger border-0" style="margin-left: auto" type="button" title="" data-bs-original-title="btn btn-outline-danger" data-original-title="btn btn-outline-danger">Remove</button>
        </ul>
        <div class="tab-content" id="myTabContent">
            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                <div class="tab-pane fade {{$loop->first ? 'active show' : ''}}"
                     id="ext-{{$localeCode}}-{{$id}}" role="tabpanel"
                     aria-labelledby="ext-{{$localeCode}}-tab-{{$id}}">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="mb-0">
                                <div class="form-group">
                                    <label for="stat[{{isset($stat) ? (is_array($stat) ? $id : $stat->id) : $id}}][title:{{$localeCode}}]" class="col-form-label">Title</label>
                                    <input
                                        class="form-control @error('stat.' . (isset($stat) ? ((is_array($stat) ? $id : $stat->id)) : $id) .'.title:'.$localeCode)is-invalid @enderror "
                                        type="text" name="stat[{{isset($stat) ? (is_array($stat) ? $id : $stat->id) : $id}}][title:{{$localeCode}}]"
                                        placeholder="use @@text@@ to bold text"
                                        value="{{isset($stat) && is_object($stat) && $stat->translate($localeCode) ? $stat->translate($localeCode)->title : (isset($stat) && is_array($stat) && isset($stat['title:'. $localeCode]) ? $stat['title:'. $localeCode] : '')}}"
                                        id="stat[{{isset($stat) ? (is_array($stat) ? $id : $stat->id) : $id}}][title:{{$localeCode}}]">
                                    @error('stat.'.(isset($stat) ? (is_array($stat) ? $id : $stat->id) : $id).'.title:'.$localeCode)
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="card-footer">
        <div class="form-row row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="stat[{{isset($stat) ? (is_array($stat) ? $id : $stat->id) : $id}}][preview]" class="col-form-label">Image</label>
                    <input type="hidden" name="image[{{isset($stat) ? (is_array($stat) ? $id : $stat->id) : $id}}]" value="{{old('image.'.(isset($stat) ? (is_array($stat) ? $id : $stat->id) : $id), isset($stat) && is_object($stat) && $stat->getFirstMediaUrl('preview') ? $stat->getFirstMediaUrl('preview') : '')}}">
                    <input type="hidden" class="url" name="stat[{{isset($stat) ? (is_array($stat) ? $id : $stat->id) : $id}}][preview_url]" id="preview_url-{{$id}}">
                    <input type="file" name="stat[{{isset($stat) ? (is_array($stat) ? $id : $stat->id) : $id}}][preview]" id="input-file-now-{{$id}}" class="dropify" data-default-file="{{old('image.'.(isset($stat) ? (is_array($stat) ? $id : $stat->id) : $id), isset($stat) && is_object($stat) && $stat->getFirstMediaUrl('preview') ? $stat->getFirstMediaUrl('preview') : '')}}" data-show-remove="false"/>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <div class="card card-absolute">
                    <div class="card-header bg-primary">
                        <h5 class="text-white">Description Paragraphs</h5>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-12 repeatables-p">
                                @if(isset($stat) && $stat instanceof \App\Models\ExtendedStat)
                                    @foreach($stat->extendedStatInfos()->ordered()->get() as $block)
                                        @include('backend.partials.stat_info', ['statId' => $stat->id, 'statInfo' => $block])
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-2 text-center">
                                <button class="btn btn-outline-success add_descripion-p" type="button" data-stat-id="{{ isset($stat) ? (is_array($stat) ? $id : $stat->id) : $id }}"
                                        data-link="{{route('backend.blocks.add_extended_stat_info')}}" data-original-title="btn btn-outline-success">
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
