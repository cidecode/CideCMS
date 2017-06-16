<?php 

/*
 * This class is for creating site map
 */

class Sitemap
{
	public function __construct()
	{
		global $c;
		global $constants;

		$dmp="SELECT link as ln	FROM cm_posts WHERE type=1";
							
		if($d=$c->query($dmp)){
			$rss_content="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
						  <urlset
		      					xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"
		      					xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
		      					xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
		            			http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">";

		    $skip=0;
		    $priority=1.00;
		    $priority_change=10;
			while($r=$d->fetch_assoc()){
				if($skip == 1){
					$priority*=0.8;
				}
				else if($skip > $priority_change){
					$priority*=0.8;
					$priority_change+=5;
				}

				$rss_content.="
				<url>
					<loc>".$r['ln']."</loc>
					<changefreq>daily</changefreq>
					<priority>$priority</priority>
				</url>
				";

				$skip++;
			}

			$rss_content.="
			</urlset>";

			$rss_file=fopen('.'.$constants::ROOT_PATH.'/sitemap.xml',w);
			fwrite($rss_file,$rss_content);
			fclose($rss_file);

			$d->free_result();
		}
	}
}


?>