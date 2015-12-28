<?php
/*
 *
 *	For a longer working ======>
 *
 */
set_time_limit ( 0 );
/*
 *
 *	<====== Include main class ======>
 *
 */
include "Cartoonfy.class.php";
/*
 *
 *	<====== Create effect ======>
 *
 */

	/*
	 *
	 *	Set-up parameters
	 *
	 */
$params = Array (
    'Triplevel' => 1.0,
    'Diffspace' => ( 1.0 / 32.0 )
);
	/*
	 *
	 *	Create effect
	 *
	 *	Constructor parameters: String image source, Float triplevel, Float diffspace
	 *
	 *
	 *	Callback function parameters: String output image format, Boolean attachment
	 *
         *
 	 *	./effect/Cartoonfy.php?source=image.jpg
	 *
 	 */
$cartoonfy = new Cartoonfy ( $_GET["source"], $params [ 'Triplevel' ], $params [ 'Diffspace' ] );
//$cartoonfy = new Cartoonfy ( "http://www.animalisti.it/prg/upload/campagne_scheda/sched_cane.jpg", $params [ 'Triplevel' ], $params [ 'Diffspace' ] );
$cartoonfy -> showCartoonfy ( "jpg", false );


?>
