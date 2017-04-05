/* Hide the mobile menu when the screen size changes. */
$(window).resize(function(){
    $('.navmobile').hide();
})

/* Show or hide the mobile menu when the user clicks the hamburger/ */
function toggleMenu(x) {
    x.classList.toggle("change");
    $('.navmobile').toggle("display");
}

$("#top_root_post li").on("click", function (e) {
    e.stopPropagation();// stop the click from bubbling up and firing the parent events as well.
    $(this).children().not('span:first').slideToggle(); // hide all of the clicked post's replys (children) except the first, which is its badge span of its reply count.
});

