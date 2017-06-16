<?php 

/*
 * This class is for deleting old keys
 */


class DeleteOldKeys
{

	public function Run()
	{
		$this->DeleteForgotenKeys();
		$this->DeleteActivationKeys();		
	}

	private function DeleteForgotenKeys()
	{
		global $c;

		$timenow=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

		# Delete forgoten keys
		$dmp="SELECT rp_id as ri, createdate as cd FROM cm_forgetpasswd"; 
		if($d=$c->query($dmp)){
			if($d->num_rows > 0){
				while($r=$d->fetch_assoc())
				{
					$ri=$r['ri'];
					$cd=(int)$r['cd'];
					if($cd+86400 <= (int)$timenow)
					{
						$dmp="DELETE FROM cm_forgetpasswd WHERE rp_id=$ri";
						$c->query($dmp);
					}
				}
			}
		}
	}

	private function DeleteActivationKeys()
	{
		global $c;

		$timenow=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

		# Delete activation keys
		$dmp="SELECT ua_id as ui, createdate as cd FROM cm_useractivation"; 
		if($d=$c->query($dmp)){
			if($d->num_rows > 0){
				while($r=$d->fetch_assoc())
				{
					$ri=$r['ui'];
					$cd=(int)$r['cd'];
					if($cd+604800 <= (int)$timenow)
					{
						$dmp="DELETE FROM cm_useractivation WHERE ua_id=$ui";
						$c->query($dmp);
					}
				}
			}
			
		}
	}
}

# Try to create DeleteOldKeys object
try
{
	$deleteoldkeys = new DeleteOldKeys();
}
catch(Exception $e)
{
	die($e->getMessage());
}


?>