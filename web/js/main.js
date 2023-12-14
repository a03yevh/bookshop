"use-strict";

(function () {
    if (!getCookie("user_key")) {
        let key = Array(32).fill().map(()=>"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789".charAt(Math.random()*62)).join("");
        document.cookie = "user_key=" + key + "; max-age=" + 3600 * 24 * 30;
        location.reload();
    }

    /*=============== SHOW && HIDE NAV ===============*/
    let isActiveNav = false;
    $("#nav-toggle").on("click", function() {
        if (isActiveNav) {
            $(this).removeClass("hamburger--active");
            $("#header").removeClass("header--active");
            $("#nav-items").removeClass("nav__items--active");
            $("body").removeClass("body--hidden");
        } else {
            $(this).addClass("hamburger--active");
            $("#header").addClass("header--active");
            $("#nav-items").addClass("nav__items--active");
            $("body").addClass("body--hidden");
        }

        isActiveNav = !isActiveNav;
    });

    /*=============== ACTIVE SEARCH MENU ===============*/
    $("#search-active").on("click", function(e) {
        e.preventDefault();

        $("#header").addClass("header--active");
        $("#search-form").addClass("search-form--active");
    });

    /*=============== CLOSE SEARCH MENU ===============*/
    $("#search-form-close").on("click", function() {
        $("#header").removeClass("header--active");
        $("#search-form").removeClass("search-form--active");

        $("#search-form-input").val("");
    });

    /*=============== SEARCH FORM SEND ===============*/
    $("#search-form").submit(function(e) {
        if ($("#search-form-input").val() == "") {
            e.preventDefault();
        }
    });

    /*=============== ACTIVE ACCOUNT MENU ===============*/
    $("#account-active").on("click", function(e) {
        e.preventDefault();

        $("#header").addClass("header--active");
        $("#header").addClass("header--active-b");
        $("#account-widget").addClass("account-widget--active");
        $("body").addClass("body--hidden");
    });

    /*=============== CLOSE ACCOUNT MENU ===============*/
    $("#account-widget-close").on("click", function() {
        $("#header").removeClass("header--active");
        $("#header").removeClass("header--active-b");
        $("#account-widget").removeClass("account-widget--active");
        $("body").removeClass("body--hidden");
    });

    /*=============== ACTIVE CART ===============*/
    $("#cart-active").on("click", function(e) {
        e.preventDefault();

        $("#header").addClass("header--active");
        $("#header").addClass("header--active-b");
        $("#cart-widget").addClass("cart-widget--active");
        $("body").addClass("body--hidden");
    });

    /*=============== CLOSE CART ===============*/
    $("#cart-widget-close").on("click", function() {
        $("#header").removeClass("header--active");
        $("#header").removeClass("header--active-b");
        $("#cart-widget").removeClass("cart-widget--active");
        $("body").removeClass("body--hidden");
    });

    /*=============== SHOW ACCOUNT FORMS ===============*/
    $(".login__link").on("click", function() {
        const name = $(this).attr("class").split(' ')[1].split('--')[1];
        const correctName = name.replace("-", "");

        let names = {
            forgot: ["forgot", "Відновлення"],
            login: ["login", "Увійти"],
            signup: ["sign-up", "Реєстрація"]
        };

        for (let key in names) {
            if (key == correctName) {
                $("#" + names[key][0]).removeClass("d-none");
                $(".account-widget__title").text(names[key][1])
            } else {
                $("#" + names[key][0]).addClass("d-none");
                $("#" + names[key][0] + "-form")[0].reset();
            }
        }

    });

    /*=============== ACTIVE FILTERS MENU ===============*/
    $("#shop-filters-toggle").on("click", function() {
        $("#shop-filter-nav").addClass("shop__filters-nav--active");
    });

    /*=============== CLOSE FILTERS MENU ===============*/
    $("#shop-filters-close").on("click", function() {
        $("#shop-filter-nav").removeClass("shop__filters-nav--active");
    });

    /*=============== ACTIVE FILTERS SUBMENU ===============*/
    $(".shop__filters-link--more").on("click", function() {
        let shopFiltersItem = $(this).parent();

        if (shopFiltersItem.hasClass("shop__filters-item--active")) {
            shopFiltersItem.removeClass("shop__filters-item--active");
        } else {
            $(".shop__filters-item").each(function( ) {
                $(this).removeClass("shop__filters-item--active");
            });
            shopFiltersItem.addClass("shop__filters-item--active");
        }
    });

    /*=============== CHOOSE CATEGORY ===============*/
    const category = $("#goods-category_id");
    const subcategory = $("#goods-subcategory_id");

    category.on("change", () => {
        if (category.val() == "") {
            subcategory.attr("disabled", "disabled")
            subcategory.html("<option value=\"\">Оберіть підкатегорію...</option>");
        } else {
            $.ajax({
                type: "POST",
                url: "/category/get-subcategories",
                data: "category=" + category.val(),
                success: function(res){
                    subcategory.html(res);
                    if (res != "<option value=\"\">Оберіть підкатегорію...</option>") {
                        subcategory.prop("disabled", false);
                    } else {
                        subcategory.prop("disabled", true);
                    }
                },
            });
        }
    });

    /* FUNCTION IS SHOWING FILTER FORM */
    $(".button-filter").on("click", function (e) {
        e.preventDefault();

        const formFilter = $(".form-filter");
        if (formFilter) {
            if (formFilter.hasClass("d-none")) {
                formFilter.removeClass("d-none");
            } else {
                formFilter.addClass("d-none");
            }
        }
    });

    /*=============== CHOOSE FAVORITE GOOD ===============*/
    $(".goods__favorite").on("click", function () {
        let item = $(this);

        $.ajax({
            type: "POST",
            url: "/favorite/choose",
            data: "good_id=" + $(this).attr("data-good-id"),
            success: function(res){
                if (res === 'success') {
                    item.removeClass("bx-heart");
                    item.addClass("bxs-heart");
                } else {
                    item.removeClass("bxs-heart");
                    item.addClass("bx-heart");
                }
            },
        });
    });

    /*=============== ADD TO CART GOOD ===============*/
    const currentUrl = window.location.pathname;
    let pageParam = "goods";
    if (currentUrl.slice(0, 11) === "/shop/good/") {
        pageParam = "good";
    }

    $("." + pageParam + "__button").on("click", function () {
        const item = $(this);
        if (!item.hasClass("" + pageParam + "__button--disable")) {
            const goodId = item.attr("data-good-id");
            const goodPrice = Number($("#good-price-" + goodId).attr("data-price"));
            let totalPrice;
            if(document.getElementById("cart-widget-empty")) {
                totalPrice = goodPrice;
            } else {
                totalPrice = Number($(".cart-widget__total-count").attr("data-price")) + goodPrice;
            }

            $.ajax({
                type: "POST",
                url: "/cart/create",
                data: "good_id=" + goodId,
                success: function(res){
                    let params = res.split(";");
                    $("#cart-count").text(params[0]);
                    if (params[0] == 1) {
                        $(".cart-widget__empty").remove();
                        $(".cart-widget__info").remove();

                        let detailsCode = "<div class=\"cart-widget__details\"><h3 class=\"cart-widget__sum\"><span>Загалом</span><span class=\"cart-widget__total-count\" data-price=\"\"></span></h3><a class=\"cart-widget__order button button--inverse\" href=\"/order\" type=\"button\">Оформити замовлення</a></div>";
                        $(".cart-widget__wrapper").after(detailsCode);
                    }

                    $("#item-count-" + params[1]).val(parseInt($("#item-count-" + params[1]).val()) + 1);

                    $(".cart-widget__total-count").text(totalPrice.toFixed(2) + " ₴");
                    $(".cart-widget__total-count").attr("data-price", totalPrice);

                    if(!document.getElementById("cart-item-" + params[1])){
                        makeCartItem(params[1]);
                    }

                    $("#header").addClass("header--active");
                    $("#header").addClass("header--active-b");
                    $("#cart-widget").addClass("cart-widget--active");
                    $("body").addClass("body--hidden");
                },
            });
        }
    });

    $(document).mouseup( function(e) {
        if (!$("#account-widget").is(e.target)
            && $("#account-widget").has(e.target).length === 0) {
            $("#account-widget").removeClass("account-widget--active");
            $("body").removeClass("body--hidden");
        }

        if (!$("#cart-widget").is(e.target)
            && $("#cart-widget").has(e.target).length === 0) {
            $("#cart-widget").removeClass("cart-widget--active");
            $("body").removeClass("body--hidden");
        }

        if (!$("#nav-items").is(e.target)
            && $("#nav-items").has(e.target).length === 0
            && !$("#nav-toggle").is(e.target)
            && !$(".hamburger__ham").is(e.target)) {
            $("#nav-toggle").removeClass("hamburger--active");
            $("#nav-items").removeClass("nav__items--active");
            $("body").removeClass("body--hidden");

            isActiveNav = false;
        }

        if (!$("#search-form").is(e.target)
            && $("#search-form").has(e.target).length === 0) {
            $("#search-form").removeClass("search-form--active");

            $("#search-form-input").val("");
        }

        if (!$("#nav-items").is(e.target)
            && $("#nav-items").has(e.target).length === 0
            && !$("#nav-toggle").is(e.target)
            && !$(".hamburger__ham").is(e.target)
            && !$("#search-form").is(e.target)
            && $("#search-form").has(e.target).length === 0
            && !$("#account-widget").is(e.target)
            && $("#account-widget").has(e.target).length === 0
            &&!$("#cart-widget").is(e.target)
            && $("#cart-widget").has(e.target).length === 0) {
            $("#header").removeClass("header--active");
        }

        if (!$("#account-widget").is(e.target)
            && $("#account-widget").has(e.target).length === 0
            &&!$("#cart-widget").is(e.target)
            && $("#cart-widget").has(e.target).length === 0) {
            $("#header").removeClass("header--active-b");
        }
    });
})(jQuery);

