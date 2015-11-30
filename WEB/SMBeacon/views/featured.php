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
								<th width="200">Small Icon</th>
								<th width="200">Large Icon</th>
								<th width="">Package</th>
								<!-- <th width="200">Play Store</th> -->
								<th width="90">Operations</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$m=1;
					    while($r = mysql_fetch_array($featuredapps)){
						?>	
							<tr>
								<td style="text-align: center;"><?php echo $m.$q;?></td>
								<td style="text-align: center;">
									<?php 
										if(is_file("pic/phonedp/".$r['package'].".png")){
									?>
											<a href="pic/phonedp/<?php echo $r['package']?>.png" class="preview fancy">
												<img src="pic/phonedp/<?php echo $r['package']?>.png" width="180" class=""/>
											</a>
									<?php 
										}
										else {
									?>
											<img src="pic/no-thumbnail.png" width="180" class=""/>
									<?php 
										}
									?>
								</td>
								<td style="text-align: center;">
									<?php 
										if(is_file("pic/sw720dp/".$r['package'].".png")){
									?>
											<a href="pic/sw720dp/<?php echo $r['package']?>.png" class="preview fancy">
												<img src="pic/sw720dp/<?php echo $r['package']?>.png" width="180" class=""/>
											</a>
									<?php 
										}
										else {
									?>
											<img src="pic/no-thumbnail.png" width="180" class=""/>
									<?php 
										}
									?>
								</td>
								<td style="text-align:center;"><?php echo $r['package'];?></td>	
								<!-- <td style="text-align:center;">
									<a href="<?php echo "https://play.google.com/store/apps/details?id=".$r['package'];?>" target="blank">
										Play Store Link
									</a>
								</td> -->		
								<td style="text-align: center;">
									<div class="btn-group">
										<a href="index.php?page=editfeatured&fID=<?php echo $r['id'];?>" class='btn btn-mini tip' title="Edit"><img src="img/icons/fugue/hammer-screwdriver.png" alt=""></a>
										<a href="index.php?page=featured&fID=<?php echo $r['id'];?>&act=del" onclick="javascript: return confirm('Are You Sure Want to Delete this Featured App?');" class='btn btn-mini tip' title="Remove"><img src="img/icons/fugue/cross.png" alt=""></a>
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
					<form action="index.php?page=addfeatured" class='validate form-horizontal' method="post" name="adduser" enctype="multipart/form-data">
						
						<div class="control-group">
							<label for="title" class="control-label">Package</label>
							<div class="controls">
								<input type="text" name="package" value="<?php echo $_REQUEST['package']?>" class='{required:true} span8'>
							</div>
						</div>
						<div class="control-group">
							<label for="avatar" class="control-label">Small Icon</label>
							<div class="controls">
								<input class="input-file uniform_on" id="small_icon" name="small_icon" type="file" class='{required:true}' >
							</div>
						</div>
						<div class="control-group">
							<label for="avatar" class="control-label">Large Icon</label>
							<div class="controls">
								<input class="input-file uniform_on" id="large_icon" name="large_icon" type="file" class='{required:true}' >
							</div>
						</div>
						<div class="form-actions">
							<input type="submit"  value="Save" name="AddFeatured" class='btn btn-primary'>
						</div>
					</form>
				</div>					
			</div>
									
		</div>
	</div>
</div>