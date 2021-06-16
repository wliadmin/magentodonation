define([
    'ko',
    'Webline_Donation/js/view/checkout/summary/donatefee',
    'Magento_Checkout/js/model/quote',
    'Magento_Catalog/js/price-utils',
    'Magento_Checkout/js/model/totals'
], function (ko, Component, quote, priceUtils, totals) {
    'use strict';

    var show_hide_extrafee = window.checkoutConfig.ppdonate.show_hide_extrafee;
    var fee_title = window.checkoutConfig.ppdonate.fee_title;
    var extra_fee_amount = window.checkoutConfig.ppdonate.extra_fee_amount;

    return Component.extend({
        totals: quote.getTotals(),
        canVisibleCustomFeeBlock: show_hide_extrafee,
        getFormattedPrice: ko.observable(priceUtils.formatPrice(extra_fee_amount, quote.getPriceFormat())),
        getExtraFeeTitle:ko.observable(fee_title),
        isDisplayed: function () {
            return this.getValue() != 0;
        },
        getValue: function() {
            var price = 0;
            if (this.totals() && totals.getSegment('pp_donate_fee')) {
                price = totals.getSegment('pp_donate_fee').value;
            }
            return price;
        }
    });
});
