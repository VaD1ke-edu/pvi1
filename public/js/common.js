$(function () {
    "use strict";
    initProducts();
    initCategoryFilters();
    initProductSearch();

    function initProducts() {
        var productsData = getProductsData();
        var $productsDiv = $('#product-list');
        if (!$productsDiv.length) {
            return;
        }
        var $productsList = $('<section>').addClass('products-container');
        for (var id in productsData) {
            if (!productsData.hasOwnProperty(id)) continue;
            var $productContainer = $('<div>').addClass('product-container');
            var $product = $('<div>').addClass('product').attr('data-product-id', id);
            var $productImg = $('<div>').addClass('product__img-wrapper').append(
                $('<img>').addClass('product__img')
                    .attr('src', productsData[id]['image_url'])
                    .attr('alt', productsData[id]['name'])
                    .attr('title', productsData[id]['name'])
            );
            var $productName = $('<h4>').addClass('product__name').append(productsData[id]['name']);
            var $productPrice = $('<div>').addClass('product__price')
                .append(productsData[id]['price'] + '<span class="rouble">a</span>');
            var $productBuy = $('<button>').addClass('product__btn-buy').addClass('js-product-buy').append('Купить');
            var categoryId = productsData[id]['category_id'];
            $product.attr('data-category-id', categoryId)
                .append($productImg).append($productName).append($productPrice);
            $productContainer.append($product).append($productBuy);
            $productsList.append($productContainer);
        }
        $productsDiv.append($productsList);
        $productsDiv.append($('<div>').addClass('clearfix'));
    }

    function initCategoryFilters() {
        $('.category-filter').click(function () {
            var $filters = $(this).closest('.category-filters');

            var categoryIds = $filters.find('input:checkbox:checked').map(function() {
                return parseInt(this.value);
            }).get();

            filterProducts(categoryIds, 'categoryId');
        });
    }

    function initProductSearch() {
        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();
        $('#product-search').keyup(function () {
            var _this = this;
            delay(function () {
                var value = $(_this).val();
                var productsData = getProductsData();
                var matcher = new RegExp(value, 'i');
                var matchedProductIds = [];
                for (var id in productsData) {
                    if (!productsData.hasOwnProperty(id)) continue;
                    if (matcher.test(productsData[id]['name'])) {
                        matchedProductIds.push(parseInt(id));
                    }
                }
                filterProducts(matchedProductIds);
            }, 100);
        })
    }

    function filterProducts(ids, type) {
        type = type || 'productId';
        var $products = $('.product');
        if (!ids) return;
        if (ids.length === 0) {
            $products.each(function (id, item) {
                $(item).closest('.product-container').show(50);
            });
            return;
        }
        $products.each(function (id, item) {
            var $container = $(item).closest('.product-container');
            if (ids.indexOf($(item).data(type)) === -1) {
                $container.hide(50);
                return;
            }
            $container.show(50);
        });
    }

    function getProductsData() {
        return JSON.parse($('#productsData').html());
    }
});