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
								<th>Code</th>
								<th>Title</th>
								<th>Description</th>
								<th width="200">Pic</th>
								<th>Original Price</th>
								<th>Offer Price</th>
								<th>Time Limit</th>
								<th>Expire Date</th>
								<th width="90">Operations</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$m=1;
					    while($r = mysql_fetch_array($offer)){
						?>	
							<tr>
								<td style="text-align: center;"><?php echo $m.$q;?></td>
								<td style="text-align:center;"><?php echo $r['code'];?></td>
								<td style="text-align:center;"><?php echo $r['title'];?></td>	
								<td style="text-align:center;"><?php echo $r['description'];?></td>
								<td style="text-align: center;">
									<?php 
										if(is_file($r['picture'])){
									?>
										<a href="<?php echo $r['picture']?>" class="preview fancy">
											<img src="<?php echo $r['picture']?>" width="180" class=""/>
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
								<td style="text-align:center;"><?php echo $r['original_price'];?></td>	
								<td style="text-align:center;"><?php echo $r['offer_price'];?></td>	
								<td style="text-align:center;"><?php echo $r['time_limit'];?></td>	
								<td style="text-align:center;"><?php echo date('Y-m-d', strtotime($r['expire_date']));?></td>	
								<td style="text-align: center;">
									<div class="btn-group">
										<a href="index.php?page=editoffer&mID=<?php echo $_REQUEST['mID'];?>&oID=<?php echo $r['id'];?>" class='btn btn-mini tip' title="Edit"><img src="img/icons/fugue/hammer-screwdriver.png" alt=""></a>
										<a href="index.php?page=offer&mID=<?php echo $_REQUEST['mID'];?>&oID=<?php echo $r['id'];?>&act=del" onclick="javascript: return confirm('Are You Sure Want to Delete?');" class='btn btn-mini tip' title="Remove"><img src="img/icons/fugue/cross.png" alt=""></a>
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
					<form action="index.php?page=addoffer&mID=<?php echo $_REQUEST['mID'] ?>" class='validate form-horizontal' method="post" name="addmerchant" enctype="multipart/form-data">
						<div class="control-group">
							<label for="title" class="control-label">Code</label>
							<div class="controls">
								<input type="text" name="code" value="<?php echo getGUID(6) ?>" class='{required:true} span8'>
							</div>
						</div>
						<div class="control-group">
							<label for="title" class="control-label">Title</label>
							<div class="controls">
								<input type="text" name="title" value="<?php echo $_REQUEST['title']?>" class='{required:true} span8'>
							</div>
						</div>
						<div class="control-group">
							<label for="title" class="control-label">Description</label>
							<div class="controls">
							    <textarea name="description" rows="5" cols="" class='{required:true} span8'><?php echo $_REQUEST['address']?></textarea>
							</div>
						</div>
						<div class="control-group">
							<label for="avatar" class="control-label">Picture</label>
							<div class="controls">
								<input class="input-file uniform_on {required:true}" id="picture" name="picture" type="file" >
							</div>
						</div>
						<div class="control-group">
							<label for="title" class="control-label">Original Price</label>
							<div class="controls">
								<input type="text" name="original_price" value="<?php echo $_REQUEST['original_price']?>" class='{required:true} span8'>
							</div>
						</div>
						<div class="control-group">
							<label for="title" class="control-label">Offer Price</label>
							<div class="controls">
								<input type="text" name="offer_price" value="<?php echo $_REQUEST['offer_price']?>" class='{required:true} span8'>
							</div>
						</div>
						<div class="control-group">
							<label for="title" class="control-label">Time Limit(hr)</label>
							<div class="controls">
								<input type="number" min="1" max="72" name="time_limit" value="<?php echo $_REQUEST['time_limit'] ? $_REQUEST['time_limit'] : '1' ?>" class='{required:true} span8'>
							</div>
						</div>
						<div class="control-group">
							<label for="title" class="control-label">Expire Date</label>
							<div class="controls">
								<input type="text" name="expire_date" value="<?php echo $_REQUEST['expire_date']?>" class='{required:true} span8'>
							</div>
						</div>
						<div class="form-actions">
							<input type="submit"  value="Save" name="AddOffer" class='btn btn-primary'>
						</div>
					</form>
				</div>					
			</div>
		</div>
	</div>
</div>