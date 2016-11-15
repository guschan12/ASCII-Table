<?php
function __autoload($className)
{
	$searchArray = array(
			'/models/',
			'/components/'
		);

	foreach($searchArray as $search)
	{		
		$search = ROOT . $search . $className . '.php';
		if(is_file($search))
		{
			include_once $search;
		}
	}
}