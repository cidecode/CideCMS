<?php 

/*
 * This class is for registrating new users
 */

class Register
{
	# Confirm user log in and create sessions
	# Check users permisions
	public $host_pg;

	public function __construct()
	{
		global $options;

		// Page from which user came
		if(isset($_GET['hu'])){
			$this->host_pg=$_GET['hu'];
		}
		else{
			$this->host_pg=$options->site_host();
		}
	}

	public function RegisterUser($name,$password,$address)
	{
		global $ss1;

		$username = trim($name);
		$passwd = trim($ss1->shiftshell($password));
		$email = trim($address);
		$create_date=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

		// Grab user data and execute stuff
		if(strlen($username)>0 && strlen($passwd)>0 && strlen($email)>0){
			
			global $c;
			global $options;

			# Check if username already exists
			$dmp="SELECT username FROM cm_users WHERE username=\"$username\"";
			if($d=$c->query($dmp)){
				if($d->num_rows != 0){
					exit(header("Location: register.php?m=142"));
				}
				else{
					$dmp="SELECT user_email FROM cm_users WHERE user_email=\"$email\"";
					if($d=$c->query($dmp)){
						if($d->num_rows != 0){
							exit(header("Location: register.php?m=143"));
						}
						else{
							// SQL dumping - check data
							$dmp="INSERT INTO cm_users(username,passwd,user_email,active,type,join_date)
										VALUES(
										\"$username\",
										\"$passwd\",
										\"$email\",
										0,
										4,
										$create_date)"; 

							if($c->query($dmp)){
								

								$last_id=$c->insert_id;
								

								$activatekey="".mt_rand();
								for($i=1; $i<4; $i++)
								{
									$activatekey.=mt_rand();
								}

								$dmp="INSERT INTO cm_useractivation(user_id, activationkey, creationdate) VALUES($last_id, \"$activatekey\", $create_date)";
								if($c->query($dmp)){
									# send email
									require('lib/mailer/PHPMailerAutoload.php');

									$mail = new PHPMailer;

									//$mail->SMTPDebug = 3;                               // Enable verbose debug output

									$mail->isSMTP();                                      // Set mailer to use SMTP
									$mail->Host = $options->smtp_host();  // Specify main and backup SMTP servers
									$mail->SMTPAuth = true;                               // Enable SMTP authentication
									$mail->Username = $options->smtp_username();                 // SMTP username
									$mail->Password = $options->smtp_passwd();                           // SMTP password
									$mail->SMTPSecure = $options->smtp_secure();                            // Enable TLS encryption, `ssl` also accepted
									$mail->Port = $options->smtp_port();                                    // TCP port to connect to

									$mail->setFrom($options->smtp_send_as(), $options->site_name());
									$mail->addAddress($email, $username);     // Add a recipient
									#$mail->addAddress('ellen@example.com');               // Name is optional
									#$mail->addReplyTo('info@example.com', 'Information');
									#$mail->addCC('cc@example.com');
									#$mail->addBCC('bcc@example.com');

									#$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
									#$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
									$mail->isHTML(true);                                  // Set email format to HTML

									$mail->Subject = 'Activate account - '.$options->site_name();
									$mail->Body    = 'Click on the following link to activate your account<br /><br />'.$options->site_host().'/activateuser.php?ackey='.$activatekey;
									$mail->AltBody = 'Click on the following link to activate your account: '.$options->site_host().'/activateuser.php?ackey='.$activatekey;

									if(!$mail->send()){
									    exit(header("Location: register.php?m=144"));
									} 
									else{
									    exit(header("Location: register.php?m=26"));
									}
								} 
							}
							else{
								exit(header("Location: register.php?m=107"));
							}
						}
					}
				}
			}
		}
	}
}

# Try to create Register object
try
{
	$register = new Register();

	if(isset($_POST['reg_btn']))
	{
		$register->RegisterUser($_POST['nu_username'],$_POST['nu_password'],$_POST['nu_email']);
	}
	elseif(isset($_SESSION['id_username'])){
		exit(header("Location: ".site_host()));
	}	
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>