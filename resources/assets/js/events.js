document.addEventListener('DOMContentLoaded', () => {

    // Ignore inputs value ///////////////////////////////////////////////////////////////////////////
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function() {
            form.querySelectorAll('.ignore_form').forEach(function(el) {
                el.disabled = true;
            });
        });
    });


    // Tab change ///////////////////////////////////////////////////////////////////////////
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
    document.querySelectorAll('.input-list-search').forEach(block => {
        const input = block.querySelector('[data-url]');
        const hidden = block.querySelector('input[type="hidden"]');
        const list = block.querySelector('.custom-list');
        const url = input.dataset.url;

        let debounceTimeout;
        const renderList = (items) => {
            list.innerHTML = '';
            if (Array.isArray(items) && items.length > 0) {
                items.forEach(item => {
                    const li = document.createElement('li');
                    li.textContent = item.text;
                    li.addEventListener('click', () => {
                        input.value = item.text;
                        hidden.value = item.id;
                        list.classList.add('hide');
                    });
                    list.appendChild(li);
                });
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
                            renderList(response.data.items  || []);
                            list.classList.remove('hide');
                        })
                        .catch(error => {
                            console.error('AJAX error:', error);
                        });
                } else {
                    let hasMatch = false;
                    list.querySelectorAll('li').forEach(li => {
                        const match = li.textContent.toLowerCase().includes(value);
                        li.style.display = match ? 'block' : 'none';
                        if (match) hasMatch = true;
                    });
                    if (hasMatch) {
                        list.classList.remove('hide');
                    } else {
                        list.classList.add('hide');
                    }
                }
            }, 300)

        };

        // input.addEventListener('focus', updateList);

        input.addEventListener('input', updateList);

        document.addEventListener('click', (e) => {
            if (!block.contains(e.target)) {
                list.classList.add('hide');
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') list.classList.add('hide');
        });
    });

    // Choices ///////////////////////////////////////////////////////////////////////////
    document.querySelectorAll('.tag-select').forEach(select => {
        new Choices(select, {
            removeItemButton: true,
            placeholderValue: 'Виберіть або введіть...',
            searchPlaceholderValue: 'Пошук...',
            duplicateItemsAllowed: false,
        });
    });

    // Image upload ///////////////////////////////////////////////////////////////////////////
    document.querySelectorAll('.image-upload').forEach(block => {
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
                // Якщо файл не зображення — сховати прев'ю
                preview.src = '';
                preview.style.display = 'none';
                alert('Будь ласка, виберіть зображення (JPEG, PNG, WEBP...)');
            }
        });
    });

})
