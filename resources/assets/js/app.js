import Alpine from 'alpinejs'
window.Alpine = Alpine

Alpine.start()

document.addEventListener('DOMContentLoaded', () => {

    Alpine.store('page').sidebar_hide = false;

    // Textarea CKEDITOR
    const editors = {};
    document.querySelectorAll('.dynamic-editor').forEach((textarea) => {
        const id = textarea.id;
        editors[id] = CKEDITOR.replace(id, {
            height: 200,
            removeButtons: '',
            bodyClass: 'custom-editor-body',
        });
    });

    // Save ajax data form
    Alpine.store('page').ajax = (e) => {
        e.preventDefault();
        let form = e.target;

        Object.keys(editors).forEach(id => {
            editors[id].updateElement();
        });

        let formData = new FormData(form)
        axios({
            method: form.method,
            url: form.action,
            data: formData,
        }).then(function (response) {

        }).catch(function () {

        })
    }

    // Logout
    Alpine.store('page').logout = function() {
        document.querySelector('#logout-form').submit()
    };

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

