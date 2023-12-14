/*=============== MAIN SLIDER ===============*/
if ($(".slider")) {
    let swiper = new Swiper(".slider", {
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
}

if ($(".goods-swiper")) {
    let swiper = new Swiper(".goods-swiper", {
        slidesPerView: 1,
        spaceBetween: 15,
        breakpoints: {
            576: {
                slidesPerView: 2,
                spaceBetween: 15,
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 15,
            },
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
}

