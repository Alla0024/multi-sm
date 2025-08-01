@extends('layouts.app')
@section('content')
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Різні поля</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Profile</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Contact</button>
        </li>
    </ul>
    <form action="" method="POST" class="tab-content" id="form-save" @submit.prevent="$store.page.ajax($event)">

        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

            <div class="input-block input-default flex">
                <div class="name">
                    Назва
                </div>
                <div class="input">
                    <div class="input-group">
                        <input type="text" placeholder="Username" name="input-default" value="test" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>

            <div class="input-block input-lang flex">
                <div class="name">
                    Назва
                </div>
                <div class="input">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">🤢</span>
                        <input type="text"  placeholder="Username" name="input-lang1" aria-label="Username" value="test" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="20"><rect width="22" height="10" fill="#0057B7"/><rect width="22" height="10" y="10" fill="#FFD700"/></svg>
                        </span>
                        <input type="text"  placeholder="Username" name="input-lang5" aria-label="Username" value="test" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>

            <div class="input-block input-number flex">
                <div class="name">
                    Назва
                </div>
                <div class="input">
                    <div class="input-group">
                        <input type="number"  placeholder="Username" name="input-number" aria-label="Username" value="2" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>

            <div class="input-block input-data flex">
                <div class="name">
                    Дата
                </div>
                <div class="input">
                    <div class="input-group">
                        <input
                            type="date"

                            name="input-date"
                            value="{{ date('Y-m-d') }}"
                            aria-label="Дата"
                            aria-describedby="date-addon"
                        >
                    </div>
                </div>
            </div>

            <div class="input-block input-datetime flex">
                <div class="name">
                    Дата та час
                </div>
                <div class="input">
                    <div class="input-group">
                        <input
                            type="datetime-local"

                            name="input-datetime"
                            value="{{ date('Y-m-d\TH:i') }}"
                            aria-label="Дата та час"
                            aria-describedby="datetime-addon"
                        >
                    </div>
                </div>
            </div>

            <div class="input-block input-textarea flex">
                <div class="name">
                    Назва
                </div>
                <div class="input">
                    <div class="input-group">
                        <textarea  placeholder="Username" name="input-textarea" aria-label="Username" aria-describedby="basic-addon1">test</textarea>
                    </div>
                </div>
            </div>

            <div class="input-block input-textarea-edit flex">
                <div class="name">
                    Назва
                </div>
                <div class="input">
                    <div class="input-group">
                        <textarea class="form-control dynamic-editor" id="editor" placeholder="Username" name="input-textarea-edit" aria-label="Username" aria-describedby="basic-addon1">{!! '<h2>Text</h2>' !!}</textarea>
                    </div>
                </div>
            </div>

            <div class="input-block input-textarea-lang flex">
                <div class="name">
                    Назва
                </div>
                <div class="input">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">🤢</span>
                        <textarea  placeholder="Username" name="input-textarea-lang1" aria-label="Username" aria-describedby="basic-addon1">test</textarea>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="20"><rect width="22" height="10" fill="#0057B7"/><rect width="22" height="10" y="10" fill="#FFD700"/></svg>
                        </span>
                        <textarea  placeholder="Username" name="input-textarea-lang5" aria-label="Username" aria-describedby="basic-addon1">test</textarea>
                    </div>
                </div>
            </div>

            <div class="input-block input-textarea-lang-edit flex">
                <div class="name">
                    Назва
                </div>
                <div class="input">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">🤢</span>
                        <textarea class="form-control dynamic-editor" placeholder="Username" id="editor_lang1" name="input-textarea-lang1" aria-label="Username" aria-describedby="basic-addon1">{!! '<h2>Text</h2>' !!}</textarea>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="20"><rect width="22" height="10" fill="#0057B7"/><rect width="22" height="10" y="10" fill="#FFD700"/></svg>
                        </span>
                        <textarea class="form-control dynamic-editor" placeholder="Username" id="editor_lang2" name="input-textarea-lang5" aria-label="Username" aria-describedby="basic-addon1">{!! '<h2>Text</h2>' !!}</textarea>
                    </div>
                </div>
            </div>

            <div class="input-block input-select flex">
                <div class="name">
                    Виберіть місто
                </div>
                <div class="input">
                    <div class="input-group">
                        <select class="" name="select" aria-label="Місто" aria-describedby="select-addon">
                            <option value="" disabled selected>Оберіть зі списку</option>
                            <option value="kyiv">Київ</option>
                            <option value="lviv">Львів</option>
                            <option value="odesa">Одеса</option>
                            <option value="dnipro">Дніпро</option>
                            <option value="kharkiv">Харків</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="input-block input-list-search flex">
                <div class="name">Назва</div>
                <div class="input" style="position: relative;">
                    <input
                        name="input-list-search"
                        placeholder="Type to search..."
                        autocomplete="off"
                        value="Los Angeles"
                    >
                    <ul class="custom-list hide">
                        @foreach(['San Francisco', 'New York', 'Seattle', 'Los Angeles', 'Chicago'] as $city)
                            <li>{{ $city }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="input-block input-toggle flex">
                <div class="name">Активний</div>
                <div class="input">
                    <div class="form-check form-switch">
                        <input class="form-check-input" name="input-toggle" type="checkbox" role="switch" id="switchCheckChecked" checked>
                    </div>
                </div>
            </div>

            <div class="input-block input-tags flex">
                <div class="name">Тип матраца</div>
                <div class="input">
                    <select class="tag-select" name="mattress_types[]" multiple>
                        <option value="1">Безпружинний</option>
                        <option value="2" selected>На залежних пружинах</option>
                        <option value="3">На незалежних пружинах</option>
                        <option value="4" selected>Скручується в рулон</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">

            asdasdasd

        </div>

        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">

            ..34.

        </div>

    </form>

    <button type="submit" class="btn btn-primary" form="form-save">Зберегти і вийти</button>
@endsection
