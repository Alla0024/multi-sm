<div class="form-group col-sm-6 tab-pane input-block table-data-items" x-data="table_products_{{$search_select_type ?? ""}}"  data-for-tab="{{$tab}}">

    <div class="table-items" x-init="parseData()">

        <div class="table-item item-head">
            <template x-for='(item, key) in inputType'>
                <div class="item" style=""
                     :class='{
                     "custom-type-switch": item.type == "switch",
                     "custom-type-number": item.type == "number",
                     "custom-type-multi": item.type == "multi_select_static_filter",
                     "custom-type-select-oversize": item.type == "select_oversize",
                     }'
                     x-text="item.name"></div>
            </template>
            <div class="item" style=" text-align: center; width: 51px; flex-shrink: 0">Дія</div>
        </div>

        <template x-for='(itemData, keyData) in data'>

            <div class="table-item">
                <input type="hidden" :class="{'ignore_form': !itemData.id}" :name="'{{$name}}[' + keyData + '][{{$id_name}}]'" :value="itemData['{{$id_name}}']">

                <template x-for='(itemInput, keyInput) in inputType'>
                    <div class="item"
                         :class='{
                         "custom-type-switch": itemInput.type == "switch",
                         "custom-type-number": itemInput.type == "number",
                         "custom-type-multi": itemInput.type == "multi_select_static_filter",
                         "custom-type-select-oversize": itemInput.type == "select_oversize",
                         }'
                    >

                        <template x-if="keyInput in itemData">
                            <div class="input">

                                <template x-if="itemInput.type == 'string'">
                                    <div class="input-group">
                                        <input type="text" :name="'{{$name}}[' + keyData + '][' + keyInput + ']'" x-model="itemData[keyInput]" :value="itemData[keyInput]" >
                                    </div>
                                </template>

                                <template x-if="itemInput.type == 'number'">
                                    <div class="input-group">
                                        <input type="number" :name="'{{$name}}[' + keyData + '][' + keyInput + ']'" x-model="itemData[keyInput]" :value="itemData[keyInput]" >
                                    </div>
                                </template>

                                <template x-if="itemInput.type == 'select_oversize'">
                                    <div class="input-group">
                                        <select :name="'{{$name}}[' + keyData + '][' + keyInput + ']'" class="form-control">
                                            <option :selected="itemData[keyInput] == '='" value="=">=</option>
                                            <option :selected="itemData[keyInput] == '%'" value="%">%</option>
                                            <option :selected="itemData[keyInput] == '*'" value="*">*</option>
                                            <option :selected="itemData[keyInput] == '+'" value="+">+</option>
                                        </select>
                                    </div>
                                </template>

                                <template x-if="itemInput.type == 'image'">
                                    <div class="input-group image-block" x-data="{open_butt: false}">
                                        <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
                                            <input :id="'thumbnail_'+keyData + ''+ keyInput" type="hidden" :name="'{{$name}}[' + keyData + '][' + keyInput + ']'" x-model="itemData[keyInput]" >
                                            <img class="" x-model.src="itemData[keyInput]" :src="itemData[keyInput] && itemData[keyInput] !== '' ? 'https://i.svit-matrasiv.com.ua/storage/images/'+itemData[keyInput] : '/images/common/no_images.png'" :id="'holder_'+keyData + ''+ keyInput" alt="Прев’ю" style="max-width: 200px;">
                                            <div class="butt hide" :class="{'show': open_butt}">
                                                <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" :data-input="'thumbnail_'+keyData + ''+ keyInput" :data-preview="'holder_'+keyData + ''+ keyInput" data-path=""><i class="bi bi-arrow-up-square"></i></div>
                                                <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="itemInput.type == 'pdf'">
                                    <div class="input-group image-block" x-data="{open_butt: false}">
                                        <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
                                            <input :id="'thumbnail_'+keyData + ''+ keyInput" type="hidden" :name="'{{$name}}[' + keyData + '][' + keyInput + ']'" x-model="itemData[keyInput]" >
                                            <input style="width: 400px;" disabled x-model="itemData[keyInput]" >
                                            <img style="display: none" class="" x-model.src="itemData[keyInput]" :src="itemData[keyInput] && itemData[keyInput] !== '' ? 'https://i.svit-matrasiv.com.ua/storage/images/'+itemData[keyInput] : '/images/common/no_images.png'" :id="'holder_'+keyData + ''+ keyInput" alt="Прев’ю" style="max-width: 200px;">
                                            <div class="butt" >
                                                <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" :data-input="'thumbnail_'+keyData + ''+ keyInput" :data-preview="'holder_'+keyData + ''+ keyInput" data-path=""><i class="bi bi-pencil"></i></div>
                                                <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="itemInput.type == 'imageVideo'">
                                    <div class="input-group">
                                        <img class="" :src="'https://img.youtube.com/vi/' + itemData.url + '/maxresdefault.jpg'"  alt="Прев’ю" style="max-width: 200px;">
                                    </div>
                                </template>

                                <template x-if="itemInput.type == 'switch'">
                                    <div class="input-block input-toggle flex">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input checkbox-child" :name="'{{$name}}[' + keyData + '][' + keyInput + ']'" data-content="" :checked="+itemData[keyInput]" x-model="+itemData[keyInput]" @click = "itemData[keyInput] = !itemData[keyInput]"  type="checkbox"  :id="'{{$name}}[' + keyData + '][' + keyInput + ']'">
                                        </div>
                                    </div>
                                </template>

                                <template x-if="itemInput.type == 'search_select_static_filter'">
                                    <div class="input-group input-list-search" style="position: relative;">
                                        <input type="hidden" :name="'{{$name}}[' + keyData + '][parent_id]'" x-model="itemData['parent_id']" :value="itemData['parent_id']">
                                        <input
                                                class="ignore_form"
                                                :name="'{{$name}}[' + keyData + '][parent_id]'"
                                                placeholder="Пошук..."
                                                autocomplete="off"
                                                :value="itemData[keyInput]"
                                                x-model="itemData[keyInput]"
                                                data-url=""
                                                @input="$store.page.searchSelect($event.target)"
                                                @focus="$store.page.searchSelect($event.target)"
                                                custom="true"
                                        >
                                        <ul class="custom-list hide">
                                            <template x-for="listItem in data">
                                                <li :id="listItem.id" x-text="listItem.descriptions[5].name"></li>
                                            </template>
                                        </ul>
                                        <div class="svg">
                                            <img src="/images/common/arrow_select.png" alt="">
                                        </div>

                                    </div>
                                </template>

                                <template x-if="itemInput.type == 'search_select'">
                                    <div class="input-group input-list-search" style="position: relative;">
                                        <input type="hidden" :name="'{{$name}}[' + keyData + '][id]'" x-model="itemData['id']" :value="itemData['id']">
                                        <input
                                            class="ignore_form"
                                            :name="'{{$name}}[' + keyData + '][id]'"
                                            placeholder="Пошук..."
                                            autocomplete="off"
                                            :value="itemData[keyInput]"
                                            x-model="itemData[keyInput]"
                                            data-url="@isset($url){{route($url)}}@endisset"
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

                                <template x-if="itemInput.type == 'search_select_categories'">
                                    <div class="input-group input-list-search" style="position: relative;">
                                        <input type="hidden" :name="'{{$name}}[' + keyData + ']['+ {{isset($search_select_type) ? "'".$search_select_type."'" : "'"."id"."'"}} +']'" x-model="itemData['id']" :value="itemData['id']">
                                        <input
                                            class="ignore_form"
                                            :name="'{{$name}}[' + keyData + ']['+ {{isset($search_select_type) ? "'".$search_select_type."'" : "'"."id"."'"}} +']'"
                                            placeholder="Пошук..."
                                            autocomplete="off"
                                            :value="itemData['text']"
                                            x-model="itemData['text']"
                                            data-url="@isset($url){{route($url)}}@endisset"
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

                                <template x-if="itemInput.type == 'multi_select_static_filter'">
                                    <div class="input-group input-tags">

                                        <template x-if="itemData.option_value_groups && Object.keys(itemData.option_value_groups).length > 0">
                                            <select class="tag-select" :name="'{{$name}}[' + keyData + '][option_value_group_id][]'" data-no-search="true" multiple data-url="">
                                                <template x-for="itemMulti in itemData.option_value_groups">
                                                    <option :value="itemMulti.option_value_group_id" selected x-text="dataMultiSelect.find(obj => obj.id == itemMulti.option_value_group_id).description.name"></option>
                                                </template>
                                                <template x-for="itemMulti in dataMultiSelect">
                                                    <option :value="itemMulti.id" x-text="itemMulti.description.name"></option>
                                                </template>
                                            </select>
                                        </template>
                                        <template x-if="!itemData.option_value_groups || Object.keys(itemData.option_value_groups).length == 0">
                                            <select class="tag-select" :name="'{{$name}}[' + keyData + '][option_value_group_id][]'" data-no-search="true" multiple data-url="">
                                                <template x-for="itemMulti in dataMultiSelect">
                                                    <option :value="itemMulti.id" @click="itemData.option_value_groups.push({'filter_id': '', 'option_value_group_id': itemMulti.id})" x-text="itemMulti?.description?.name"></option>
                                                </template>
                                            </select>
                                        </template>

                                    </div>
                                </template>

                            </div>
                        </template>

                        <template x-if="itemData['descriptions'] && keyInput in itemData.descriptions[5]">
                            <div class="input lang-block">

                                <template x-if="itemInput.type == 'string'">
                                    <template x-for="itemLang in language">
                                        <div class="input-group ">
                                            <template x-if="itemLang.id == 1">
                                                <span class="input-group-text" id="basic-addon1">{!! $word['1'] !!}</span>
                                            </template>
                                            <template x-if="itemLang.id == 5">
                                                <span class="input-group-text" id="basic-addon1">{!! $word['5'] !!}</span>
                                            </template>
                                            <template x-if="itemLang.id == 6">
                                                <span class="input-group-text" id="basic-addon1">{!! $word['6'] !!}</span>
                                            </template>
                                            <input type="text"  :name="'{{$name}}[' + keyData + '][description][' + itemLang.id + '][' + keyInput + ']'" x-model="itemData['descriptions'][itemLang.id][keyInput]"  :value="itemData['descriptions'][itemLang.id][keyInput]">
                                        </div>
                                    </template>
                                </template>

                            </div>
                        </template>
                    </div>
                </template>

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

