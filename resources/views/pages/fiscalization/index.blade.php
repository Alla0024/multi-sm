@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                                            <div class="col-sm-6">
                            <div class="title-head">Фіскалізація</div>
                        </div>
                                    </div>

                <div class="col-sm-2 action-item">

                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">

            <input type="hidden" readonly="readonly" class="form-control" name="order_confirm_url"
                   value="{{ route('check_status_liqpay') }}">

            <div class="form-group col-sm-6 input-block" style="align-items: center">
                {!! Form::label('order_id', 'Номер замовлень') !!}
                <div class="flex-row input input-min">
                    <div class="input-group">
                        <input type="text" class="input_fiscalization" value="" name="order_id">
                    </div>
                </div>
            </div>

            <div class="form-group col-sm-6 input-block mt-3" style="align-items: center">
                {!! Form::label('payment_type', 'Тип оплати') !!}
                <div class="flex-row input input-min">
                    <div class="input-group">
                        <select class="" name="payment_type"  aria-describedby="select-addon">
                            <option value="liqpay">СМ</option>
                            <option value="rozetka">Rozetka</option>
                            <option value="munger">Munger</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="butt-fiscalization" style="width: max-content; padding: 6px 16px; color: white; background: #3e60d5; border-radius: 4px; cursor: pointer; margin: 20px 0">
                Відправити
            </div>

            <div class="response-fiscalization-info" style="display: block; margin: 20px 0"></div>

        </div>
    </div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const butt = document.querySelector('.butt-fiscalization');
        const paymentType = document.querySelector('select[name="payment_type"]');
        const orderId = document.querySelector('.input_fiscalization');
        const order_confirm_url = document.querySelector('input[name="order_confirm_url"]').value;
        if(butt){
            butt.addEventListener('click', ()=>{
                axios.get(order_confirm_url, {
                    headers: {
                        'Accept': 'application/json',
                    },
                    params: {
                        order_id: orderId.value,
                        payment_type: paymentType.value
                    }
                })
                    .then(response => {
                        document.querySelector('.response-fiscalization-info').innerHTML = response.data.data;
                    })
                    .catch(error => {
                        console.error('Помилка:', error);
                        document.querySelector('.response-fiscalization-info').innerHTML = 'Помилка'
                    });
            })
        }
    })
</script>
