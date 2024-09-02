<div style="cursor: pointer" id="part-faq-{{isset($faq) ? (is_array($faq) ? $id : $faq->id) : $id}}" class="card">
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
            <button data-id="{{isset($faq) ? (is_array($faq) ? $id : $faq->id) : $id}}" class="remove-part-faq btn btn-outline-danger border-0" style="margin-left: auto" type="button" title="" data-bs-original-title="btn btn-outline-danger" data-original-title="btn btn-outline-danger">Remove</button>
        </ul>
        <div class="tab-content" id="myTabContent">
            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                <div class="tab-pane fade {{$loop->first ? 'active show' : ''}}"
                     id="{{$localeCode}}-{{$id}}-spec" role="tabpanel"
                     aria-labelledby="{{$localeCode}}-tab-{{$id}}-spec">
                    <div class="mb-0 m-t-30 row">
                        <div class="col-md-12">
                            <label for="faqs[{{isset($faq) ? (is_array($faq) ? $id : $faq->id) : $id}}][question:{{$localeCode}}]"
                                   class="col-form-label">Question</label>
                            <textarea id="faqs[{{isset($faq) ? (is_array($faq) ? $id : $faq->id) : $id}}][question:{{$localeCode}}]"
                                      class="form-control"
                                      name="faqs[{{isset($faq) ? (is_array($faq) ? $id : $faq->id) : $id}}][question:{{$localeCode}}]" cols="30"
                                      rows="5">{{ isset($faq) ? $faq->translate($localeCode)?->question : '' }}</textarea>
                        </div>
                        <div class="col-md-12 mt-3">
                            <label for="faqs[{{isset($faq) ? (is_array($faq) ? $id : $faq->id) : $id}}][answer:{{$localeCode}}]"
                                   class="col-form-label">Answer</label>
                            <textarea id="faqs[{{isset($faq) ? (is_array($faq) ? $id : $faq->id) : $id}}][answer:{{$localeCode}}]"
                                      class="form-control"
                                      name="faqs[{{isset($faq) ? (is_array($faq) ? $id : $faq->id) : $id}}][answer:{{$localeCode}}]" cols="30"
                                      rows="5">{{ isset($faq) ? $faq->translate($localeCode)?->answer : '' }}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
