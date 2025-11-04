<style>
    .table-sales-program{
        flex-direction: column;
        row-gap: 40px;
        .add-items{
            display: flex;
            width: 100%;
            justify-content: space-between;
            .input-block{
                align-items: center;
                .name{
                    width: 90px;
                }
                .input-sale-search{
                    width: 230px;
                }
            }

            .items-block{
                width: 100%;
                max-width: 1000px;
                height: 400px;
                background: #f5f5f5;
                overflow: hidden;
                .item-head{
                    display: flex;
                    align-items: center;
                }
                .input-check-all{
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                    column-gap: 10px;
                }
                input[type='checkbox']{
                    width: 20px;
                    cursor: pointer;
                }
                input[type='checkbox']:focus{
                    box-shadow: none !important;
                }
                .butt-add-items{
                    cursor: pointer;
                    background: #3e60d5;
                    padding: 6px 16px;
                    color: white;
                    border-radius: 4px;
                }
                .items{
                    height: 100%;
                    overflow-y: scroll;
                    .item{
                        .input-check{
                            display: flex;
                            align-items: center;
                            column-gap: 10px;
                            label{
                                width: 600px;
                            }
                        }
                    }
                }

            }
        }
        .table-view-items{
            width: 100%;
        }
    }
</style>

<div class="form-group col-sm-6 tab-pane table-sales-program" x-data="table_sales_{{$tab ?? ""}}" data-for-tab="{{$tab}}">
    <div class="add-items">
        <div class="search-input">
            <div class="input-block">
               <div class="name">
                   Пошук
               </div>
                <div class="input">
                    <input class="input-sale-search" type="text" x-model="search" placeholder="ID або назва">
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
                <template x-for="(item, key) in dataItemsView" :key="item.id">
                    <div class="item">
                        <div class="input-check">
                            <input class="ignore_form" type="checkbox" :id="'check_'+item.id" :name="'check_'+item.id">
                            <label :for="'check_'+item.id" x-text="item.id + ' - ' + item?.description?.name"></label>
                        </div>
                    </div>
                </template>
            </div>

        </div>
    </div>

    <div class="table-view-items table-data-items">

        <div class="table-items">
            <div class="table-item item-head">
                <div class="item" style=" width: 100px">Id</div>
                <div class="item" style="">Назва</div>
                <div class="item" style="width: 160px">Порядок сортування</div>
                <div class="item" style=" text-align: center; width: 51px; flex-shrink: 0">Дія</div>
            </div>

            <template x-for='(itemData, keyData) in data'>
                <div class="table-item">
                    <div class="item" style="width: 100px;">
                        <div x-text="itemData.id">

                        </div>
                        <input type="hidden" :name="'{{$name}}[' + itemData.id + '][id]'" :value="itemData['id']">
                    </div>

                    <div class="item">
                        <div x-text="itemData.description.name">

                        </div>
                    </div>

                    <div class="item" style="width: 160px">
                        <div class="input">
                            <input type="number" :name="'{{$name}}[' + itemData.id + '][sort_order]'" x-model="itemData['sort_order'] ?? 0">
                        </div>
                    </div>

                    <div class="item rm-item" style="width: 51px;">
                        <div class="icon" @click="deletedItem(keyData)" :id="keyData">
                            <i class="bi bi-x-lg fs-20"></i>
                        </div>
                    </div>
                </div>
            </template>

        </div>

    </div>
</div>

<script id="payload_group_{{$name}}" type="application/json">@json($data, JSON_UNESCAPED_UNICODE)</script>
<script id="payload_group_items_{{$name}}" type="application/json">@json($dataItems ?? '', JSON_UNESCAPED_UNICODE)</script>

<script>
    document.addEventListener('alpine:init', () => {

        console.log(JSON.parse(document.getElementById('payload_group_{{$name}}').textContent))
        console.log(JSON.parse(document.getElementById('payload_group_items_{{$name}}').textContent))

        Alpine.data('table_sales_{{$tab ?? ""}}', () => ({
            search: '',
            data: JSON.parse(document.getElementById('payload_group_{{$name}}').textContent),
            dataItems: JSON.parse(document.getElementById('payload_group_items_{{$name}}').textContent),
            {{--dataItemsView: JSON.parse(document.getElementById('payload_group_items_{{$name}}').textContent),--}}

            get dataItemsView() {
                if (!this.search.trim()) return this.dataItems;
                const term = this.search.toLowerCase().trim();
                return this.dataItems.filter(item => {
                    const idMatch = item.id.toString().includes(term);
                    const nameMatch = item?.description?.name?.toLowerCase().includes(term);
                    return idMatch || nameMatch;
                });
            },

            addItem() {
                // знайти всі чекбокси, які відмічені
                const checkedBoxes = document.querySelectorAll('.items-block input[type="checkbox"]:checked');
                checkedBoxes.forEach(box => {
                    const id = parseInt(box.id.replace('check_', ''), 10);
                    const itemToAdd = this.dataItems.find(i => i.id === id);

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
                // пройдемо всі чекбокси тільки тих елементів, які зараз у списку (dataItemsView)
                this.dataItemsView.forEach(item => {
                    const box = document.querySelector(`#check_${item.id}`);
                    if (box) box.checked = isChecked;
                });
            },

            deletedItem(key){
                this.data.splice(key, 1);
            },
        }))
    })
</script>
