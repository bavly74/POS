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
                    <td><input type="number" min="1"  value="1"/> </td>
                    <td>${price}</td>
                    <td><button class="btn btn-danger remove-btn" data-id="${id}"><span class="fa fa-trash"></span></button></td>
                </tr>
        ` ;
        $('.order-list').append(table);
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









    //change product quantity
    $('body').on('keyup change', '.product-quantity', function() {

        var quantity = Number($(this).val()); //2
        var unitPrice = parseFloat($(this).data('price').replace(/,/g, '')); //150
        console.log(unitPrice);
        $(this).closest('tr').find('.product-price').html($.number(quantity * unitPrice, 2));
        calculateTotal();

    });//end of product quantity change

    //list all order products
    $('.order-products').on('click', function(e) {

        e.preventDefault();

        $('#loading').css('display', 'flex');

        var url = $(this).data('url');
        var method = $(this).data('method');
        $.ajax({
            url: url,
            method: method,
            success: function(data) {

                $('#loading').css('display', 'none');
                $('#order-product-list').empty();
                $('#order-product-list').append(data);

            }
        })

    });//end of order products click

    //print order
    $(document).on('click', '.print-btn', function() {

        $('#print-area').printThis();

    });//end of click function

});//end of document ready

//calculate the total
function calculateTotal() {

    var price = 0;

    $('.order-list .product-price').each(function(index) {

        price += parseFloat($(this).html().replace(/,/g, ''));

    });//end of product price

    $('.total-price').html($.number(price, 2));

    //check if price > 0
    if (price > 0) {

        $('#add-order-form-btn').removeClass('disabled')

    } else {

        $('#add-order-form-btn').addClass('disabled')

    }//end of else

}//end of calculate total
