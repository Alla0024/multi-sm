<style>
    .options-block{
        display: flex;
        width: 100%;
        justify-content: space-between;

        .option-tabs-block{
            width: 270px;
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
    }
</style>
<div class="form-group col-sm-6 tab-pane input-block options-block" data-for-tab="options" x-data="options_content" x-init="view()">
    <div class="option-tabs-block">
        <div class="all-tabs">
            <template x-for="(item, key) in product_options">
                <div class="item-tab" :data-id="item.id" @click="active_tab = item.id" :class="{'item-tab-active': active_tab == item.id}">
                    <div class="name-item " :data-option-tab="'tab_option_' + item.id" x-text="item.descriptions[1].name">

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
        asd
    </div>

</div>

<script id="payload_product_options" type="application/json">@json($product['options'] ?? [], JSON_UNESCAPED_UNICODE)</script>
<script id="payload_options_items" type="application/json">@json($options->values() ?? [], JSON_UNESCAPED_UNICODE)</script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('options_content', () => ({
            product_options: JSON.parse(document.getElementById('payload_product_options').textContent),
            options: JSON.parse(document.getElementById('payload_options_items').textContent),
            active_tab: JSON.parse(document.getElementById('payload_product_options').textContent)[0].id,

            open: false,
            search: '',

            view(){
                console.log(this.product_options[0])
                console.log(this.options[0])
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
                    'descriptions': [{}, item.description],
                    'sort_order': item.sort_order,
                    'type': item.type
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
