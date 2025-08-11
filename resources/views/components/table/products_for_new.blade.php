<div class="form-group col-sm-6 tab-pane input-block table-data-items" x-data="table_products" data-for-tab="{{$tab}}">
    <div class="table-items" x-init="console.log(products)">
        <div class="table-item item-head">
            <div class="item" style="width: 30%">Виберіть товар</div>
            <div class="item" style="width: 60%">Сортування</div>
            <div class="item" style="width: 10%; text-align: center">Дія</div>
        </div>


        <template x-for='(product, key) in products'>
            <div class="table-item">
                <div class="item" style="width: 30%">
                    <div class="flex-row input">
                        <div class="input-group input-list-search" style="position: relative;">
                            <input type="hidden" :name="'products['+ key +'][id]'" x-model="product.id" :value="product.id">
                            <input
                                class="ignore_form"
                                :name="'products['+ key +'][id]'"
                                placeholder="Пошук..."
                                autocomplete="off"
                                :value="product.text"
                                x-model="product.text"
                                data-url="{{route('getProducts')}}"
                                @input="$store.page.searchSelect($event.target)"
                                @focus="$store.page.searchSelect($event.target)"
                            >
                            <ul class="custom-list hide">
                            </ul>
                            <div class="svg">
                                <img src="/images/common/arrow_select.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item" style="width: 60%">
                    <div class="input">
                        <div class="input-group">
                            <input type="number"  placeholder="" :name="'products['+ key +'][sort_order]'" x-model="product.sort_order"  aria-label="Username" :value="product.sort_order" aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div>
                <div class="item rm-item" style="width: 10%">
                    <div class="icon" @click="deletedItem(key)">
                        <i class="bi bi-x-lg fs-20"></i>
                    </div>
                </div>
            </div>
        </template>

        <div class="table-item item-footer">
            <div class="item" style="width: 30%; border: none"></div>
            <div class="item" style="width: 60%"></div>
            <div class="item add-item" style="width: 10%">
                <div class="icon" @click="addItem()">
                    <i class="bi bi-plus-lg fs-20"></i>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('table_products', () => ({
            products: JSON.parse('@json($news["products"] ?? [])'),

            deletedItem(key){
                console.log(this.products)
                this.products.splice(key, 1);
                console.log(this.products)
            },
            addItem(){
                this.products.push({
                    id: '',
                    sort_order: 0,
                    text: "",
                })
                console.log(this.products)
            },
            setItem(e, key, id, text){
                this.products[key].id = id;
                this.products[key].text = text;
                e.parentElement.classList.add('hide');
                console.log(this.products[key])
                console.log(id)
                console.log(text)
            }
        }))
    })

</script>
