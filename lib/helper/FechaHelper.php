<?php

$secondsPerMinute = 60;
$minutesPerHour = 60;
$hoursPerDay = 24;
$daysPerMonth = 30;
$daysPerYear = 365;

$secondsPerHour = $secondsPerMinute * $minutesPerHour;
$secondsPerDay = $secondsPerHour * $hoursPerDay;
$secondsPerMonth = $daysPerMonth * $secondsPerDay;
$secondsPerYear = $daysPerYear * $secondsPerDay;

function diasFaltantes($hastaFecha)
{
	$currentDate = date("d-M-Y H:i:s"); 
	
    $dateDiff = strtotime($hastaFecha) - strtotime($currentDate);
   
    $fullDays = floor($dateDiff/(60*60*24));   
    
	return $fullDays;
}

function tiempoFaltante($hastaTiempo)
{
    $dateDiff = strtotime($hastaTiempo) - time();
    
    $fullDays = floor($dateDiff/(60*60*24));
    $fullHours = floor(($dateDiff-($fullDays*60*60*24))/(60*60));  
	$fullMinutes = floor(($dateDiff-($fullDays*60*60*24)-($fullHours*60*60))/60);
	$fullSeconds = $dateDiff - ($fullDays*60*60*24) - ($fullHours*60*60) -($fullMinutes*60);
	
	return date("H:i:s", mktime( $fullHours, $fullMinutes, $fullSeconds ));
}