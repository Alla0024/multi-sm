<style>
    .options-block{
        display: flex;
        width: 100%;
        justify-content: space-between;
        column-gap: 30px !important;
        align-items: start !important;
        .option-tabs-block{
            width: 270px;
            flex-shrink: 0;
        }
        .all-tabs{
            display: flex;
            flex-direction: column;
            row-gap: 6px;
        }
        .item-tab{
            display: flex;
            width: 100%;
            justify-content: space-between;
            padding: 10px;
            border: 1px solid #BFBFBF;
            cursor: pointer;
        }
        .item-tab-active{
            background: #6cccff;
            color: white;
        }
        .rm-option{
            color: #ff8fa9;
        }
        .add-tab{
            margin-top: 10px;
        }
        .add-input-block{
            position: relative;
        }
        .input-search{
            border-radius: 4px 4px 0 0;
        }
        .list-items{
            position: absolute;
            left: 0;
            right: 0;
            background: white;
            margin-top: 1px;
            max-height: 100px;
            overflow-y: auto;
            border: 1px solid #BFBFBF;
            border-radius: 4px 4px 0 0;
            z-index: 10;
        }
        .item-list{
            padding: 8px 12px;
            cursor: pointer;
            &:hover{
                background: #f1f1f1;
            }
        }
        .presentation{
            border-color: #888 transparent transparent transparent;
            border-style: solid;
            border-width: 5px 4px 0 4px;
            height: 0;
            margin-left: -4px;
            margin-top: 1px;
            position: absolute;
            font-weight: bolder;
            top: 47%;
            width: 0;
            right: 13px;
        }
        .butt-generate{
            background: #ff8fa9;
            cursor: pointer;
            color: white;
            text-align: center;
            padding: 10px 0;
            border-radius: 0 0 4px 4px;
            transition: ease-in-out 150ms;
            &:hover{
                opacity: 0.9;
            }
        }
        .option-content{
            width: 100%;
        }
        .inputs{
            margin-bottom: 40px;
        }
    }
</style>
<div class="form-group col-sm-6 tab-pane input-block options-block" data-for-tab="options" x-data="options_content" x-init="view()">
    <div class="option-tabs-block">
        <div class="all-tabs">
            <template x-for="(item, key) in product_options">
                <div class="item-tab" :data-id="item.id" @click="active_tab = item.id" :class="{'item-tab-active': active_tab == item.id}">
                    <div class="name-item " :data-option-tab="'tab_option_' + item.id" x-text="item.name">

                    </div>
                    <div class="rm-option" @click="rmItem(key)" :data-option-id="item.id">
                        <i class="bi bi-trash-fill"></i>
                    </div>
                </div>
            </template>
        </div>

        <div class="add-tab">
            <div  class="add-input-block">
                <input
                        type="text"
                        x-model="search"
                        @focus="open = true"
                        @input="open = true"
                        @blur="closeList()"
                        placeholder="Виберіть опцію"
                        class="input-search"
                >
                <b role="presentation" class="presentation"></b>

                <div
                        x-show="open"
                        x-transition
                        class="list-items"
                >
                    <template x-for="item in filtered" :key="item.id">
                        <li
                                @mousedown.prevent="select(item)"
                                class="item-list px-3 py-2 hover:bg-gray-100 cursor-pointer"
                                x-text="item.description.name"
                        ></li>
                    </template>

                    <div x-show="filtered.length === 0" class="item-list">
                        Нічого не знайдено
                    </div>
                </div>
            </div>
        </div>

        <div class="butt-generate" @click="generateProductPriceSortOrder({{$product['id']}})">
            Генерувати сортування
        </div>

    </div>

    <div class="option-content">
        <template x-for="(item, key) in product_options">

            <div class="option hide" :class="{'hide': item.id != active_tab}">

                <div class="inputs">
                    <div class="form-group col-sm-6 input-block" >
                        <label for="c1">1c</label>
                        <div class="flex-row input">
                            <div class="input-group">
                                <input class="form-control" required="" :name="'option['+ item.id + '][c1]'" type="text" :value="item.c1" id="c1">
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-6 input-block mt-3" >
                        <label for="hash">Хеш</label>
                        <div class="flex-row input">
                            <div class="input-group">
                                <input class="form-control" required="" :name="'option['+ item.id + '][hash]'" type="text" :value="item.hash" id="hash">
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-6 input-block">
                        <label for="comment">Коментар</label>
                        <div class="flex-row input lang-block">
                            @foreach($languages as $language)
                                <div class="input-group mt-3">
                                    <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                                    <input type="text" class="form-control" :name="'option['+ item.id + '][option_description][{{$language->id}}][comment]'" x-text="item.comments && item.comments['{{$language->id}}'] ? item.comments['{{$language->id}}'] : ''" cols="50" rows="10"></input>
                                </div>
                            @endforeach
                        </div>
                    </div>


                </div>

                <div class="table table-data-items">
                    <div class="table-items">
                        <div class="table-item item-head">
                            <div class="item" style="">Група значень опцій</div>
                            <div class="item" style="">1c</div>
                            <div class="item" style="">Хеш</div>
                            <div class="item" style="">Значення опцій</div>
                            <div class="item" style="">Сортування</div>
                            <div class="item" style=" text-align: center; width: 51px; flex-shrink: 0">Дія</div>
                        </div>

                        <template x-for='(itemData, keyData) in options_value_group[item.id]'>
                            <div class="table-item">
                                <div class="item">
                                    <div class="input">

                                        <div class="add-input-block"
                                             x-data="{
        openList: false,
        get filteredOptions() {
            const search = itemData.name?.toLowerCase() || '';
            const list = options_key[item.id]?.option_value_groups || [];
            if (!search) return list;
            return list.filter(opt =>
                opt.description.name.toLowerCase().includes(search)
            );
        },
        selectOption(itemOption) {
            setOptionsValueGroups(item.id, keyData, itemData.id, itemOption);
            this.openList = false;
        },
        closeList() {
            setTimeout(() => this.openList = false, 150);
        }
     }">
                                            <input
                                                    type="text"
                                                    x-model="itemData.name"
                                                    @focus="openList = true"
                                                    @input="openList = true"
                                                    @blur="closeList()"
                                                    placeholder="Виберіть опцію"
                                                    class="input-search"
                                            >
                                            <b role="presentation" class="presentation"></b>

                                            <div
                                                    x-show="openList"
                                                    x-transition
                                                    class="list-items"
                                            >
                                                <template x-for="itemOption in filteredOptions" :key="itemOption.id">
                                                    <li
                                                            @mousedown.prevent="selectOption(itemOption)"
                                                            class="item-list"
                                                            x-text="itemOption.description.name"
                                                    ></li>
                                                </template>

                                                <div x-show="filteredOptions.length === 0" class="item-list">
                                                    Нічого не знайдено
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="item">
                                    <div class="input">

                                        <input :name="'option_value_group[' + itemData.id + '][' + item.id + '][с1]'" :value="itemData.c1" type="text">

                                    </div>
                                </div>

                                <div class="item">
                                    <div class="input">

                                        <input :name="'option_value_group[' + itemData.id + '][' + item.id + '][hash]'" :value="itemData.hash" type="text">

                                    </div>
                                </div>

                                <div class="item">
                                    <div class="input">

                                        <input :name="'option_value_group[' + itemData.id + '][' + item.id + '][option_value_id]'" :value="itemData?.option_value?.option_value_id" type="text">

                                    </div>
                                </div>

                                <div class="item">
                                    <div class="input">

                                        <input :name="'option_value_group[' + itemData.id + '][' + item.id + '][sort_order]'" :value="itemData.sort_order" type="number">

                                    </div>
                                </div>

                                <div class="item rm-item" style="width: 51px;">
                                    <div class="icon" @click="deletedItem(keyData)" :id="keyData">
                                        <i class="bi bi-x-lg fs-20"></i>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div class="table-item item-footer">

                            <div class="item add-item" style="width: 51px; margin-left: auto">

                                <div class="icon" @click="addItem()">
                                    <i class="bi bi-plus-lg fs-20"></i>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </template>

    </div>

