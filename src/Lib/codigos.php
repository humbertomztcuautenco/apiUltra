<?php
namespace App\Lib;

class Codigos
{
	public static function generar($long)
	{
		if ($long==4) {
			$caracteres = "1234567890"; 
		}elseif ($long >= 6) {
			$caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; 
		}
		
		$cadena = "";
		while ( strlen($cadena) < $long) {
			   $cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); 
		}
		return $cadena;
	}
}