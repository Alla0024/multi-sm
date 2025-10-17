document.addEventListener('DOMContentLoaded', () => {


    // Tab change //////////////////////////////////./////////////////////////////////////////
    const buttons = document.querySelectorAll('[data-tab]');
    const contents = document.querySelectorAll('[data-for-tab]');

    function switchTab(tab) {
        buttons.forEach(btn => {
            btn.classList.toggle('active', btn.dataset.tab === tab);
        });

        contents.forEach(content => {
            content.classList.toggle('active', content.dataset.forTab === tab);
        });
    }
    if(buttons){
        buttons.forEach(button => {
            button.addEventListener('click', () => {
                switchTab(button.dataset.tab);
            });
        });

        const active = document.querySelector('[data-tab].active');
        if (active) switchTab(active.dataset.tab);
    }


    // Input search ///////////////////////////////////////////////////////////////////////////
    Alpine.store('page').searchSelect = function (el){
        const block = el.parentElement;
        const input = block.querySelector('[data-url]');
        const hidden = block.querySelector('input[type="hidden"]');
        const list = block.querySelector('.custom-list');
        const url = input.dataset.url;
        let debounceTimeout;
        const renderList = (items, value = '') => {
            list.innerHTML = '';
            if (Array.isArray(items) && items.length > 0) {
                items.forEach(item => {
                    if(item.text.toLowerCase().includes(value)){
                        const li = document.createElement('li');
                        li.textContent = item.text;
                        if(input.getAttribute('custom') === 'true'){
                            function setItem(){
                                input.value = item.text;
                                hidden.value = item.id;
                                list.classList.add('hide');
                            }
                            li.removeEventListener('click', setItem);
                            li.addEventListener('click', setItem);
                        } else {
                            li.setAttribute('x-on:click', `setItem($event.target, keyData, ${item.id}, "${item.text.replace('"', '\'').replace('"', '\'')}")`)
                        }

                        list.appendChild(li);
                    }
                });
                if(list.innerHTML == ''){
                    list.innerHTML = '<li style="color:#999;cursor:default;">Нічого не знайдено</li>';
                }
            } else {
                list.innerHTML = '<li style="color:#999;cursor:default;">Нічого не знайдено</li>';
            }
        };
        const updateList = () => {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                const value = input.value.trim().toLowerCase();
                let hasMatch = false;
                if (url) {
                    axios.get(url, { params: { q: value } })
                        .then(response => {
                            renderList(response.data.items  || [], value);
                            list.classList.remove('hide');
                        })
                        .catch(error => {
                            console.error('AJAX error:', error);
                        });
                } else {
                    let hasMatch = false;
                    list.querySelectorAll('li').forEach(li => {
                        const match = li.textContent.toLowerCase().includes(value);
                        if(input.getAttribute('custom') === 'true'){
                            function setItem(){
                                input.value = li.textContent;
                                hidden.value = li.id;
                                list.classList.add('hide');
                            }
                            li.removeEventListener('click', setItem);
                            li.addEventListener('click', setItem);
                        } else {
                            li.setAttribute('x-on:click', `setItem($event.target, keyData, ${item.id}, "${item.text.replace('"', '\'').replace('"', '\'')}")`)
                        }
                        li.style.display = match ? 'block' : 'none';
                        if (match) hasMatch = true;
                    });
                    if (hasMatch) {
                        list.classList.remove('hide');
                    } else {
                        list.classList.add('hide');
                    }
                }
                if(value == ''){
                    hidden.value = '';
                }
            }, 300)
        };
        // input.addEventListener('focus', updateList);
        // input.addEventListener('input', updateList);
        updateList()
        document.addEventListener('click', (e) => {
            if (!block.contains(e.target)) {
                list.classList.add('hide');
            }
        });

    }

    // Choices Multi-select ///////////////////////////////////////////////////////////////////////////
    let arrChoices= []
    Alpine.store('page').multiSelect = function (){
        arrChoices = []
        document.querySelectorAll('.tag-select').forEach(select => {
            const choices = new Choices(select, {
                removeItemButton: true,
                placeholderValue: 'Виберіть або введіть...',
                searchPlaceholderValue: 'Пошук...',
                duplicateItemsAllowed: false,
                shouldSort: false,
                searchEnabled: !select.dataset.noSearch,

            });

            let searchTimeout;
            const url = select.dataset.url;
            if (!url) {
                arrChoices.push(choices)
                return;
            }

            const searchInput = select.parentElement.querySelector('input[type="search"]')
            function handler(event) {
                const searchValue = event.target.value;

                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    axios.get(url, { params: { q: searchValue } })
                        .then(response => {
                            const items = response.data.items || [];

                            const existingValues = Array.from(select.options).filter(opt => opt.selected).map(opt => opt.value);

                            const newOptions = items.filter(item => !existingValues.includes(item.id.toString()));

                            if (newOptions.length) {
                                choices.setChoices(
                                    newOptions.map(item => ({
                                        value: item.id,
                                        label: item.text,
                                        selected: false,
                                        disabled: false,
                                    })),
                                    'value',
                                    'label',
                                    false
                                );
                            }
                        })
                        .catch(err => {
                            console.error('AJAX error:', err);
                        });
                }, 300);
            }
            searchInput.addEventListener('input', handler);
            searchInput.addEventListener('click', handler);
            arrChoices.push(choices)
        });
    }
    Alpine.store('page').multiSelectDestroy = function (){
        console.log(arrChoices)
        arrChoices.forEach(item => item.destroy())
    }
    Alpine.store('page').multiSelect()


    // Image upload ///////////////////////////////////////////////////////////////////////////
    let img_items = document.querySelectorAll('.image-uploaddd')
    if(img_items){
        img_items.forEach(block => {
            const input = block.querySelector('input[type="file"]');
            const preview = block.querySelector('img');

            input.addEventListener('change', (event) => {
                const file = event.target.files[0];

                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '';
                    preview.style.display = 'none';
                    alert('Будь ласка, виберіть зображення (JPEG, PNG, WEBP...)');
                }
            });
        });
    }

    // Clear image
    const clearImage = document.querySelectorAll('.clear-img');
    if(clearImage){
        clearImage.forEach(item => {
            item.addEventListener('click', ()=>{
                item.parentElement.parentElement.querySelector('input').value = ''
                item.parentElement.parentElement.querySelector('img').src = '/images/common/no_images.png'
            })
        })
    }


    // Mask number
    Alpine.store('page').mask = (el) => {
        let d = (el.value || '').replace(/\D+/g, '');

        if (d.startsWith('380')) d = d.slice(3);
        else if (d.startsWith('0')) d = d.slice(1);

        d = d.slice(0, 9);

        if (!d.length) {
            el.value = '';
            return;
        }

        let out = '+380 ';
        if (d.length <= 2) {
            out += d; // +380 XX
        } else if (d.length <= 5) {
            out += d.slice(0,2) + ' ' + d.slice(2);
        } else if (d.length <= 7) {
            out += d.slice(0,2) + ' ' + d.slice(2,5) + '-' + d.slice(5);
        } else {
            out += d.slice(0,2) + ' ' + d.slice(2,5) + '-' + d.slice(5,7) + '-' + d.slice(7,9);
        }
        el.value = out;
    }

    // Switch checkbox
    const switch_father = document.querySelector('.checkbox-father');
    if(switch_father){
        switch_father.addEventListener('change', ()=>{
            document.querySelectorAll('.checkbox-child').forEach(item => {
                item.checked = switch_father.checked
            })
        })
    }

    // Search multi
    const formSearch = document.getElementById('search_form');
    if(formSearch){
        formSearch.addEventListener('submit', function (e) {
            const multiselects = document.querySelector('#multiple_search');

            if(multiselects){
                const name = multiselects.name.replace('[]', '');
                const selected = Array.from(multiselects.selectedOptions).map(o => o.value);

                const existing = formSearch.querySelector(`input[name="${name}"]`);
                if (existing) existing.remove();

                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = name;
                hidden.value = selected.join(',');
                formSearch.appendChild(hidden);

                multiselects.disabled = true;
            }
        });
    }

})
