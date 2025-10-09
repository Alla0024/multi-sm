<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="options-table">
            <thead>
            <tr>
                <form class="search-form" id="search_form" method="GET" action="">
                    @if(isset($fields))

                        <th width="85">
                            <div class="input-block input-toggle flex">
                                <div class="form-check form-switch">
                                    <input class="form-check-input checkbox-father" data-content="" name="input-toggle" type="checkbox" role="switch" id="switchCheckChecked">
                                    <i class="bi bi-check-all"></i>
                                </div>
                            </div>
                        </th>


                        @foreach($fields as $index => $field)
                            @if($index != 'id' && $field['inTable'])
                                <th class="">
                                    @if(isset($field['searchable']) && $field['searchable'])
                                        <div class="search-name-input">{{ $word['title_'.$index] }}</div>
                                        @if($index == 'status')
                                            <select class="" name="{{ $index }}" aria-label="{{ $word['search_'.$index] }}" aria-describedby="select-addon">
                                                <option value=""  selected hidden>{{ $word['search_'.$index] }}</option>
                                                <option value="1" @if(request($index) == '1') selected @endif>{{$word['status_1']}}</option>
                                                <option value="0" @if(request($index) == '0') selected @endif>{{$word['status_0']}}</option>
                                            </select>
                                        @elseif($index == 'appears_in_categories')
                                            <div class="input-group input-tags table-search-input-multi">
                                                <select form="search_form" class="tag-select" id="multiple_search" name="appears_in_categories[]" data-no-search="true" multiple data-url="">
                                                    @foreach($categories as $item)
                                                        <option value="{{$item['id']}}" @if(in_array($item['id'], explode(',', request($index)))) selected @endif>{{$item['text']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @else
                                            <div class="">
                                                <input type="text" name="{{ $index }}" placeholder="{{ $word['search_'.$index] }}" value="{{ request($index) }}">
                                            </div>
                                        @endif
                                    @endif
                                </th>
                            @endif
                        @endforeach
                    @endif

                    @if(request()->has('language_id'))
                        <input type="hidden" name="language_id" value="{{ request('language_id') }}">
                    @endif
                    @if(request()->has('sortBy'))
                        <input type="hidden" name="sortBy" value="{{ request('sortBy') }}">
                    @endif
                    @if(request()->has('perPage'))
                        <input type="hidden" name="perPage" value="{{ request('perPage') }}">
                    @endif

                    <th class="butt-action action-item">
                        <div class="butt-action-block">
                            <div class="name-action">
                                Дії
                            </div>
                            <div class="action-block-search">
                                <button class="btn btn-primary search-change-butt" type="submit" style="margin: 0 auto 6px">
                                    <svg style="margin-right: 4px; margin-bottom: 2px" xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                                        <path d="M10.6429 10.57L8.113 8.04055C8.84627 7.16021 9.21192 6.03106 9.13388 4.888C9.05583 3.74494 8.54011 2.67596 7.69399 1.90345C6.84787 1.13094 5.7365 0.714377 4.59107 0.740408C3.44564 0.76644 2.35434 1.23307 1.54419 2.04322C0.734043 2.85337 0.267417 3.94467 0.241385 5.0901C0.215353 6.23553 0.63192 7.3469 1.40443 8.19302C2.17694 9.03913 3.24591 9.55486 4.38898 9.6329C5.53204 9.71094 6.66119 9.34529 7.54153 8.61202L10.0709 11.1419C10.1085 11.1795 10.1531 11.2093 10.2022 11.2296C10.2512 11.2499 10.3038 11.2604 10.3569 11.2604C10.41 11.2604 10.4626 11.2499 10.5117 11.2296C10.5608 11.2093 10.6054 11.1795 10.6429 11.1419C10.6805 11.1044 10.7103 11.0598 10.7306 11.0107C10.7509 10.9617 10.7614 10.9091 10.7614 10.856C10.7614 10.8028 10.7509 10.7502 10.7306 10.7012C10.7103 10.6521 10.6805 10.6075 10.6429 10.57ZM1.05984 5.19686C1.05984 4.47733 1.27321 3.77396 1.67296 3.1757C2.0727 2.57743 2.64088 2.11114 3.30564 1.83579C3.97039 1.56044 4.70187 1.4884 5.40757 1.62877C6.11327 1.76914 6.7615 2.11563 7.27028 2.62441C7.77906 3.13319 8.12555 3.78142 8.26592 4.48712C8.40629 5.19282 8.33425 5.9243 8.0589 6.58906C7.78355 7.25381 7.31726 7.82199 6.71899 8.22174C6.12073 8.62148 5.41736 8.83485 4.69783 8.83485C3.73331 8.83378 2.80859 8.45015 2.12657 7.76812C1.44455 7.0861 1.06091 6.16138 1.05984 5.19686Z" fill="white"/>
                                    </svg>{{ $word['search_change'] }}
                                </button>
                                <a class="cast-butt" href="{{ route('options.index') }}">
                                    <svg style="margin-right: 4px; margin-top: 2px" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                        <path d="M9.85348 9.14602C9.89993 9.19247 9.93678 9.24762 9.96192 9.30831C9.98706 9.36901 10 9.43406 10 9.49975C10 9.56544 9.98706 9.63049 9.96192 9.69119C9.93678 9.75188 9.89993 9.80703 9.85348 9.85348C9.80703 9.89993 9.75188 9.93678 9.69119 9.96192C9.63049 9.98706 9.56544 10 9.49975 10C9.43406 10 9.36901 9.98706 9.30831 9.96192C9.24762 9.93678 9.19247 9.89993 9.14602 9.85348L5 5.70683L0.85398 9.85348C0.760165 9.9473 0.632925 10 0.50025 10C0.367576 10 0.240335 9.9473 0.14652 9.85348C0.0527047 9.75966 2.61533e-09 9.63242 0 9.49975C-2.61533e-09 9.36707 0.0527047 9.23983 0.14652 9.14602L4.29316 5L0.14652 0.85398C0.0527047 0.760165 0 0.632925 0 0.50025C0 0.367576 0.0527047 0.240335 0.14652 0.14652C0.240335 0.0527047 0.367576 0 0.50025 0C0.632925 0 0.760165 0.0527047 0.85398 0.14652L5 4.29316L9.14602 0.14652C9.23983 0.0527047 9.36707 -2.61533e-09 9.49975 0C9.63242 2.61533e-09 9.75966 0.0527047 9.85348 0.14652C9.9473 0.240335 10 0.367576 10 0.50025C10 0.632925 9.9473 0.760165 9.85348 0.85398L5.70683 5L9.85348 9.14602Z" fill="#81A4FF"/>
                                    </svg>
                                    {{ $word['cancel'] }}
                                </a>
                            </div>
                        </div>
                    </th>
                </form>
            </tr>
            </thead>
            <tbody>
{{--            @dump($options)--}}
            @foreach($options as $option)
                <tr>
                    <th>
                        <div class="input-block input-toggle flex">
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox-child" data-content="{{$option['id']}}" name="input-toggle_{{$option['id']}}" type="checkbox" role="switch" id="switchCheckChecked_{{$option['id']}}">
                            </div>
                        </div>
                    </th>
                    @foreach($fields as $index => $field)
                        @if($index == 'status')
                            @if($option[$index] == 1)
                                <td><div class="status_active">{{ $word['status_0'] }}</div></td>
                            @else
                                <td><div class="status_enable">{{ $word['status_1'] }}</div></td>
                            @endif
                        @else
                         @if($index != 'id' && $index != 'appears_in_categories' && $index != 'name' && $field['inTable'])
                            <td>{{ $option[$index] }}</td>

                         @elseif($index == 'name')
                                <td style="font-size: 14px; text-align: start">{{ $option[$index] }}</td>
                         @elseif($index == 'appears_in_categories')
                             <td>
                                 <div style="
                                 display: flex;
                                 align-items: start;
                                 flex-wrap: wrap;
                                 width: 100%;
                                 max-width: 580px;
                                 height: auto;
                                 row-gap: 4px;
                                 margin: 0 auto;
                                 font-size: 12px;
                                 ">
                                 @foreach($option[$index] as $category)
                                     <div style="
                                        background: #eaebf0;
                                        padding: 2px 4px;
                                        margin: 1px 4px;
                                        height: 20px;
                                        border: 1px solid #ACACACFF;
                                        border-radius: 4px;
                                     ">{{$category}}</div>
                                 @endforeach
                                 </div>
                             </td>
                         @endif
                        @endif
                    @endforeach

                    <td  >
                        {!! Form::open(['route' => ['options.destroy', $option->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('options.edit', [$option->id]) }}"
                               class='btn btn-default butt-edit btn-xs'>
                                <i class="bi bi-pencil fs-40"></i>
                            </a>
                            {{--  {!! Form::button('<i class="bi bi-trash fs-20"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $options])
        </div>
    </div>
</div>
