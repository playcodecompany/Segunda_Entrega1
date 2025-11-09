document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("merchContainer");
    const btnPrev = document.getElementById("merchPrev");
    const btnNext = document.getElementById("merchNext");

    btnPrev.addEventListener("click", () => {
        container.scrollBy({ left: -400, behavior: "smooth" });
    });

    btnNext.addEventListener("click", () => {
        container.scrollBy({ left: 400, behavior: "smooth" });
    });
});
