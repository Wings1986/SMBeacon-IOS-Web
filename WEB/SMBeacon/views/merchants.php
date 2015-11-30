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
								<th width="200">Logo</th>
								<th>Business Name</th>
								<th>Address1</th>
								<th>Address2</th>
								<th>City</th>
								<th>State</th>
								<th>Zip</th>
								<th>Email</th>
								<th>Phone</th>
								<th width="90">Operations</th>
								<th width="120">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$m=1;
					    while($r = mysql_fetch_array($merchant)){
						?>	
							<tr>
								<td style="text-align: center;"><?php echo $m.$q;?></td>
								<td style="text-align: center;">
									<?php 
										if(is_file($r['logo'])){
									?>
										<a href="<?php echo $r['logo']?>" class="preview fancy">
											<img src="<?php echo $r['logo']?>" width="180" class=""/>
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
								<td style="text-align:center;"><?php echo $r['business_name'];?></td>	
								<td style="text-align:center;"><?php echo $r['address'];?></td>	
								<td style="text-align:center;"><?php echo $r['address2'];?></td>	
								<td style="text-align:center;"><?php echo $r['city'];?></td>	
								<td style="text-align:center;"><?php echo $r['state'];?></td>	
								<td style="text-align:center;"><?php echo $r['zip'];?></td>	
								<td style="text-align:center;"><?php echo $r['email'];?></td>	
								<td style="text-align:center;"><?php echo $r['phone'];?></td>
								<td style="text-align: center;">
									<div class="btn-group">
										<a href="index.php?page=editmerchant&mID=<?php echo $r['id'];?>" class='btn btn-mini tip' title="Edit"><img src="img/icons/fugue/hammer-screwdriver.png" alt=""></a>
										<a href="index.php?page=merchants&mID=<?php echo $r['id'];?>&act=del" onclick="javascript: return confirm('Are You Sure Want to Delete?');" class='btn btn-mini tip' title="Remove"><img src="img/icons/fugue/cross.png" alt=""></a>
									</div>
								</td>
								<td style="text-align: center;">
								    <a href='index.php?page=offer&mID=<?php echo $r['id'];?>'?>
								        Offers
								    </a>&nbsp;|&nbsp;
								    <a href='index.php?page=beacon&mID=<?php echo $r['id'];?>'?>
								        Beacons
								    </a>
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
					<form action="index.php?page=addmerchant" class='validate form-horizontal' method="post" name="addmerchant" enctype="multipart/form-data">
						<div class="control-group">
							<label for="title" class="control-label">Business Name</label>
							<div class="controls">
								<input type="text" name="business_name" value="<?php echo $_REQUEST['business_name']?>" class='{required:true} span8'>
							</div>
						</div>
						<div class="control-group">
							<label for="avatar" class="control-label">Logo</label>
							<div class="controls">
								<input class="input-file uniform_on" id="logo" name="logo" type="file" class='{required:true}' >
							</div>
						</div>
						<div class="control-group">
							<label for="title" class="control-label">Address1</label>
							<div class="controls">
								<input type="text" name="address1" value="<?php echo $_REQUEST['address']?>" class='{required:true} span8'>
							</div>
						</div>
						<div class="control-group">
							<label for="title" class="control-label">Address2</label>
							<div class="controls">
								<input type="text" name="address2" value="<?php echo $_REQUEST['address']?>" class='{required:true} span8'>
							</div>
						</div>
						<div class="control-group">
							<label for="title" class="control-label">City</label>
							<div class="controls">
								<input type="text" name="city" value="<?php echo $_REQUEST['city']?>" class='{required:true} span8'>
							</div>
						</div>
						<div class="control-group">
							<label for="title" class="control-label">State</label>
							<div class="controls">
								<input type="text" name="state" value="<?php echo $_REQUEST['state']?>" class='{required:true} span8'>
							</div>
						</div>
						<div class="control-group">
							<label for="title" class="control-label">Zip</label>
							<div class="controls">
								<input type="text" name="zip" value="<?php echo $_REQUEST['zip']?>" class='{required:true} span8'>
							</div>
						</div>
						<div class="control-group">
							<label for="title" class="control-label">Email</label>
							<div class="controls">
								<input type="email" name="email" value="<?php echo $_REQUEST['email']?>" class='{required:true} span8'>
							</div>
						</div>
						<div class="control-group">
							<label for="title" class="control-label">Phone</label>
							<div class="controls">
								<input type="text" name="phone" value="<?php echo $_REQUEST['phone']?>" class='{required:true} span8'>
							</div>
						</div>
						<div class="form-actions">
							<input type="submit"  value="Save" name="AddMerchant" class='btn btn-primary'>
						</div>
					</form>
				</div>					
			</div>
									
		</div>
	</div>
</div>