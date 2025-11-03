import Alpine from 'alpinejs'
window.Alpine = Alpine

Alpine.start()

document.addEventListener('DOMContentLoaded', () => {

    Alpine.store('page').sidebar_hide = false;

    // Textarea CKEDITOR
    const editors = {};
    document.querySelectorAll('.dynamic-editor').forEach((textarea) => {
        const id = textarea.id;
        const req = textarea.hasAttribute('required')
        editors[id] = CKEDITOR.replace(id, {
            height: 200,
            removeButtons: '',
            bodyClass: 'custom-editor-body',
        });
        if(req){
            textarea.setAttribute('required', '')
        }
        editors[id].on('change', () => editors[id].updateElement());
        editors[id].on('key',   () => editors[id].updateElement());

    });

    // FileManager build
    Alpine.store('page').bindFileManager = (el, options = { type: 'image', prefix: '/filemanager' }) => {
        const type = options.type || 'file';
        const prefix = options.prefix || '/filemanager';

        const { input: inputId, preview: previewId, path = '' } = el.dataset || {};
        if (inputId)  localStorage.setItem('target_input', inputId);
        if (previewId) localStorage.setItem('target_preview', previewId);

        const url = `${prefix}?type=${encodeURIComponent(type)}${path ? `&working_dir=${encodeURIComponent(path)}` : ''}`;

        window.filemanager(url).then((urlOrItems) => {
            let chosenUrl = urlOrItems;
            let chosenPath = null;

            if (Array.isArray(urlOrItems)) {
                const item = urlOrItems[0] || {};
                chosenUrl = item.url;
                chosenPath = item.name || item.path || item.url;
            }

            const targetInputId = localStorage.getItem('target_input');
            const targetPreviewId = localStorage.getItem('target_preview');

            if (targetInputId) {
                const inputEl = document.getElementById(targetInputId);
                if (inputEl) {
                    let relativeUrl = chosenUrl.replace(/^.*\/images/, '');
                    inputEl.value = relativeUrl || '';
                    inputEl.dispatchEvent(new Event('input', { bubbles: true }));
                    inputEl.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }


            if (targetPreviewId) {
                const previewEl = document.getElementById(targetPreviewId);
                if (previewEl) {
                    if ('src' in previewEl) {
                        previewEl.src = chosenUrl;
                        previewEl.classList.remove('hide')
                    } else {
                        previewEl.style.backgroundImage = `url("${chosenUrl}")`;
                    }
                    previewEl.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }
        });
    }

    // Save ajax data form
    Alpine.store('page').ajax = (e) => {
        // e.preventDefault();

        let form = e.parentElement.parentElement;

        Object.keys(editors).forEach(id => {
            editors[id].updateElement();
        });

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        let formData = new FormData(form)

        axios({
            method: form.method,
            url: form.action,
            data: formData,
        }).then(function (response) {
            window.scrollTo({top: 0})
            location.reload();

        }).catch(function () {

        })
    }

    // Ignore inputs value ///////////////////////////////////////////////////////////////////////////
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            document.querySelectorAll('.ignore_form').forEach(function(el) {
                el.disabled = true;
            });

            const requiredFields = form.querySelectorAll('[required]');
            const missing = [];

            requiredFields.forEach(input => {
                if (!input.value.trim()) {
                    let label = '';
                    const labelEl = form.querySelector(`label[for="${input.id}"]`);
                    if (labelEl) {
                        label = labelEl.textContent.trim();
                    } else {
                        label = input.getAttribute('placeholder') || input.name;
                    }
                    missing.push(label);
                }
            });

            if (missing.length > 0) {
                const list = document.querySelector('#missingList');
                list.innerHTML = '';
                missing.forEach(field => {
                    const li = document.createElement('li');
                    li.textContent = field;
                    list.appendChild(li);
                });
                document.querySelector('#missingModal').classList.add('active');
            } else {
                form.submit();
            }
        });
    });

    document.querySelector('#closeMissingModal').addEventListener('click', () => {
        document.querySelector('#missingModal').classList.remove('active');
    });


    // Cookie
    Alpine.store('page').getCookie = function (name) {
        const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        if (match) return match[2];
        return null;
    }
    Alpine.store('page').theme = Alpine.store('page').getCookie('theme') || 'light';

    // Change theme
    Alpine.store('page').changeTheme = function (){
        const current = document.documentElement.getAttribute('data-b-theme');
        const next = current === 'light' ? 'dark' : 'light';
        Alpine.store('page').theme = next;
        document.documentElement.setAttribute('data-b-theme', next);

        document.cookie = `theme=${next}; path=/; max-age=31536000`;
    }


})

