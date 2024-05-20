$(document).ready(function(){
    // when + buttons click
    $('.btn-plus').click(function(){
        $parentNode = $(this).parents("tr");
        $price = $parentNode.find('#price').text().replace("Kyats","");
        $qty = Number($parentNode.find('#qty').val());
        $total = $price*$qty;
        $parentNode.find('#total').html($total+" Kyats")
        summaryCalculation();
    })

    // when - buttons click
    $('.btn-minus').click(function(){
        $parentNode = $(this).parents("tr");
        $price = $parentNode.find('#price').html().replace("Kyats","");
        $qty = Number($parentNode.find('#qty').val());
        $total = $price*$qty;
        $parentNode.find('#total').html($total+" Kyats")
        summaryCalculation();
    })

    // when cross button click
    $('.btnRemove').click(function(){
        $parentNode = $(this).parents("tr");
        $parentNode.remove();
        summaryCalculation();

    })

    // calculate final price for order
    function summaryCalculation(){
        $totalPrice = 0;
        $('#dataTable tr').each(function(index,row){
            $totalPrice += Number($(row).find('#total').text().replace("Kyats",""));
        });

        $('#subTotalPrice').html(`${$totalPrice} Kyats`);
        $('#finalPrice').html(`${$totalPrice+3000} Kyats`);
    }
})
