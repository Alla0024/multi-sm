<style>
    .block-segment-items{
        display: flex;
        flex-width: wrap;
        justify-content: center;
        column-gap: 20px;

        .segment-item{
            width: 380px;
            display: flex;
            flex-direction: column;
            border-radius: 8px;
            padding-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .1) !important;

            .head-item{
                background: #a6dbff;
                display: flex;
                padding: 14px;
                justify-content: space-between;
                .name{
                    width: calc(100% - 128px);
                    display: flex;
                    font-size: 20px;
                }
                .butt-action{
                    width: 100px;
                    flex-shrink: 0;
                    align-items: center;
                    display: flex;
                    column-gap: 6px;
                    .edit-butt{
                        width: 40px;
                        height: 40px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 4px;
                        background: #3e60d5;
                        cursor: pointer;
                        color: white;
                    }
                    .check-show-for-sale{
                        height: 40px;
                    }
                }
            }

            .status{
                padding: 14px 20px;
                .status-state{
                    display: flex;
                    column-gap: 18px;
                    align-items: center;
                    margin-bottom: 10px;
                    .state{

                    }
                }
            }
            .products-block{
                padding: 0 20px;
                height: 250px;
                overflow-y: scroll;
                .product-item{
                    background: #f8f9fa;
                    padding: 20px;
                    margin: 10px 0;

                }
            }
        }
    }
</style>
<div class="tab-pane input-block" x-data="sale_segment" data-for-tab="segment">
    <input id="sale_id" value="@if(isset($sale)){{$sale->id}}@endif" type="hidden">

    <div class="block-segment-items">
        @if(isset($sale) && count($sale['segments']) > 0)
            @foreach($sale['segments'] as $segment)
                <div class="segment-item">
                    <div class="head-item">
                        <div class="name">
                            {{$segment['description'] ? $segment['description']['name'] : ''}}
                        </div>
                        <div class="butt-action">
                            <div class="edit-butt">
                                <i class="bi bi-pencil fs-40"></i>
                            </div>
                            <div class="check-show-for-sale">
                                <input type="checkbox" @click="saleInSale($event.target, {{$segment['id']}})" class="ignore_form" @if($segment['show_in_sale']) checked @endif style="width: 40px; height: 40px; cursor: pointer;">
                            </div>
                        </div>
                    </div>

                    <div class="status">
                        <div class="status-state">
                            <div class="state">
                                @if($segment['status'])
                                    <div style="padding: 4px 8px; border-radius: 4px; color: white; background: #83bb8a">
                                        Увімкнено
                                    </div>
                                @else
                                    <div style="padding: 4px 8px; border-radius: 4px; color: white; background: #D79898">
                                        Вимкнено
                                    </div>
                                @endif
                            </div>

                            @if(isset($segment['value']) && $segment['value'] > 0)
                                <div class="value-count" style="padding: 4px 8px; border-radius: 4px; color: white; background: #6cccff">
                                        -{{ $segment['value'] }}
                                    @if($segment['type_number'] == 'percent')
                                        %
                                    @else
                                        {{ $word['currency'] }}
                                    @endif
                                </div>
                            @endif

                        </div>
                        <div class="count">
                               Кількість товарів {{$segment['product_count']}}
                        </div>
                    </div>

                    <div class="products-block">
                        <div class="product-item">
                            Матрац безпружинний - R1 в скрутці
                        </div>
                        <div class="product-item">
                            Матрац безпружинний - R1 в скрутці
                        </div>
                        <div class="product-item">
                            Матрац безпружинний - R1 в скрутці
                        </div>
                        <div class="product-item">
                            Матрац безпружинний - R1 в скрутці
                        </div>
                        <div class="product-item">
                            Матрац безпружинний - R1 в скрутці
                        </div>
                        <div class="product-item">
                            Матрац безпружинний - R1 в скрутці
                        </div>
                        <div class="product-item">
                            Матрац безпружинний - R1 в скрутці
                        </div>
                        <div class="product-item">
                            Матрац безпружинний - R1 в скрутці
                        </div>

                    </div>
                </div>
            @endforeach

        @endif
    </div>

    <div id="segmentModal" class="modal-overlay">
        <div class="modal-segment-edit">
            <h3>Не заповнені обов’язкові поля:</h3>
            <ul id="missingList"></ul>
            <button id="closeMissingModal">Закрити</button>
        </div>
    </div>

</div>


<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('sale_segment', () => ({
            saleInSale(e, id){
                const formData = new FormData();

                formData.append('sale_id', {{$sale['id']}});
                formData.append('show_in_sale', e.checked ? 1 : 0);

                axios.post(`{{url('/')}}/aikqweu/segments/${id}`, formData)
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }))
    })
</script>
