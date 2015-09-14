<?php
require_once("_inc/header.php");
$hr_db = new hr();
?>
			<!-- start: BREADCRUMB -->
			<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb">
						<li>
							<a href="#">
								Dashboard
							</a>
						</li>
						<li class="active">
							Create Task
						</li>
					</ol>
				</div>
			</div>
			<!-- end: BREADCRUMB -->
			<!-- start: PAGE CONTENT -->
			<div class="row">
				<div class="col-md-12">
					<!-- start: FORM VALIDATION 2 PANEL -->
					<div class="panel panel-white">
						<div class="panel-heading">
							<h4 class="panel-title">Create <span class="text-bold">Task</span></h4>
							<div class="panel-tools">
								<div class="dropdown">
									<a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
										<i class="fa fa-cog"></i>
									</a>
									<ul class="dropdown-menu dropdown-light pull-right" role="menu">
										<li>
											<a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
										</li>
										<li>
											<a class="panel-refresh" href="#">
												<i class="fa fa-refresh"></i> <span>Refresh</span>
											</a>
										</li>
										<li>
											<a class="panel-config" href="#panel-config" data-toggle="modal">
												<i class="fa fa-wrench"></i> <span>Configurations</span>
											</a>
										</li>
										<li>
											<a class="panel-expand" href="#">
												<i class="fa fa-expand"></i> <span>Fullscreen</span>
											</a>
										</li>
									</ul>
								</div>
								<a class="btn btn-xs btn-link panel-close" href="#">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="panel-body">
							<h2><i class="fa fa-pencil-square"></i> NEW TASK</h2>
							<hr>
							<form action="#" role="form" id="form2">
								<div class="row">
									<div class="col-md-12">
										<div class="errorHandler alert alert-danger no-display">
											<i class="fa fa-times-sign"></i> You have some form errors. Please check below.
										</div>
										<div class="successHandler alert alert-success no-display">
											<i class="fa fa-ok"></i> Your form validation is successful!
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">
												JOB <span class="symbol required"></span>
											</label>
											<select class="form-control search-select dropdown" id="form-field-select-3" name="dropdown">
											<?php
											//get all jobs
											$q  = "SELECT * FROM `jobs` ORDER BY jobId";
											$sq = $hr_db->query($q);
											$sq = $hr_db->execute();
											$getJobs = $hr_db->fetchAll();
											if(!empty($getJobs)){
												echo "<option value=''>Select...</option>";
												foreach($getJobs as $jobs){
													echo "<option value='".$jobs['jobId']."'>".$jobs['job']."</option>";
												}
											}
											?>	
											</select>
										</div>
										<div class="form-group">
											<label class="control-label">
												EMPLOYEE <span class="symbol required"></span>
											</label>
											<select class="form-control search-select dropdown" name="dropdown">
												<option value="">Select...</option>
												<option value="EMPLOYEE 1">EMPLOYEE 1</option>
												<option value="EMPLOYEE 2">EMPLOYEE 2</option>
												<option value="EMPLOYEE 3">EMPLOYEE 5</option>
												<option value="EMPLOYEE 4">EMPLOYEE 4</option>
											</select>
										</div>
										<div class="form-group">
											<label class="control-label">
												BRANCH
											</label>
											<select class="form-control search-select" id="dropdown" name="dropdown">
											<?php
											//get all lcations
											$q  = "SELECT * FROM `locations` ORDER BY locId";
											$sq = $hr_db->query($q);
											$sq = $hr_db->execute();
											$getLocations = $hr_db->fetchAll();
											if(!empty($getLocations)){
												echo "<option value=''>Select...</option>";
												foreach($getLocations as $locations){
													echo "<option value='".$locations['locId']."'>".$locations['loc']."</option>";
												}
											}
											?>
											</select>
										</div>
										<div class="form-group">
											<label class="control-label">
												FOLLOWERS <span class="symbol required"></span>
											</label>
											<select multiple="multiple" id="form-field-select-4" class="form-control search-select">
												<option value="">Select...</option>
												<option value="follower 1">follower 1</option>
												<option value="follower 2">follower 2</option>
												<option value="follower 3">follower 5</option>
												<option value="follower 4">follower 4</option>
											</select>
										</div>
										<div class="form-group">
											<label class="control-label">
												TASK TITLE <span class="symbol required"></span>
											</label>
											<input type="text" placeholder="Insert task title" class="form-control" id="firstname2" name="firstname2">
										</div>
										<div class="form-group">
											<label class="control-label">
												FORMS 
											</label>
											<select class="form-control search-select" id="dropdown" name="dropdown">
												<option value="">Select...</option>
												<option value="Form 1">Form 1</option>
												<option value="Form 2">Form 2</option>
												<option value="Form 3">Form 5</option>
												<option value="Form 4">Form 4</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="radio">
											<label>
												<input type="radio" value="" name="optionsRadios2" class="grey required">
												Repeated task
											</label>
										</div>
										<div class="form-group">
											<div style="margin-left:20px;">
												<div class="checkbox">
													<label>
														<input type="checkbox" class="grey" value="" name="services" id="service1">
														Daily
													</label>
												</div>
												<div class="checkbox">
													<label>
														<input type="checkbox" class="grey" value="" name="services"  id="service2">
														Weekly
													</label>
												</div>
												<div class="checkbox">
													<label>
														<input type="checkbox" class="grey" value="" name="services"  id="service3">
														Monthly
													</label>
												</div>
												<div class="checkbox">
													<label>
														<input type="checkbox" class="grey" value="" name="services"  id="service4">
														Annually
													</label>
												</div>
											</div>
										</div>
										<div class="radio">
											<label>
												<input type="radio" value="" name="optionsRadios2" class="grey">
												Normal task
											</label>
										</div>
										<div style="margin-left:20px;">
											<p>
												Start Date 
											</p>
											<div class="input-group">
												<input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker">
												<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
											</div>
											<p>
												End Date 
											</p>
											<div class="input-group">
												<input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker">
												<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
											</div>
										</div><br />
										<div class="form-group">
											<div class="col-sm-12">
												<label>
													Upload File
												</label>
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-group">
														<div class="form-control uneditable-input">
															<i class="fa fa-file fileupload-exists"></i>
															<span class="fileupload-preview"></span>
														</div>
														<div class="input-group-btn">
															<div class="btn btn-light-grey btn-file">
																<span class="fileupload-new"><i class="fa fa-folder-open-o"></i> Select file</span>
																<span class="fileupload-exists"><i class="fa fa-folder-open-o"></i> Change</span>
																<input type="file" class="file-input">
															</div>
															<a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
																<i class="fa fa-times"></i> Remove
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label">
												Description <span class="symbol required"></span>
											</label>
											<div class="summernote"></div>
											<textarea class="form-control no-display" id="editor1" name="editor1" cols="10" rows="10"></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div>
											<span class="symbol required"></span>Required Fields
											<hr>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<button class="btn btn-yellow btn-block" type="submit">
											Register <i class="fa fa-arrow-circle-right"></i>
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<!-- end: FORM VALIDATION 2 PANEL -->
				</div>
			</div>
			<!-- end: PAGE CONTENT-->
		</div>
		<div class="subviews">
			<div class="subviews-container"></div>
		</div>
	</div>
	<!-- end: PAGE -->
</div>
<!-- end: MAIN CONTAINER -->
<?php
require_once("_inc/footer.php");
?>