function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function deleteFromCart(itemId) {
    $.ajax({
        type: "POST",
        url: "/cart/delete",
        data: "id=" + itemId,
        success: function(res){
            let params = res.split(";");

            $("#cart-count").text(params[0]);

            $(".cart-widget__item-" + itemId).remove();

            if (params[0] == 0) {
                $(".cart-widget__wrapper").html("<img id=\"cart-widget-empty\" class=\"cart-widget__empty\" src=\"/img/empty-cart.svg\" width=\"259\" height=\"303\" alt=\"Закрити\"><p class=\"cart-widget__info\">У вашому кошику немає товарів.</p>")
                $(".cart-widget__details").remove();
            } else {
                $(".cart-widget__total-count").text(Number(params[1]).toFixed(2) + " ₴");
                $(".cart-widget__total-count").attr("data-price", params[1]);
            }
        },
    });
}

function changeCountGoods(itemId) {
    const input = $("#item-count-" + itemId);
    let count;
    if (input.val() == 0) {
        count = 1;
    } else {
        count = parseInt(input.val());
    }

    if (input.val() != '') {
        changeCount(itemId, count, input);
    }
}

function addCountGoods(itemId) {
    const input = $("#item-count-" + itemId);

    let count = parseInt(input.val()) + 1;

    changeCount(itemId, count, input);
}

function subtractCountGoods(itemId) {
    const input = $("#item-count-" + itemId);

    if (input.val() != 1) {
        let count = parseInt(input.val()) - 1;

        changeCount(itemId, count, input);
    }
}

function changeCount(itemId, count, input) {
    $.ajax({
        type: "POST",
        url: "/cart/change-count",
        data: "id=" + itemId + "&count=" + count,
        success: function(res){
            input.val(count);
            $(".cart-widget__total-count").text(Number(res).toFixed(2) + " ₴");
            $(".cart-widget__total-count").attr("data-price", res);
        },
    });
}

function makeCartItem(itemId) {
    $.ajax({
        type: "POST",
        url: "/cart/make-item",
        data: "id=" + itemId,
        success: function(res){
            $(".cart-widget__wrapper").append(res);
        },
    });
}