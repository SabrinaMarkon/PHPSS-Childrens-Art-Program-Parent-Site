<?php
class Countries
{
	public $country;
	public $countryselectlist;

	function showCountries() {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$sql = "select * from countries where country_name!=\"United States\" and country_name!=\"Canada\" order by country_id";
		$countryselectlist = "";
		foreach($pdo->query($sql) as $country)
		{
			$selected = "";
			if ($country == $country["country_name"])
			{
				$selected = "selected";
			}
			$countryselectlist .= "<option value=\"" . $country["country_name"] . " " . $selected . "\">" . $country["country_name"] . "</option>";
		}
		Database::disconnect();
		return $countryselectlist;
	}

}