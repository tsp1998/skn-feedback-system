<?php 
	function adjYear($year) {
			return '20'.$year.'-20'.($year+1);
	}


	function adjClass($class) {
		switch ($class) {
			case '1':
			$class='fe';	
			break;
			case '2':
			$class='se';	
			break;
			case '3':
			$class='te';	
			break;
			case 'be':

			default:
			$class='';	
			break;
			}
			return $class;
	}

	function adjDept($dept) {
		switch ($dept) {
			case '1':
			$dept='cse';	
			break;
			case '2':
			$dept='mech';	
			break;
			case '3':
			$dept='entc';	
			break;
			case '4':
			$dept='civil';	
			break;
			case '5':
			$dept='elect';	
			break;
			case '6':
			$dept='fe';	
			break;

			default:
			$dept='';	
			break;
			}
			return $dept;
	}

	function adjDiv($div) {
		switch ($div) {
			case '1':
				$div='A';	
			break;
			case '2':
				$div='B';	
			break;
			case '3':
				$div='C';	
			break;
			case '4':
				$div='D';	
			break;
			case '5':
				$div='E';	
			break;
			case '6':
				$div='-';	
			break;
			default:
				$div='';	
			break;
			}
			return $div;
	}
