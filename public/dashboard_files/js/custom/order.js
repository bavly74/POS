$(document).ready(function () {

    //add product btn
    $('.add-product-btn').on('click',function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var name = $(this).data('name');
        var price = $(this).data('price');

        $(this).removeClass('btn-success').addClass('btn-default disabled');
        var table = `
                <tr>
                    <td>${name}</td>
                    <td><input class="product-quantity" type="number" min="1" name="products[${id}][quantity]" value="1" data-price="${price}"/> </td>
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


    //remove product btn
    $('body').on('click','.remove-btn',function (e){
        e.preventDefault() ;
        var id=$(this).data('id') ;
        $(this).closest('tr').remove();
        $('#product-'+id).addClass('btn-success').removeClass('btn-default disabled');
        calculateTotal()

    });


    // change price on changing quantity
    $('body').on('keyup change','.product-quantity',function (){
        var quantity=$(this).val();
        var unitePrice =$(this).data('price');
        $(this).closest('tr').find('.product-price').html(quantity * unitePrice);
        calculateTotal();

    })



    //Ajax get products
    $('body').on('click','.order-products',function (e){
       e.preventDefault();
       var url = $(this).data('url');
        var method = $(this).data('method');
        $('#loading').css('display','block');

        $.ajax({
            url:url,
            method:method,
            success:function (data){
                $('#loading').css('display','none');
                $('#order_products').empty()
                $('#order_products').append(data)
            }

        })


    });


    //calculate the total price
    function calculateTotal(){
        var price = 0;
        $('.order-list .product-price').each(function (index){
            price+=parseFloat($(this).html().replace(/,/g,''));
        });
        $('.total-price').html(price)

        if (price > 0){
            $('#add-order-form-btn').removeClass('disabled');
        }else {
            $('#add-order-form-btn').addClass('disabled');
        }
    }


});//end of document ready


