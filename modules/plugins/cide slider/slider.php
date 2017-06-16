<div class="cycle-slideshow"
	data-cycle-fx="scrollHorz"
    data-cycle-pause-on-hover="true"
    data-cycle-speed="200" style="max-width: 900px">
    <?php 
        
    	// Grab images for slider
    	$dmp="SELECT cs_id as ci, link as ln FROM cm_cideslider WHERE active=1 ORDER BY slide_order";
    	if($d=$c->query($dmp)){
    		while($r=$d->fetch_assoc()){
    			echo "<img src=\"".$r['ln']."\" alt=\"".$r['ci']."\" style=\"max-width: 900px; max-height: 200px;\" />";
    		}
    	}
    	else{
    		echo $c->error;
    	}

    ?>
</div>