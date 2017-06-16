<div class="cycle-slideshow"
	data-cycle-fx="scrollHorz"
    data-cycle-pause-on-hover="true"
    data-cycle-speed="200" style="max-width: 900px">
    <?php 
    	// Grab images for slider
    	$dmp="SELECT cs_id,link FROM cm_cideslider ORDER BY slide_order";
    	if($d=$c->query($dmp)){
    		while($r=$d->fetch_assoc()){
    			echo "<img src=\"".$r['link']."\" alt=\"".$r['cs_id']."\" style=\"max-width: 900px\" />";
    		}
    	}
    	else{
    		echo $c->error;
    	}

    ?>
</div>