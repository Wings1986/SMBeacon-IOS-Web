<div class="box">
	<div class="box-head tabs">
		<h3><?php echo $Title;?></h3>
	</div>
	<div class="box-head tabs">
		<div class="tab-pane" id="condensed">
			<div class="box-content">
				<form action="index.php?page=editbeacon&mID=<?php echo $beacon['merchant_id']; ?>" class='validate form-horizontal' method="post" name="editbeacon" enctype="multipart/form-data">
					<div class="control-group">
						<label for="title" class="control-label">UUID</label>
						<div class="controls">
							<input type="text" name="uuid" value="<?php echo $beacon['uuid']?>" class='{required:true} span8'>
						</div>
					</div>
					<div class="control-group">
						<label for="title" class="control-label">Offer</label>
						<div class="controls">
						    <select name='offer_id' class='span8'>
                                <option value='0'>&nbsp;</option>
                                <?php $row = $db->single_row( 'offer', "id, title", 'id=' . $beacon['offer_id'] );
                                if ( $row ) {
                                    printf( "<option value='%s' %s>%s</option>", $row['id'], ( $row['id'] == $beacon['offer_id'] ) ? 'selected' : '' ,$row['title']);
                                } ?>
                                <?php
                                $sql = "SELECT offer.id, offer.title FROM offer LEFT JOIN beacon ON offer.id = beacon.`offer_id` WHERE beacon.id IS NULL AND offer.`merchant_id` = {$_REQUEST['mID']}";
                                $res = mysql_query($sql);
                                while ( $row = mysql_fetch_assoc ($res) ) {
                                    printf( "<option value='%s' %s>%s</option>", $row['id'], ( $row['id'] == $beacon['offer_id'] ) ? 'selected' : '' ,$row['title']);
                                }
                                ?>
						    </select>
						</div>
					</div>
					<div class="form-actions">
						<input type="hidden" name="bID" value="<?php echo $beacon['id']?>">
						<input type="submit"  value="Save" name="UpdateBeacon" class='btn btn-primary'>
						<input type="button" class="btn btn-danger" onClick="location.href='<?php echo "index.php?page=beacon&mID=" . $_REQUEST['mID'] ?>'" value="Cancel"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>