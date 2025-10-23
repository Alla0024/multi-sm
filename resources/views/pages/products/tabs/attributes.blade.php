<!-- Attributes table Field -->
@php
    $arrData = [
        'text' => ['type' => 'string', 'name' => 'Зображення', 'description' => false],
    ];
@endphp

<div class="form-group col-sm-6 tab-pane input-block table-data-items" x-data="table_products_attributes"  data-for-tab="attributes">

    <div class="table-items">

        <div class="table-item item-head">
            <div class="item" style="">Атрибути</div>
            <div class="item" style="">Текст</div>
            <div class="item" style="">Мініатюра</div>
            <div class="item" style=" text-align: center; width: 51px; flex-shrink: 0">Дія</div>
        </div>

        <template x-for='(itemData, keyData) in data'>

            <div class="table-item">

                <div class="item">
                    <div class="input">

                        <template x-if="!itemData?.attribute_search">
                            <div class="input-group">
                                <input type="text ignore_form" disabled name=""  :value="itemData['group']['name'] + ' > ' + itemData['attribute']['name']" >
                            </div>
                        </template>

                        <template x-if="itemData?.attribute_search">

                            <div class="input-group input-list-search" style="position: relative;">
                                    <input class="ignore_form" type="hidden" name="" value="">
                                <input
                                    class="ignore_form"
                                    name=""
                                    placeholder="Пошук..."
                                    autocomplete="off"
                                    value=""
                                    data-url="{{route('getAttributes')}}"
                                    @input="$store.page.searchSelect($event.target)"
                                    @focus="$store.page.searchSelect($event.target)"
                                    custom="false"
                                >
                                <ul class="custom-list hide">

                                </ul>
                                <div class="svg">
                                    <img src="/images/common/arrow_select.png" alt="">
                                </div>
                            </div>

                        </template>



                    </div>
                </div>

                <div class="item">
                    <div class="input lang-block">
                        <template x-for="itemLang in language">
                            <div class="input-group">
                                <template x-if="itemLang.id == 1">
                                    <span class="input-group-text" id="basic-addon1">{!! $word['1'] !!}</span>
                                </template>
                                <template x-if="itemLang.id == 5">
                                    <span class="input-group-text" id="basic-addon1">{!! $word['5'] !!}</span>
                                </template>
                                <template x-if="itemLang.id == 6">
                                    <span class="input-group-text" id="basic-addon1">{!! $word['6'] !!}</span>
                                </template>
                                <input type="text" :name="'attributes[' + keyData + '][description][' + itemLang.id + '][text]'" x-model="itemData['text_with_keys'][itemLang.id]" >
                            </div>
                        </template>
                    </div>
                </div>

                <div class="item">
                    <div class="input">
                        <template x-if="itemData.icons.length > 0">
                            <div class="input-group input-group-icon">
                                <template x-for="icon in itemData.icons">
                                    <div class="icon-item">
                                        <img class="img-icon" :title="icon.description.title" :src="'https://i.svit-matrasiv.com.ua/images/' + icon.image" alt="">
                                        <div class="checkbox">
                                            <input type="checkbox" class="icon-item-input" :checked="icon.value" :name="'attribute_icons[' + keyData + '][]'" :value="icon.id">
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

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

<style>
    .input-group-icon{
        column-gap: 15px;
        row-gap: 10px;
        flex-wrap: wrap !important;
        width: 100%;
        max-width: 440px;
    }
    .icon-item{
        display: flex;
        column-gap: 10px;
        align-items: center;
        padding: 8px;
        border: 1px solid #BFBFBF;
        border-radius: 4px !important;
        background: #f9f9f9;
        flex-shrink: 0;
        .img-icon{
            width: 100%;
            max-width: 50px;
            background: white;
            border: 0.5px solid #BFBFBF;
            border-radius: 4px !important;
        }
        .icon-item-input{
            width: 18px;
            margin-bottom: -1px;
            &:focus{
                outline: none !important;
                box-shadow: none !important;
            }
        }
    }
</style>

<script id="payload_attributes" type="application/json">@json($product['productAttributes'], JSON_UNESCAPED_UNICODE)</script>
<script>
    document.addEventListener('alpine:init', () => {
        console.log(JSON.parse(document.getElementById('payload_attributes').textContent))
        Alpine.data('table_products_attributes', () => ({
            inputType: JSON.parse('@json($inputType ?? [])'),
            data: JSON.parse(document.getElementById('payload_attributes').textContent),
            language: JSON.parse('@json($languages ?? [])'),
            item_count: -1,

            deletedItem(key){
                let newData = {};
                for(let item_key in this.data){
                    if(key != item_key){
                        newData[item_key] = this.data[item_key];
                    }
                }
                this.data = newData;
            },

            addItem(){
                let newItem = {};
                this.data[this.item_count] = {
                    'attribute_search': true,
                    'attribute': {
                        'name': ''
                    },
                    'group': {
                        'name': ''
                    },
                    'icons': [],
                    'mark': 0,
                    'text': {
                        1: '',
                        5: ''
                    },
                    'text_with_keys': {
                        1: '',
                        5: ''
                    }
                }
                this.item_count--;
                console.log(this.data)
            },

            setItem(e, key, id, text){
                // this.data[key].id = id;
                // this.data[key].text = text;
                // e.parentElement.classList.add('hide');
                axios.get('{{route('get_attribute_icons')}}', { params: { id_attribute: id }}).then(response => {
                    console.log(response)
                }).catch(e => console.log(e))
                console.log(e)
                console.log(key)
                console.log(id)
                console.log(text)
            },
        }))
    })
</script>
