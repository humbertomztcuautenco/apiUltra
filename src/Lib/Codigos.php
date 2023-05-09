<?php
namespace App\Lib;

class Codigos
{
	public static function generar($long)
	{
		if ($long==4) {
			$caracteres = "1234567890"; //posibles caracteres a usar
		}elseif ($long >= 6) {
			$caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
		}
		
		$cadena = ""; //variable para almacenar la cadena generada
		while ( strlen($cadena) < $long) {
			   $cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); 
		}
		return $cadena;
	}
}