<script id="payload_{{$search_select_type ?? ''}}" type="application/json">@json($data, JSON_UNESCAPED_UNICODE)</script>
<script id="payloadMultiSelect" type="application/json">@json($dataMultiSelect ?? '', JSON_UNESCAPED_UNICODE)</script>
<script>
    document.addEventListener('alpine:init', () => {
        console.log(JSON.parse(document.getElementById('payload_{{$search_select_type ?? ""}}').textContent))
        // console.log(JSON.parse(document.getElementById('payloadMultiSelect').textContent))

        Alpine.data('table_products_{{$search_select_type ?? ""}}', () => ({
            inputType: JSON.parse('@json($inputType ?? [])'),
            data: JSON.parse(document.getElementById('payload_{{$search_select_type ?? ""}}').textContent),
            dataMultiSelect: JSON.parse(document.getElementById('payloadMultiSelect').textContent),
            language: JSON.parse('@json($languages ?? [])'),
            parse: JSON.parse('@json($parse ?? false)'),

            parseData(){
                console.log(this.parse)
                if(this.parse){
                    this.data.forEach(item => {
                        item.id = item?.description && item.description['{{$search_select_type ?? ''}}'] ?  item.description['{{$search_select_type ?? ''}}'] : item['{{$search_select_type ?? ''}}']
                        if('{{$search_select_type}}' == 'kit_product_id'){
                            item.text = item.kit_product.description.name
                        } else {
                            item.text = item.description.name ?? item.description.text ?? item.description.title
                        }
                    })
                    console.log(this.data)
                }
            },

             deletedItem(key){
                Alpine.store('page').multiSelectDestroy();
                this.data.splice(key, 1);
                setTimeout(() => {Alpine.store('page').multiSelect()}, 100)
            },
            addItem(){
                let newItem = {};
                for(let input in this.inputType){
                    if(this.inputType[input].description){
                        if(!('descriptions' in newItem)){
                            newItem['descriptions'] = {};
                        }
                        this.language.forEach(item => {
                            if(!(item.id in newItem['descriptions'])){
                                newItem['descriptions'][item.id] = {};
                            }
                            newItem['descriptions'][item.id][input] = ''
                        })
                    } else {
                        newItem[input] = ''
                    }
                }
                console.log(newItem)
                this.data.push(newItem)
                // console.log(this.data)
                Alpine.store('page').multiSelectDestroy();
                setTimeout(() => {Alpine.store('page').multiSelect()}, 100)
            },
            setItem(e, key, id, text){
                this.data[key].id = id;
                this.data[key].text = text;
                e.parentElement.classList.add('hide');
                // console.log(this.data)
            },
            view(){
                // console.log(this.inputType)
                // console.log(this.data)
                // console.log(this.language)
            }
        }))
    })
</script>
