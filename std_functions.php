<?php
	function sum_the_time($time1, $time2) {
	  $times = array($time1, $time2);
	  $seconds = 0;
	  foreach ($times as $time) {
	    list($hour,$minute,$second) = explode(':', $time);
	    $seconds += $hour*3600;
	    $seconds += $minute*60;
	    $seconds += $second;
	  }
	  $hours = floor($seconds/3600);
	  $seconds -= $hours*3600;
	  $minutes  = floor($seconds/60);
	  $seconds -= $minutes*60;
	  // return "{$hours}:{$minutes}:{$seconds}";
	  return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
	}
?>