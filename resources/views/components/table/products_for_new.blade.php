<div class="form-group col-sm-6 tab-pane input-block table-data-items" x-data="table_products" data-for-tab="{{$tab}}">
    <div class="table-items">
        <div class="table-item item-head">
            <div class="item" style="width: 30%">Виберіть товар</div>
            <div class="item" style="width: 60%">Сортування</div>
            <div class="item" style="width: 10%; text-align: center">Дія</div>
        </div>

        <div class="table-item">
            <div class="item" style="width: 30%">
                <div class="flex-row input">
                    <div class="input-group input-list-search" style="position: relative;">
                            <input type="hidden" name="products[0][product_id]" value="">
                        <input
                            class="ignore_form"
                            name="products[0][product_id]"
                            placeholder="Пошук..."
                            autocomplete="off"
                            value=""
                            data-url="{{route('getProducts')}}"
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
                        <input type="number"  placeholder="" name="input-number" aria-label="Username" value="0" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>
            <div class="item rm-item" style="width: 10%">
                <div class="icon">
                    <i class="bi bi-x-lg fs-20"></i>
                </div>
            </div>
        </div>

        <div class="table-item item-footer">
            <div class="item" style="width: 30%; border: none"></div>
            <div class="item" style="width: 60%"></div>
            <div class="item add-item" style="width: 10%">
                <div class="icon">
                    <i class="bi bi-plus-lg fs-20"></i>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('table_products', () => ({
            count_products: 0,

        }))
    })

</script>
