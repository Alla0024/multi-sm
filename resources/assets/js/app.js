import Alpine from 'alpinejs'
window.Alpine = Alpine

Alpine.start()

document.addEventListener('DOMContentLoaded', () => {

    Alpine.store('page').ajax = (e) => {
        e.preventDefault();
        let form = e.target;
        let formData = new FormData(form)
        axios({
            method: form.method,
            url: form.action,
            data: formData,
        }).then(function (response) {

        }).catch(function () {

        })
    }
})

