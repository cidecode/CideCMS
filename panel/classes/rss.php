<?php 

/*
 * This class is for creating RSS feed
 */

class RSS
{

	public function __construct()
	{
		global $c;
		global $constants;

		$dmp="SELECT po_id,title as tt,content as ct,cat_name as cn,link as ln,p.active as ac,protect as pr,create_date as cd,
			CASE WHEN nickname IS NOT NULL THEN nickname ELSE username END as nm
			FROM (cm_posts p INNER JOIN cm_category c ON category=c.ca_id) INNER JOIN cm_users u ON author=us_id
			WHERE p.type=0
			ORDER BY create_date DESC";
			
				
		if($d=$c->query($dmp)){
			$rss_content="<?xml version=\"1.0\" encoding=\"utf-8\"?>
			<?xml-stylesheet type=\"text/css\" href=\"shinerss.css\"?>
			<rss version=\"2.0\">
			<channel>";

			while($r=$d->fetch_assoc()){
				$rss_content.="
				<item>
					<title>".$r['tt']."</title>
					<link>".$r['ln']."</link>
					<author>".$r['nm']."</author>
					<pubDate>".date("d.m.Y",$r['cd'])." - ".date("H:m:s",$r['cd'])."</pubDate>
					<description>".html_entity_decode(strip_tags($r['ct']))."</description>
				</item>
				";
			}

			$rss_content.="
			</channel>
			</rss>";

			$rss_file=fopen('.'.$constants::ROOT_PATH.'/rss.xml','w');
			fwrite($rss_file,$rss_content);
			fclose($rss_file);

			$d->free_result();
		}
	}
}


?>