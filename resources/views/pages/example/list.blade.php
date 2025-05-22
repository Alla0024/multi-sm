@extends('layouts.app')
@section('content')
    <div class="list-content">

        @include('components.basic.head')

        @include('components.basic.search')

        <div class="items-block">

            <div class="item item-head flex">
                <div class="w-1">Виробник</div>
                <div>Сортування</div>
                <div>Дії</div>
            </div>

            <div class="item flex">
                <div class="w-1">Gutenkauf</div>
                <div>1</div>
                <div class="flex">
                    <a class="btn btn-primary" href="/example/edit"><i class="bi bi-pencil"></i></a>
                    <form action="">
                        <button class="btn btn-danger"><i class="bi bi-x-circle"></i></button>
                    </form>
                </div>
            </div>

            <div class="item flex">
                <div class="w-1">ТИС</div>
                <div >2</div>
                <div class="flex">
                    <a class="btn btn-primary" href="/example/edit"><i class="bi bi-pencil"></i></a>
                    <form action="">
                        <button class="btn btn-danger"><i class="bi bi-x-circle"></i></button>
                    </form>
                </div>
            </div>

            <div class="item flex">
                <div class="w-1">ARBORdrev</div>
                <div>3</div>
                <div class="flex">
                    <a class="btn btn-primary" href="/example/edit"><i class="bi bi-pencil"></i></a>
                    <form action="">
                        <button class="btn btn-danger"><i class="bi bi-x-circle"></i></button>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection
