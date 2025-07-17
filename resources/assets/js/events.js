document.addEventListener('DOMContentLoaded', () => {


    // Tab change
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

        // Ініціалізація
        const active = document.querySelector('[data-tab].active');
        if (active) switchTab(active.dataset.tab);
    }


    // Input search
    document.querySelectorAll('.input-list-search').forEach(block => {
        const input = block.querySelector('input');
        const list = block.querySelector('.custom-list');

        const updateList = () => {
            const value = input.value.trim().toLowerCase();
            let hasMatch = false;

            list.querySelectorAll('li').forEach(li => {
                const match = li.textContent.toLowerCase().includes(value);
                li.style.display = match ? 'block' : 'none';
                if (match) hasMatch = true;
            });

            if (value && hasMatch) {
                list.classList.remove('hide');
            }
        };

        input.addEventListener('focus', () => {
            list.classList.remove('hide');
            updateList(); // одразу відфільтрувати
        });

        input.addEventListener('input', updateList);

        list.querySelectorAll('li').forEach(li => {
            li.addEventListener('click', () => {
                input.value = li.textContent;
                list.classList.add('hide');
            });
        });

        document.addEventListener('click', (e) => {
            if (!block.contains(e.target)) {
                list.classList.add('hide');
            }
        });
    });

    // Choices
    document.querySelectorAll('.tag-select').forEach(select => {
        new Choices(select, {
            removeItemButton: true,
            placeholderValue: 'Виберіть або введіть...',
            searchPlaceholderValue: 'Пошук...',
            duplicateItemsAllowed: false,
        });
    });

    // Image upload
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
