<div class="box">
	<div class="box-head tabs">
		<h3><?php echo $Title;?></h3>
	</div>
	<div class="box-head tabs">
		<div class="tab-pane" id="condensed">
			<div class="box-content">
				<form action="index.php?page=editmerchant" class='validate form-horizontal' method="post" name="editmerchant" enctype="multipart/form-data">
					<div class="control-group">
						<label for="title" class="control-label">Business Name</label>
						<div class="controls">
							<input type="text" name="business_name" value="<?php echo $merchant['business_name']?>" class='{required:true} span8'>
						</div>
					</div>
					<?php
					if (is_file($merchant['logo'])) {
					?>
					<div class="control-group">
						<div class="controls">
							<ul>
								<li class="span2" style="z-index: 0 !important;">
									<a href="<?php echo $merchant['logo'] ?>" class="fancy"><img src="<?php echo $merchant['logo'] ?>" width="200"/></a>
								</li>
							</ul>
						 </div>
					</div>
					<?php
					}
					?>
					<div class="control-group">
						<label for="logo" class="control-label">Logo</label>
						<div class="controls">
							<input class="input-file uniform_on" id="logo" name="logo" type="file" class='{required:true}' >
						</div>
					</div>
					<div class="control-group">
						<label for="title" class="control-label">Address</label>
						<div class="controls">
							<input type="text" name="address" value="<?php echo $merchant['address']?>" class='{required:true} span8'>
						</div>
					</div>
					<div class="control-group">
						<label for="title" class="control-label">City</label>
						<div class="controls">
							<input type="text" name="city" value="<?php echo $merchant['city']?>" class='{required:true} span8'>
						</div>
					</div>
					<div class="control-group">
						<label for="title" class="control-label">State</label>
						<div class="controls">
							<input type="text" name="state" value="<?php echo $merchant['state']?>" class='{required:true} span8'>
						</div>
					</div>
					<div class="control-group">
						<label for="title" class="control-label">Zip</label>
						<div class="controls">
							<input type="text" name="zip" value="<?php echo $merchant['zip']?>" class='{required:true} span8'>
						</div>
					</div>
					<div class="control-group">
						<label for="title" class="control-label">Email</label>
						<div class="controls">
							<input type="email" name="email" value="<?php echo $merchant['email']?>" class='{required:true} span8'>
						</div>
					</div>
					<div class="control-group">
						<label for="title" class="control-label">Phone</label>
						<div class="controls">
							<input type="text" name="phone" value="<?php echo $merchant['phone']?>" class='{required:true} span8'>
						</div>
					</div>
					<div class="form-actions">
						<input type="hidden" name="mID" value="<?php echo $merchant['id']?>">
						<input type="submit"  value="Save" name="UpdateMerchant" class='btn btn-primary'>
						<input type="button" class="btn btn-danger" onClick="location.href='<?php echo "index.php?page=merchants"?>'" value="Cancel"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>