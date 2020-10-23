<?php

function print_array($arr)
{
	echo "<div><pre>";
	print_r($arr);
	echo "</pre>--------------------</div>";
}


function print_marray($arrayObject)
{
	foreach($arrayObject as $key=>$data)
	{
		if(is_array($data))
		{
			print_marray($data);
		}
		elseif(is_object($data))
		{
			print_marray($data);
		}
		else
			echo "Key: ".$key." Data: ".$data."<br />";
	}
}

?>