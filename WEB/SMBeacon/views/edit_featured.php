<div class="box">
	<div class="box-head tabs">
		<h3><?php echo $Title;?></h3>
	</div>
	<div class="box-head tabs">
		<div class="tab-pane" id="condensed">
			<div class="box-content">
				<form action="index.php?page=editfeatured" class='validate form-horizontal' method="post" name="adduser" enctype="multipart/form-data">
					<div class="control-group">
						<label for="title" class="control-label">Package</label>
						<div class="controls">
							<input type="text" name="package" value="<?php echo $featured['package']?>" class='{required:true} span8'>
						</div>
					</div>			
					<?php 
					if (is_file($featured['small_icon'])){
					?>
					<div class="control-group">
						<div class="controls">
							<ul>
								<li class="span2" style="z-index: 0 !important;">
									<a href="<?php echo $featured['small_icon'] ?>" class="fancy"><img src="<?php echo $featured['small_icon'] ?>" width="200"/></a>
								</li>
							</ul>
						 </div>
					</div>
					<?php 
					}
					?>		
					<div class="control-group">
						<label for="small_icon" class="control-label">Small Icon</label>
						<div class="controls">
							<input class="input-file uniform_on" id="small_icon" name="small_icon" type="file" class='{required:true}' >
						</div>
					</div>		
					<?php 
					if (is_file($featured['large_icon'])){
					?>
					<div class="control-group">
						<div class="controls">
							<ul>
								<li class="span2" style="z-index: 0 !important;">
									<a href="<?php echo $featured['large_icon'] ?>" class="fancy"><img src="<?php echo $featured['large_icon'] ?>" width="200"/></a>
								</li>
							</ul>
						 </div>
					</div>
					<?php 
					}
					?>		
					<div class="control-group">
						<label for="large_icon" class="control-label">Large Icon</label>
						<div class="controls">
							<input class="input-file uniform_on" id="large_icon" name="large_icon" type="file" class='{required:true}' >
						</div>
					</div>						
								
					<div class="form-actions">
						<input type="hidden" name="fID" value="<?php echo $featured['id']?>">
						<input type="submit"  value="Save" name="UpdateFeatured" class='btn btn-primary'>
						<input type="button" class="btn btn-danger" onClick="location.href='<?php echo "index.php?page=featured"?>'" value="Cancel"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>