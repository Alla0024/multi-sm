<style>
    .add-new-segment{
        color: white;
        padding: 6px 12px;
        cursor: pointer;
        border-radius: 4px;
        background: #6cccff;
        width: max-content;
    }
    .block-segment-items{
        display: flex;
        flex-width: wrap;
        justify-content: center;
        column-gap: 20px;

        .segment-item{
            width: 380px;
            display: flex;
            flex-direction: column;
            border-radius: 8px;
            padding-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .1) !important;

            .head-item{
                background: #a6dbff;
                display: flex;
                padding: 14px;
                justify-content: space-between;
                .name{
                    width: calc(100% - 128px);
                    display: flex;
                    font-size: 20px;
                }
                .butt-action{
                    width: 100px;
                    flex-shrink: 0;
                    align-items: center;
                    display: flex;
                    column-gap: 6px;
                    .edit-butt{
                        width: 40px;
                        height: 40px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 4px;
                        background: #3e60d5;
                        cursor: pointer;
                        color: white;
                    }
                    .check-show-for-sale{
                        height: 40px;
                    }
                }
            }

            .status{
                padding: 14px 20px;
                .status-state{
                    display: flex;
                    column-gap: 18px;
                    align-items: center;
                    margin-bottom: 10px;
                    .state{

                    }
                }
            }
            .products-block{
                padding: 0 20px;
                height: 250px;
                overflow-y: scroll;

                .product-item{
                    background: #f8f9fa;
                    padding: 20px;
                    margin: 10px 0;
                }



            }
        }
    }
