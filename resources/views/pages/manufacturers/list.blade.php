@extends('layouts.app')
@section('content')
    <div class="list-content">

        <div class="head-block flex">
            <div class="title-block">
                <div class="title">
                    {{$title ?? ''}}
                </div>
                <div class="description">
                    Всього: 128
                </div>
            </div>
            <div class="butt">
                <form action="">
                    <button class="btn btn-primary" type="submit">Новий запис</button>
                </form>
            </div>
        </div>

        <div class="search-block">
            <form class="flex-row" action="" method="GET">
                <input class="form-control w-5" placeholder="Пошук по назві" type="text" class="w-5">
                <div class="butt">
                    <button class="btn btn-primary" type="submit">Застосувати</button>
                    <a class="btn" href="/">Скинути</a>
                </div>
            </form>
        </div>

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
                    <a class="btn btn-primary" href="/manufacturers/edit"><i class="bi bi-pencil"></i></a>
                    <form action="">
                        <button class="btn btn-danger"><i class="bi bi-x-circle"></i></button>
                    </form>
                </div>
            </div>
            <div class="item flex">
                <div class="w-1">ТИС</div>
                <div >2</div>
                <div class="flex">
                    <a class="btn btn-primary" href="/manufacturers/edit"><i class="bi bi-pencil"></i></a>
                    <form action="">
                        <button class="btn btn-danger"><i class="bi bi-x-circle"></i></button>
                    </form>
                </div>
            </div>
            <div class="item flex">
                <div class="w-1">ARBORdrev</div>
                <div>3</div>
                <div class="flex">
                    <a class="btn btn-primary" href="/manufacturers/edit"><i class="bi bi-pencil"></i></a>
                    <form action="">
                        <button class="btn btn-danger"><i class="bi bi-x-circle"></i></button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
