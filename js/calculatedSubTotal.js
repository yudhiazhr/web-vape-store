function calculateSubTotal(input, price) {
    var quantity = input.value;

    var subtotal = quantity * price;

    var productPriceElement = input.closest('tr').querySelector('.product-price');

    productPriceElement.textContent = formatCurrency(subtotal);
}

function formatCurrency(amount) {
    return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}