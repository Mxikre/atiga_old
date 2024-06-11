
function updatePricing() {
    var variationSelect = document.getElementById('variation');
    var selectedVariationId = variationSelect.value;
    var pricingContainer = document.getElementById('pricing-container');

    if (selectedVariationId in pricingData) {
        var selectedPricing = pricingData[selectedVariationId];
        var productName = document.querySelector('.product-det h1').getAttribute('data-product-name');
        var pricingHTML = '<h3>Harga</h3>';

        if (selectedPricing.length > 0) {
            for (var i = 0; i < selectedPricing.length; i++) {
                pricingHTML += selectedPricing[i]['min_quantity'] + ' - ' + selectedPricing[i]['max_quantity'];
                pricingHTML += productName === 'Print Kertas dan Sticker' ? ' lembar' : (productName === 'Banner Horizontal' ? ' meter' : (productName === 'kartu nama' ? ' box' : ''));
                pricingHTML += ' = ' + ' Rp. ' + selectedPricing[i]['price'];

                pricingHTML += '<br>';
            }
        } else {
            // If pricing data is not available, show the price from product_variations
            pricingHTML += 'Rp. ' + variationSelect.options[variationSelect.selectedIndex].getAttribute('data-price') + '<br>';
        }

        pricingContainer.innerHTML = pricingHTML;
    } else {
        pricingContainer.innerHTML = '<h3>Harga</h3><p>Tidak ada data harga untuk variasi ini.</p>';
    }
}

document.addEventListener("DOMContentLoaded", function () {
    updatePricing();
});

document.getElementById('variation').addEventListener('change', updatePricing);

