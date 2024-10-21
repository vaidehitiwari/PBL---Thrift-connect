document.addEventListener("DOMContentLoaded", function () {
    const productList = document.getElementById("productList");
    const scrollAmount = 300; // Adjust this value for the scroll distance

    // Scroll left
    document.getElementById("scroll-left").addEventListener("click", function () {
        productList.scrollBy({
            top: 0,
            left: -scrollAmount,
            behavior: 'smooth' // Enables smooth scrolling
        });
    });

    // Scroll right
    document.getElementById("scroll-right").addEventListener("click", function () {
        productList.scrollBy({
            top: 0,
            left: scrollAmount,
            behavior: 'smooth' // Enables smooth scrolling
        });
    });
});

document.addEventListener("keydown", function (event) {
    if (event.key === "ArrowLeft") {
        productList.scrollBy({
            top: 0,
            left: -scrollAmount,
            behavior: 'smooth'
        });
    }
    if (event.key === "ArrowRight") {
        productList.scrollBy({
            top: 0,
            left: scrollAmount,
            behavior: 'smooth'
        });
    }
});