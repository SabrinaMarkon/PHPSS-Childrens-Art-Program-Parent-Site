<?php
class Layout
{
	function showHeader() {
		include "header.php";
	}
	function showFooter() {
		include "footer.php";
	}
    function showAdminHeader() {
        include "../header.php";
    }
    function showAdminFooter() {
        include "../footer.php";
    }
}