</div>

<script id="payload_product_options" type="application/json">@json(array_values($product['productOptions']) ?? [], JSON_UNESCAPED_UNICODE)</script>
<script id="payload_options_items" type="application/json">@json($options->values() ?? [], JSON_UNESCAPED_UNICODE)</script>
<script id="payload_options_items_key" type="application/json">@json($options ?? [], JSON_UNESCAPED_UNICODE)</script>
<script id="payload_options_value_group" type="application/json">@json($product['optionValueGroups'] ?? [], JSON_UNESCAPED_UNICODE)</script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('options_content', () => ({
            product_options: JSON.parse(document.getElementById('payload_product_options').textContent),
            options: JSON.parse(document.getElementById('payload_options_items').textContent),
            options_key: JSON.parse(document.getElementById('payload_options_items_key').textContent),
            options_value_group: JSON.parse(document.getElementById('payload_options_value_group').textContent),
            active_tab: JSON.parse(document.getElementById('payload_product_options').textContent)[0].id,

            open: false,
            search: '',

            view(){
                console.log(this.product_options[0])
                console.log(this.options[0])
                console.log(this.options_key[13])
                console.log(this.options_value_group)
            },

            get filtered() {
                return this.options.filter(i =>
                    i.description.name.toLowerCase().includes(this.search.toLowerCase())
                )
            },
            select(item) {
                console.log('Вибрано:', item)
                this.search = ''
                this.product_options.push({
                    'id': item.id,
                    'name': item.description.name,
                    'c1': '',
                    'hide_option': 0,
                    'image_change': false,
                    'hash': '',
                    'comments': [],
                })
                console.log(this.product_options)
                this.open = false
            },

            rmItem(key){
                this.product_options.splice(key, 1);
            },
            closeList() {
                setTimeout(() => this.open = false, 100)
            },

            setOptionsValueGroups(option, key, id, value){
                this.options_value_group[option][key].id = value.id
                this.options_value_group[option][key].name = value.description.name
            },

            addItem() {
                const optionId = this.active_tab

                if (!this.options_value_group[optionId]) {
                    this.options_value_group[optionId] = []
                }

                const newItem = {
                    id: Date.now(),
                    name: '',
                    c1: '',
                    hash: '',
                    sort_order: 1,
                    option_value: null
                }

                this.options_value_group[optionId].push(newItem)

                this.$nextTick(() => {
                    const inputs = document.querySelectorAll('.option:not(.hide) .input-search')
                    if (inputs.length) {
                        inputs[inputs.length - 1].focus()
                    }
                })
            },

            generateProductPriceSortOrder(product_id) {
                axios.post('/api/generateProductPriceSortOrder', {
                    product_id: product_id
                })
                .then(response => {
                    const data = response.data;
                    alert(data.status_text);
                })
                .catch(error => {
                    console.error('Помилка запиту:', error);
                });
            }
        }))
    })
</script>
