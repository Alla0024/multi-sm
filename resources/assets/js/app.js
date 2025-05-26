import Alpine from 'alpinejs'
window.Alpine = Alpine

Alpine.start()

document.addEventListener('DOMContentLoaded', () => {

    // Textarea CKEDITOR
    const editors = {};
    document.querySelectorAll('.dynamic-editor').forEach((textarea) => {
        const id = textarea.id;
        editors[id] = CKEDITOR.replace(id, {
            height: 200,
            removeButtons: '',
        });
    });

    // Save data form
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

    Alpine.store('page').changeColor = function (){
        const doc = document.querySelector('html');
        if(doc.getAttribute('data-b-theme') === 'dark'){
            doc.setAttribute('data-b-theme', 'light')
        } else {
            doc.setAttribute('data-b-theme', 'dark')
        }
    }
})

