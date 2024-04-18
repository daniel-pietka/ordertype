/*global define*/
define([
    'knockout',
    'jquery',
    'mage/url',
    'Magento_Ui/js/form/form',
    'Magento_Customer/js/model/customer',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/url-builder',
    'Magento_Checkout/js/model/error-processor',
    'Magento_Checkout/js/model/cart/cache',
    'DanielPietka_OrderType/js/model/checkout/order-type-checkout-form'
], function(ko, $, urlFormatter, Component, customer, quote, urlBuilder, errorProcessor, cartCache, formData) {
    'use strict';

    return Component.extend({
        orderTypeFields: ko.observable(null),
        formData: formData.orderTypeFieldsData,

        initialize: function () {
            var self = this;
            this._super();

            formData = this.source.get('orderTypeCheckoutForm');
            var formDataCached = cartCache.get('order-type-form');

            if (formDataCached) {
                formData = this.source.set('orderTypeCheckoutForm', formDataCached);
            }

            this.orderTypeFields.subscribe(function(change){
                self.formData(change);
            });

            return this;
        },

        /**
         * Trigger save method if form is change
         */
        onFormChange: function () {
            this.saveCustomFields();
        },

        /**
         * Form submit handler
         */
        saveCustomFields: function() {
            // trigger form validation
            this.source.set('params.invalid', false);
            this.source.trigger('orderTypeCheckoutForm.data.validate');

            if (!this.source.get('params.invalid')) {
                var formData = this.source.get('orderTypeCheckoutForm');
                var quoteId = quote.getQuoteId();
                var isCustomer = customer.isLoggedIn();
                var url;

                if (isCustomer) {
                    url = urlBuilder.createUrl('/carts/mine/set-order-type', {});
                } else {
                    url = urlBuilder.createUrl('/guest-carts/:cartId/set-order-type', {cartId: quoteId});
                }

                var result = true;

                $.ajax({
                    url: urlFormatter.build(url),
                    data: JSON.stringify(
                        {
                            cartId: quoteId,
                            orderType: formData
                        }
                    ),
                    global: false,
                    contentType: 'application/json',
                    type: 'PUT',
                    async: true
                }).done(
                    function (response) {
                        cartCache.set('order-type-form', formData);
                        result = true;
                    }
                ).fail(
                    function (response) {
                        errorProcessor.process(response);
                        result = false;
                    }
                );

                return result;
            }
        }
    });
});
