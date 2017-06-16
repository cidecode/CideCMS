<?php 

/*
 * This is class that encrypt all passwords on CMS.
 * It is based on SS1 encryption (Shift Shell level 1).
 * NOTICE: DO NOT CHANGE THIS FILE. 
 */


class SS1
{
	function shiftshell($x){
		$p=sha1(md5($x));
		$sa=['a','x','D','4','f','H','7','G','q','C','9','5','h','P','q'];
		$fs='#'; $ls=''; $c=0;
		for($k=3; $k<$k+11; $k+=2){
			$fs.=$sa[1].$sa[2].$sa[0].$sa[5].$sa[7];
			for($t=2; $t>$t-13; $t-=3){
				$ls.=$sa[8].$sa[12].$sa[3].$sa[4].$sa[13];
				break;
			}
			if($k!=3) break;
		}
		for($o=2; $o<$o+2; $o++){
			$p=sha1($p);
			$c++;
			if($c==7){
				$z=$fs.''.$p.''.$ls;
				break;
			}
		}
		return $z;
	}
}

# Try to create TS1 object
try
{
	$ss1 = new SS1();
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>