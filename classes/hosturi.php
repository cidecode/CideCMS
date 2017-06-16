<?php 

/*
 * This is class for manipulation over the 
 * links and urls. 
 */

class HostUri
{
	# Redirect domain.com to www.domain.com
	# but not if localhost
	public function www_redirect(){
		/*global $c;
		if($_SERVER['SERVER_NAME'] != "localhost"){
			$srv_name_ary=explode(".",$_SERVER['SERVER_NAME']);
			$is_www=$srv_name_ary[0];
			if($is_www != "www"){
				$dmp="SELECT option_value FROM cm_options WHERE option_name=\"site_host\"";
				$d=$c->query($dmp);
				$v=$d->fetch_assoc();
				$url_redirect=$v['option_value'];
				header("Location: $url_redirect");
				exit;
			}
		}*/

		if($_SERVER['SERVER_NAME'] != "localhost"){
			$srv_name_ary=explode(".",$_SERVER['SERVER_NAME']);
			$is_www=$srv_name_ary[0];
			if($is_www != "www"){
				$u='http://www.'.$_SERVER['SERVER_NAME'].''.$_SERVER['REQUEST_URI'];
				$a=explode('/',$u);
				$pw='';
				for($i=0; $i<count($a)-2; $i++)
				{ 
					if($i == count($a)-3) $pw.=$a[$i];
					else $pw.=$a[$i].'/';
				}
				header("Location: $pw");
				exit;
			}
		}
	}

	# Get server name with prefix or not
	# Usage: call host() function with passed string or none
	# Options: none or /, http for http://, https for https://, whttp for http://www, whttps for https://www
	# Output: example.com, http://example.com, https://example.com, http://www.example.com, https://www.example.com
	public function host($t){
		switch($t){
			case '/':
			case '': 
				return $_SERVER['SERVER_NAME']; 
				break;
			case 'http':
				$w='http://'.$_SERVER['SERVER_NAME'];
				break; 
			case 'https':
				$w='https://'.$_SERVER['SERVER_NAME'];
				break; 
			case 'whttp':
				$w='http://www'.$_SERVER['SERVER_NAME'];
				break; 
			case 'whttps':
				$w='https://www'.$_SERVER['SERVER_NAME'];
				break; 
			default: echo('Wrong type: host() stoped.'); break;
		}
	}

	# Grab whole address inside address bar
	# Usage: call host_uri() function
	function host_uri(){
		$w='http://'.$_SERVER['SERVER_NAME'].''.$_SERVER['REQUEST_URI'];
		return $w;
	}

	# Grab whole address inside address bar withour parametars
	# Usage: call host_uri_noparm() function
	function host_uri_noparm(){
		$w='http://'.$_SERVER['SERVER_NAME'].''.strtok($_SERVER["REQUEST_URI"],'?');
		return $w;
	}

	# Grab site url until page
	# Example: http://www.example.com/dir1/page.php will return http://www.example.com/dir1/
	# Usage: call host_dir() and pass it an option: '' or '/' for self url and 'http://example.com' for custom url
	function host_dir($r){
		if($r == '' || $r == '/'){
			$u=host_uri();
			$a=explode('/',$u);
			$pw='';
			for($i=0; $i<count($a)-1; $i++){
				$pw.=$a[$i].'/';
			}
			return $pw;
		}
		else{
			$a=explode('/',$r);
			$pw='';
			for($i=0; $i<count($a)-1; $i++){
				$pw.=$a[$i].'/';
			}
			return $pw;
		}
	}

	# Grab the last dir
	# Example: http://www.example.com/dir1/page.php will return dir1
	# Usage: call host_dir() and pass it an option: '' or '/' for self url and 'http://example.com' for custom url
	function last_dir($r){
		if($r == '' || $r == '/'){
			$u=host_uri();
			$a=explode('/',$u);
			$pw='';
			for($i=count($a)-2; $i>0; $i--){
				$pw=$a[$i];
				break;
			}
			return $pw;
		}
		else{
			$a=explode('/',$r);
			$pw='';
			for($i=count($a)-2; $i>0; $i--){
				$pw=$a[$i];
				break;
			}
			return $pw;
		}
	}
}

# Try to create host_uri object
try
{
	$host_uri = new HostUri();
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>