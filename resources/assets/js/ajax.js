import axios from "axios";

document.addEventListener('DOMContentLoaded', ()=>{

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

    // Copy item
    Alpine.store('page').copyItem = (el) => {
        let ob = {}
        if(document.querySelector('.checkbox-child:checked')){
            ob[el.dataset.name] = document.querySelector('.checkbox-child:checked').getAttribute('data-content')
            axios({
                method: 'POST',
                url: el.getAttribute('data-action'),
                data: {...ob},
            }).then(function (response) {
                location.reload();
            }).catch(function () {

            })
        }
    };

    // Deleted items
    Alpine.store('page').deletedItems = (el) => {
        if(document.querySelectorAll('.checkbox-child:checked').length){
            let items = ''
            document.querySelectorAll('.checkbox-child:checked').forEach(item=>{
                if(items != ''){
                    items += ','
                }
                items += item.getAttribute('data-content')
            })
            el.action += '/'+items
            el.submit()
        }
    }
})
