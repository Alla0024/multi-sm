import axios from "axios";

document.addEventListener('DOMContentLoaded', ()=>{

    // Btn head submit
    const btn_head_submit = document.querySelector('.head-submit');
    btn_head_submit.addEventListener('click', () => {
        document.querySelector('form[accept-charset]').submit()
    })

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
