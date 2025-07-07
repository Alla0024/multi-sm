@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
      {{ $word['details'] }} {!!  $word['Manufacturer'] !!}
                    </h1>
                </div>
                <div class="col-sm-2">
                    <a class="btn btn-default float-right"
                       href="{{ route('manufacturers.index') }}">
                                                    {{$word['back']}}
                                            </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('pages..manufacturers.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