</style>
<div class="tab-pane input-block" x-data="sale_segment" style="flex-direction: column; align-items: start; row-gap: 20px" data-for-tab="segment">

    <div class="add-new-segment" @click="newSegment()" style="">
        Створити сегмент
    </div>

    <div class="block-segment-items">
        @if(isset($sale) && count($sale['segments']) > 0)
            @foreach($sale['segments'] as $segment)
                <div class="segment-item">

                    <div class="head-item">
                        <div class="name">
                            {{$segment['description'] ? $segment['description']['name'] : ''}}
                        </div>
                        <div class="butt-action">
                            <div class="edit-butt" @click="getSegment()">
                                <i class="bi bi-pencil fs-40"></i>
                            </div>
                            <div class="check-show-for-sale">
                                <input type="checkbox" @click="saleInSale($event.target, {{$segment['id']}})" class="ignore_form" @if($segment['show_in_sale']) checked @endif style="width: 40px; height: 40px; cursor: pointer;">
                            </div>
                        </div>
                    </div>

                    <div class="status">
                        <div class="status-state">
                            <div class="state">
                                @if($segment['status'])
                                    <div style="padding: 4px 8px; border-radius: 4px; color: white; background: #83bb8a">
                                        Увімкнено
                                    </div>
                                @else
                                    <div style="padding: 4px 8px; border-radius: 4px; color: white; background: #D79898">
                                        Вимкнено
                                    </div>
                                @endif
                            </div>

                            @if(isset($segment['value']) && $segment['value'] > 0)
                                <div class="value-count" style="padding: 4px 8px; border-radius: 4px; color: white; background: #6cccff">
                                        -{{ $segment['value'] }}
                                    @if($segment['type_number'] == 'percent')
                                        %
                                    @else
                                        {{ $word['currency'] }}
                                    @endif
                                </div>
                            @endif

                        </div>
                        <div class="count">
                               Кількість товарів {{$segment['product_count']}}
                        </div>
                    </div>

                    <div class="products-block">
                        <div class="product-item">
                            Матрац безпружинний - R1 в скрутці
                        </div>
                        <div class="product-item">
                            Матрац безпружинний - R1 в скрутці
                        </div>
                        <div class="product-item">
                            Матрац безпружинний - R1 в скрутці
                        </div>
                        <div class="product-item">
                            Матрац безпружинний - R1 в скрутці
                        </div>
                        <div class="product-item">
                            Матрац безпружинний - R1 в скрутці
                        </div>
                        <div class="product-item">
                            Матрац безпружинний - R1 в скрутці
                        </div>
                        <div class="product-item">
                            Матрац безпружинний - R1 в скрутці
                        </div>
                        <div class="product-item">
                            Матрац безпружинний - R1 в скрутці
                        </div>
                    </div>
                </div>
            @endforeach

        @endif
    </div>

    <div id="segmentModal" class="modal-overlay">
        <input id="sale_id" value="@if(isset($sale)){{$sale->id}}@endif" type="hidden">
        <div class="modal-segment-edit">
            <div class="head-block">
                <div class="title" x-text="titleModal">

                </div>
                <div class="close closeSegmentModal" @click="document.querySelector('#segmentModal').classList.remove('active');">
                    <i class="bi bi-x me-3 fs-20"></i>
                </div>
            </div>

            <div class="segment-edit">
                <div class="form-group col-sm-6 input-block">
                    <label for="description">Назва</label>
                    <div class="flex-row input input-min lang-block">
                        @foreach($languages as $language)
                            <div class="input-group mt-3">
                                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                                <input type="text" class="form-control" name="description[{{$language->id}}][name]" :value="segmentDataDescriptions['{{$language->id}}'] && segmentDataDescriptions['{{$language->id}}']['name'] ? segmentDataDescriptions['{{$language->id}}']['name'] : ''"  cols="50" rows="10">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group col-sm-6 input-block mt-3">
                    <label for="status">Статус</label>
                    <div class="flex-row input input-min">
                        <div class="input-group">
                            <select  name="status" class="form-control">
                                <option :selected="segmentData.status == false" value="0">Вимкнено</option>
                                <option :selected="segmentData.status == true" value="1">Увімкнено</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-6 input-block mt-3">
                    <label for="choose_price">Ціна</label>
                    <div class="flex-row input input-min">
                        <div class="input-group">
                            <select  name="choose_price" class="form-control">
                                <option :selected="segmentData.choose_price == 0" value="0">Максимум</option>
                                <option :selected="segmentData.choose_price == 1" value="1">Мінімум</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-6 input-block mt-3">
                    <label for="calculation_from">Розрахунок від</label>
                    <div class="flex-row input input-min">
                        <div class="input-group">
                            <select  name="calculation_from" class="form-control">
                                <option :selected="segmentData.calculation_from == 0" value="0">Акція</option>
                                <option :selected="segmentData.calculation_from == 1" value="1">Ціна</option>
                                <option :selected="segmentData.calculation_from == 2" value="2">Маржа</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-6 input-block mt-3">
                    <label for="product_count">Кількість товарів</label>
                    <div class="flex-row input input-min">
                        <div class="input-group">
                            <input class="form-control" name="product_count" type="text" :value="segmentData.product_count" >
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-6 input-block mt-3">
                    <label for="value">Значення </label>
                    <div class="flex-row input input-min">
                        <div class="input-group">
                            <input class="form-control" name="value" type="text" :value="segmentData.value" >
                        </div>
                    </div>
                    <div class="flex-row input input-min">
                        <div class="input-group">
                            <select  name="type_number" class="form-control">
                                <option :selected="segmentData.type_number == 'percent'" value="0">Процент %</option>
                                <option :selected="segmentData.type_number == 'fixed_number'" value="1">Фіксоване число</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="add-products-block">

                    <div class="section-head">
                        Додати товар
                    </div>

                    <div class="add-items">

                        <div class="search-input">

                            <div class="input-block">
                                <div class="name">
                                    Виробник
                                </div>
                                <div class="flex-row input input-block">
                                    <div class="input-group input-list-search" style="position: relative;">
                                        <input type="hidden" name="search_manufacturer_id" id="manufacturer_id" x-ref="manufacturer_search"  value="all">
                                        <input
                                                class="ignore_form"
                                                name="search_manufacturer_id"
                                                placeholder="Пошук по виробника"
                                                autocomplete="off"
                                                value=""
                                                data-url="{{route('getManufacturers')}}"
                                                @input="$store.page.searchSelect($event.target)"
                                                @focus="$store.page.searchSelect($event.target)"
                                                custom="method"
                                        >
                                        <ul class="custom-list hide">

                                        </ul>
                                        <div class="svg">
                                            <img src="/images/common/arrow_select.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="input-block mt-3">
                                <div class="name">
                                    Пошук по назві
                                </div>
                                <div class="input">
                                    <input class="input-sale-search" type="text" x-model="search" @input="setItem()" placeholder="ID або назва">
                                </div>
                            </div>

                            <div class="input-block mt-3">
                                <div class="name">
                                    Категорія
                                </div>
                                <div class="flex-row input input-block">
                                    <div class="input-group input-list-search" style="position: relative;">
                                        <input type="hidden" name="search_category_id" id="category_id" x-ref="category_search" value="all">
                                        <input
                                                class="ignore_form"
                                                name="search_category_id"
                                                placeholder="Пошук по категорії"
                                                autocomplete="off"
                                                value=""
                                                data-url="{{route('getCategories')}}"
                                                @input="$store.page.searchSelect($event.target)"
                                                @focus="$store.page.searchSelect($event.target)"
                                                custom="method"
                                        >
                                        <ul class="custom-list hide">

                                        </ul>
                                        <div class="svg">
                                            <img src="/images/common/arrow_select.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="items-block">

                            <div class="item item-head">
                                <div class="input-check-all">
                                    <input class="ignore_form" type="checkbox" id="check-all" name="check-all" @change="toggleSelectAll">
                                    <label for="check-all"> Виділити всі </label>
                                </div>
                                <div class="butt-add-items" @click="addItem()">
                                    Додати виділене
                                </div>
                            </div>

                            <div class="items">
                                <template x-if="dataItemsView">
                                    <template x-for="(item, key) in dataItemsView" :key="item.id">
                                        <div class="item">
                                            <div class="input-check">
                                                <input class="ignore_form" type="checkbox" :id="'check_'+item.id" :name="'check_'+item.id">
                                                <label :for="'check_'+item.id" x-text="item.id + ' - ' + item?.description?.name"></label>
                                            </div>
                                        </div>
                                    </template>
                                </template>

                            </div>

                        </div>
                    </div>

                    <div class="table-view-items table-data-items">

                        <div class="table-items">
                            <div class="table-item item-head">
                                <div class="item" style="flex-shrink: 0; width: 60px">Id</div>
                                <div class="item" style="">Назва</div>
                                <div class="item" >Модель</div>
                                <div class="item" >Категорія</div>
                                <div class="item" style=" text-align: center; width: 51px; flex-shrink: 0">Дія</div>
                            </div>

                            <template x-if="data">
                                <template x-for='(itemData, keyData) in data'>
                                    <div class="table-item">
                                        <div class="item" style="flex-shrink: 0; width: 60px;">
                                            <div x-text="itemData.id">

                                            </div>
                                            <input type="hidden" :name="'specifics[' + itemData.id + '][category]'" :value="itemData.category.id">
                                        </div>

                                        <div class="item">
                                            <div x-text="itemData.description.name">

                                            </div>
                                        </div>

                                        <div class="item" >
                                            <div x-text="itemData.article">

                                            </div>
                                        </div>

                                        <div class="item" >
                                            <div x-text="itemData.category.description.name">

                                            </div>
                                        </div>

                                        <div class="item rm-item" style="width: 51px;">
                                            <div class="icon" @click="deletedItem(keyData)" :id="keyData">
                                                <i class="bi bi-x-lg fs-20"></i>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </template>

                        </div>

                    </div>
                </div>

                <div class="butt-save" @click="saveSegment()">
                    Зберегти
                </div>

            </div>

        </div>
    </div>

