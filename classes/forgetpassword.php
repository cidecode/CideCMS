<?php 

/*
 * This is a class for sending reset key to email address
 */

class ForgetPassword
{
	// Grab user data and execute stuff
	public function __construct($username,$email)
	{
		global $c;
		global $options;

		if(strlen($username) >= 1 && strlen($email) > 1){
			$username=trim($username);
			$email=trim($email);
			$create_date=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

			$forgetkey="".mt_rand();
			for($i=1; $i<4; $i++)
			{
				$forgetkey.=mt_rand();
			}

			// SQL dumping - check if user exists and if data matches
			$dmp="SELECT us_id as ui, user_email as ue FROM cm_users WHERE username=\"$username\" AND user_email=\"$email\""; 
			if($d=$c->query($dmp)){
				if($d->num_rows == 1){
					$r=$d->fetch_assoc();
					$ui=$r['ui'];
					$ue=$r['ue'];

					$dmp="INSERT INTO cm_forgetpasswd(user_id,forgetkey,createdate) VALUES($ui,\"$forgetkey\",$create_date)";

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
						$mail->addAddress($ue, $username);     // Add a recipient
						#$mail->addAddress('ellen@example.com');               // Name is optional
						#$mail->addReplyTo('info@example.com', 'Information');
						#$mail->addCC('cc@example.com');
						#$mail->addBCC('bcc@example.com');

						#$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
						#$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
						$mail->isHTML(true);                                  // Set email format to HTML

						$mail->Subject = 'Reset password - '.$options->site_name();
						$mail->Body    = 'Click on the following link to reset your password<br /><br />'.$options->site_host().'/resetpassword.php?key='.$forgetkey;
						$mail->AltBody = 'Click on the following link to reset your password: '.$options->site_host().'/resetpassword.php?key='.$forgetkey;

						if(!$mail->send()){
						    exit(header("Location: forgetpassword.php?m=139"));
						} 
						else{
						    exit(header("Location: forgetpassword.php?m=24"));
						}

						
					}
				}
				else{ 
					exit(header("Location: forgetpassword.php?m=138"));
				}
			}
		}
	}
}

# Try to create ForgetPassword object
try
{
	if(isset($_SESSION['id_username'])){
		exit(header("Location: ".site_host()));
	}
	else
	{
		if(isset($_POST['reset_btn']))
		{
			$forgetpassword = new ForgetPassword($_POST['ur_nm'],$_POST['ur_em']);
		}
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>