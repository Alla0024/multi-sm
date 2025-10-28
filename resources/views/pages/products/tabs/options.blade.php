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
    }
</style>
<div class="form-group col-sm-6 tab-pane input-block options-block" data-for-tab="options" x-data="options_content" x-init="console.log(product_options)">
    <div class="option-tabs-block">
        <div class="all-tabs">
            <template x-for="item in product_options">
                <div class="item-tab">
                    <div class="name-item " :data-option-tab="'tab_option_' + item.id" x-text="item.descriptions[1].name">

                    </div>
                    <div class="rm-option" :data-option-id="item.id">
                        <i class="bi bi-trash-fill"></i>
                    </div>
                </div>
            </template>
        </div>

        <div class="add-tab">

        </div>


    </div>

    <div class="option-content">
        asd
    </div>

</div>

<script id="payload_product_options" type="application/json">@json($product['options'] ?? [], JSON_UNESCAPED_UNICODE)</script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('options_content', () => ({
            product_options: JSON.parse(document.getElementById('payload_product_options').textContent),
        }))
    })
</script>
