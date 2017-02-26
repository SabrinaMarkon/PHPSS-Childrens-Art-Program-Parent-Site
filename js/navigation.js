/* Hide the mobile menu when the screen size changes. */
$(window).resize(function(){
    $('.navmobile').hide();
})

/* Show or hide the mobile menu when the user clicks the hamburger/ */
function toggleMenu(x) {
    x.classList.toggle("change");
    $('.navmobile').toggle("display");
}