</div>


<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('sale_segment', () => ({
            segmentData: {},
            segmentDataDescriptions: {},
            search: '',
            titleModal: 'Редагувати сегменту',
            dataItemsView: '',
            data: [],

            saleInSale(e, id){
                const formData = new FormData();

                formData.append('sale_id', {{$sale['id']}});
                formData.append('show_in_sale', e.checked ? 1 : 0);

                axios.post(`{{url('/')}}/aikqweu/segments/${id}`, formData)
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },

            getSegment(){
                axios.get(`http://multi/aikqweu/segments/6/edit`)
                    .then(response => {
                        this.segmentData = response.data.segment;
                        this.segmentDataDescriptions = response.data.descriptions;
                        this.titleModal = 'Редагувати сегмент';
                        document.querySelector('#segmentModal').classList.add('active');
                        console.log(this.segmentDataDescriptions)
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },

            newSegment(){
                this.titleModal = 'Створити сегмент';
                document.querySelector('#segmentModal').classList.add('active');
                console.log(this.segmentDataDescriptions)
            },

            setItem(){
                const form = new FormData();
                form.append('manufacturer_id', this.$refs.manufacturer_search.value);
                form.append('search', this.search);
                form.append('category_id', this.$refs.category_search.value);
                axios.post('{{route('getSegmentProducts')}}', form)
                    .then(r => {
                        console.log(r)
                        this.dataItemsView = r.data.products
                    })
                    .catch(e => console.log(e))
            },

            addItem() {
                // знайти всі чекбокси, які відмічені
                const checkedBoxes = document.querySelectorAll('.items-block input[type="checkbox"]:checked');
                checkedBoxes.forEach(box => {
                    const id = parseInt(box.id.replace('check_', ''), 10);
                    const itemToAdd = this.dataItemsView.find(i => i.id === id);

                    // перевірити, чи вже є в таблиці
                    const alreadyExists = this.data.some(i => i.id === id);
                    if (!alreadyExists && itemToAdd) {
                        // додаємо копію елемента
                        this.data.push(JSON.parse(JSON.stringify(itemToAdd)));
                    }

                    // зняти позначку
                    box.checked = false;
                });
            },

            toggleSelectAll(event) {
                const isChecked = event.target.checked;
                this.dataItemsView.forEach(item => {
                    const box = document.querySelector(`#check_${item.id}`);
                    if (box) box.checked = isChecked;
                });
            },

            saveSegment(){

                const container = document.querySelector('#segmentModal');

                const formData = new FormData();

                container.querySelectorAll('input:not([type="checkbox"]), select, textarea').forEach(el => {
                    const name = el.name || el.id;
                    if (name) formData.append(name, el.value);
                });

                axios.post('/your/api/url', formData)
                    .then(response => {
                        console.log('✅ Успішно:', response.data);
                    })
                    .catch(error => {
                        console.error('❌ Помилка:', error);
                    });

            }
        }))
    })
</script>
