document.addEventListener('DOMContentLoaded', () => {




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
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    });

})
