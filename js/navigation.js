/* Hide the mobile menu when the screen size changes. */
$(window).resize(function(){
    $('.navmobile').hide();
})

/* Show or hide the mobile menu when the user clicks the hamburger/ */
function toggleMenu(x) {
    x.classList.toggle("change");
    $('.navmobile').toggle("display");
}

/* For the threaded post tree collapse/expand */
$("#top_root_post li").on("click", function (e) {
    e.stopPropagation();// stop the click from bubbling up and firing the parent events as well.
    whichone = 'chevron' + $(this).attr('id');

    if ($('#' + whichone).hasClass('glyphicon-chevron-right')) {
        $('#' + whichone).addClass('glyphicon-chevron-down');
        $('#' + whichone).removeClass('glyphicon-chevron-right');
    }
    else {
        $('#' + whichone).addClass('glyphicon-chevron-right');
        $('#' + whichone).removeClass('glyphicon-chevron-down');
    }

    // hide all of the clicked post's replys (children) except the first, which is its badge span of its reply count.
    $(this).children().not('span:first, i:first').slideToggle();
});

