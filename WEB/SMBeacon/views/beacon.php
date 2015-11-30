<div class="box">
	<div class="box-head tabs">
		<h3><?php echo $Title;?></h3>
		<ul class='nav nav-tabs'>
			<li class='active'>
				<a href="#basic"  data-toggle="tab">Listing</a>
			</li>
			<li>
				<a href="#condensed"  data-toggle="tab">Add</a>
			</li>
		</ul>
	</div>
	<div class="box-content box-nomargin">
		<div class="tab-content">
			<div class="tab-pane active" id="basic">
				<div class="box-content box-nomargin">
					<table class='table table-striped dataTable table-bordered'>
						<thead>
							<tr>
								<th width="40">No.</th>
								<th>UUID</th>
								<th>Offer</th>
								<th width="90">Operations</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$m=1;
					    while($r = mysql_fetch_array($beacon)){
						?>
							<tr>
								<td style="text-align: center;"><?php echo $m.$q;?></td>
								<td style="text-align: center;"><?php echo $r['uuid'];?></td>
								<td style="text-align: center;"><a href="/index.php?page=offer&mID=<?php echo $r['merchant_id'];?>"><?php
								$offer = $db->single_row("offer", "*", "id='" . $r['offer_id'] . "'"); 
								echo $offer['title'];?></a></td>
								<td style="text-align: center;">
									<div class="btn-group">
										<a href="index.php?page=editbeacon&mID=<?php echo $_REQUEST['mID'] ?>&bID=<?php echo $r['id']; ?>" class='btn btn-mini tip' title="Edit"><img src="img/icons/fugue/hammer-screwdriver.png" alt=""></a>
										<a href="index.php?page=beacon&mID=<?php echo $_REQUEST['mID']; ?>&bID=<?php echo $r['id']; ?>&act=del" onclick="javascript: return confirm('Are You Sure Want to Delete?');" class='btn btn-mini tip' title="Remove"><img src="img/icons/fugue/cross.png" alt=""></a>
									</div>
								</td>
							</tr>
						<?php	 	
						$m++;
						}
						?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane" id="condensed">
				<div class="box-content">
					<form action="index.php?page=addbeacon&mID=<?php echo $_REQUEST['mID'] ?>" class='validate form-horizontal' method="post" name="addbeacon" enctype="multipart/form-data">
						<div class="control-group">
							<label for="title" class="control-label">UUID</label>
							<div class="controls">
								<input type="text" name="uuid" value="<?php echo getGUID() ?>" class='{required:true} span8'>
							</div>
						</div>
						<div class="control-group">
							<label for="title" class="control-label">Offer</label>
							<div class="controls">
							    <select name='offer_id' class='span8'>
                                    <option value='0'>&nbsp;</option>
                                    <?php
                                    $sql = "SELECT offer.id, offer.title FROM offer LEFT JOIN beacon ON offer.id = beacon.`offer_id` WHERE beacon.id IS NULL AND offer.`merchant_id` = {$_REQUEST['mID']}";
                                    $res = mysql_query($sql);
                                    while ( $row = mysql_fetch_assoc ($res) ) {
                                        printf( "<option value='%s'>%s</option>", $row['id'], $row['title']);
                                    }
                                    ?>
							    </select>
							</div>
						</div>
						<div class="form-actions">
							<input type="submit"  value="Save" name="AddBeacon" class='btn btn-primary'>
						</div>
					</form>
				</div>					
			</div>
		</div>
	</div>
</div>