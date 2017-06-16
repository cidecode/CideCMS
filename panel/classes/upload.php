<?php 

/*
 * This is a class for uploading files
 */

class Upload
{
	public $upl_res;
	public $upl_last_id;

	public function AddFile()
	{
		global $c;
		global $constants;
		global $options;

		// List of supported files
		$mime_supported_types=array( // Not working for exe,zip,rar
								// Text
								"text/plain" => "txt",
								"text/css" => "css",
								"text/x-java-source" => "java",
								// Image
								"image/png" => "png",
								"image/jpeg" => "jpeg",
								"image/gif" => "gif",
								"image/vnd.microsoft.icon" => "ico",
								"image/tiff" => "tiff",
								// Audio
								"audio/mpeg" => "mp3",
								"audio/x-ms-wma" => "wma",
								"audio/scpls" => "pls",
								// Video
								"video/x-flv" => "flv",
								"video/quicktime" => "mov",
								"video/x-msvideo" => "avi",
								"video/x-ms-wmv" => "wmv",
								"video/mpeg" => "mpeg",
								"video/mp4" => "mp4",
								// Application
								"application/x-shockwave-flash" => "swf",
								"application/zip" => "zip",
								"application/x-zip" => "zip",
								"application/x-zip-compressed" => "zip",
								"application/x-compress" => "zip",
								"application/x-compressed" => "zip",
								"multipart/x-zip" => "zip",
								"application/x-rar-compressed" => "rar",
								"application/x-7z-compressed" => "7z",
								"application/pdf" => "pdf",
								"application/java-archive" => "jar",
								"application/x-msdownload" => "exe",
								"application/x-dosexec" => "exe",
								"application/exe" => "exe",
								"application/x-exe" => "exe",
								"application/dos-exe" => "exe",
								"application/x-winexe" => "exe",
								"application/msdos-windows" => "exe",
								"application/x-bittorrent" => "torrent",
								"application/vnd.openxmlformats-officedocument.presentationml.presentation" => "pptx",
								"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" => "xlsx",
								"application/vnd.openxmlformats-officedocument.wordprocessingml.document" => "docx",
								"application/vnd.ms-powerpoint" => "ppt",
								"application/vnd.ms-excel" => "xls",
								"application/msword" => "doc", 
								"application/mp4" => "mp4", 
								"application/octet-stream" => "octet-stream"
								); 


		// Number of supported mime types
		$mime_type_num=count($mime_supported_types);

		// Checking and uploading
		if(isset($_FILES['upload']) && !empty($_FILES['upload']['name'])){

			// Uploaded file type
			$upl_type=$_FILES['upload']['type'];

			foreach ($mime_supported_types as $indx => $vale) {
				if($upl_type == $indx){
					$type_exists=1;
					$upl_ext=$vale;
					$type_sort=explode("/",$indx)[0];
					break;
				}
			} 
			
			// Upload file name
			$upl_name=$_FILES['upload']['name'];

			// Check for above not registred types (browser bug)
			/*if(preg_match('/(.*)\.zip/',$upl_name)){
				$type_exists=1;
				$upl_ext="zip";
				$type_sort="application";
			}
			else if(preg_match('/(.*)\.ZIP/',$upl_name)){
				$type_exists=1;
				$upl_ext="ZIP";
				$type_sort="application";
			}
			else if(preg_match('/(.*)\.rar/',$upl_name)){
				$type_exists=1;
				$upl_ext="rar";
				$type_sort="application";
			}
			else if(preg_match('/(.*)\.7z/',$upl_name)){
				$type_exists=1;
				$upl_ext="7z";
				$type_sort="application";
			}
			else if(preg_match('/(.*)\.exe/',$upl_name)){
				$type_exists=1;
				$upl_ext="exe";
				$type_sort="application";
			}
			else if(preg_match('/(.*)\.msi/',$upl_name)){
				$type_exists=1;
				$upl_ext="msi";
				$type_sort="application";
			}*/

			// Stop script if file type is not allowed
			if(!isset($type_exists) || $type_exists != 1){
				exit(header("Location: addmedia.php?m=120&type=$upl_type"));
			}

			// Find max file size on choosen file type
			if(isset($type_exists) && $type_exists == 1){
				switch ($type_sort){
					case 'text':
						$max_file_size=$constants::TXT_MAX_SIZE*1024;
						break;
					case 'image':
						$max_file_size=$constants::IMG_MAX_SIZE*1024;
						break;
					case 'audio':
						$max_file_size=$constants::AUD_MAX_SIZE*1024;
						break;
					case 'video':
						$max_file_size=($constants::VID_MAX_SIZE*1024)*1024;
						break;
					case 'application':
						$max_file_size=($constants::APP_MAX_SIZE*1024)*1024;
						break;
				}
			}

			if(isset($max_file_size) && $_FILES['upload']['size'] <= $max_file_size){
				$min=1111; $max=mt_getrandmax();
				$next_upl=mt_rand($min,$max);

				
				$upl_size=$_FILES['upload']['size'];
				$upl_tmp=$_FILES['upload']['tmp_name'];
				if(isset($_POST['upl_desc'])) $upl_desc=$_POST['upl_desc']; else $upl_desc=NULL;

				$shr_type=explode("/",$upl_type)[1];
				$dir_name=date("m").".".date("Y");

				# Create folder if it not exist
				if(!file_exists("./".$constants::MEDIA_PATH."/$dir_name")){
					mkdir("./".$constants::MEDIA_PATH."/$dir_name", 0754, true);
				}

				# Upload file
				if(file_exists("./".$constants::MEDIA_PATH."/$dir_name/$next_upl.$upl_ext")){
					while(1){
						$next_upl=mt_rand($min,$max);
						if(!file_exists("./".$constants::MEDIA_PATH."/$dir_name/$next_upl.$upl_ext")){
							break;
						}
					}
				}
				else{
					move_uploaded_file($upl_tmp, "./".$constants::MEDIA_PATH."/$dir_name/$next_upl.$upl_ext");
					$new_img=$options->site_host()."/media/$dir_name/$next_upl.$upl_ext";
										
					$upl_date=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

					$dmp="INSERT INTO cm_media(name,description,link,media_type,media_size,upload_date)
							VALUES(
								\"$upl_name\",
								\"$upl_desc\",
								\"$new_img\",
								\"$upl_type\",
								$upl_size,
								$upl_date)";
							
					if($c->query($dmp)){
						$this->upl_res=$new_img;
						$this->upl_last_id=$c->insert_id;
					}
					else{
						$this->upl_res=NULL;
						exit(header("Location: addmedia.php?m=121"));
					}
				}
			}
		}
		else{
			//exit(header("Location: addmedia.php?m=119"));
			$this->upl_res=NULL;
		}
	}

	public function GetUploadResult()
	{
		return $this->upl_res;
	}
}
				
?>