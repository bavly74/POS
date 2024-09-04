$(document).ready(function () {

    $('.add-product-btn').on('click',function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var name = $(this).data('name');
        var price = $(this).data('price');

        $(this).removeClass('btn-success').addClass('btn-default disabled');
        var table = `
                <tr>
                    <td>${name}</td>
                    <td><input class="product-quantity" type="number" min="1"  value="1" data-price="${price}"/> </td>
                    <td class="product-price">${price}</td>
                    <td><button class="btn btn-danger remove-btn" data-id="${id}"><span class="fa fa-trash"></span></button></td>
                </tr>
        ` ;
        $('.order-list').append(table);
        calculateTotal()
    });

    $('body').on('click','.disabled',function (e){
       e.preventDefault();
    });


    $('body').on('click','.remove-btn',function (e){
        e.preventDefault() ;
        var id=$(this).data('id') ;
        $(this).closest('tr').remove();
        $('#product-'+id).addClass('btn-success').removeClass('btn-default disabled');
    });


    $('body').on('keyup change','.product-quantity',function (){
        var quantity=$(this).val();
        var unitePrice =$(this).data('price');
        $(this).closest('tr').find('.product-price').html(quantity * unitePrice);
        calculateTotal();

    })



    function calculateTotal(){
        var price = 0;
        $('.order-list .product-price').each(function (index){
            price+=parseInt($(this).html());
        });
        $('.total-price').html(price)
    }


});//end of document ready

//calculate the total

