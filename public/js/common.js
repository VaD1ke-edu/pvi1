$(function () {
    "use strict";
    initProducts();
    initCategoryFilters();

    function initProducts() {
        var productsData = JSON.parse($('#productsData').html());
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

            hideProductsByCategories(categoryIds);
        });
    }

    function hideProductsByCategories(categoryIds) {
        var $products = $('.product');
        if (!categoryIds) return;
        if (categoryIds.length === 0) {
            $products.each(function (id, item) {
                $(item).closest('.product-container').show();
            });
            return;
        }
        $products.each(function (id, item) {
            var $container = $(item).closest('.product-container');
            if (categoryIds.indexOf($(item).data('categoryId')) === -1) {
                $container.hide();
                return;
            }
            $container.show();
        });
    }
});