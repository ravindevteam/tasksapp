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
							<form action="<? $_SERVER['PHP_SELF']; ?>" role="form" id="form2">
								<div class="row">
									<div class="col-md-12">
										<div class="errorHandler alert alert-danger no-display">
											<i class="fa fa-times-sign"></i> You have some form errors. Please check below.
										</div>
										<div class="successHandler alert alert-success no-display">
											<i class="fa fa-ok"></i> Task Creation is successful!
										</div>
									</div>
									<div class="col-md-6">
										<input type="hidden" value="1343" id="creator_id">
										<div class="form-group">
											<label class="control-label">
												JOB <span class="symbol required"></span>
											</label>
											<select class="form-control search-select selJob" id="selJob" name="selJob">
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
											<select class="form-control search-select selEmps" id="selEmps" name="selEmps">
												<option value="">Select...</option>
											</select>
										</div>
										<div class="form-group">
											<label class="control-label">
												BRANCH
											</label>
											<select class="form-control search-select selBranchs" id="selBranchs" name="selBranchs">
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
												FOLLOWERS
											</label>
											<select multiple="multiple" id="form-field-select-4" class="form-control search-select selFollowers" placeholder="select followers">
											<?php
											//get all employees
											$q  = "SELECT * FROM `employees` ORDER BY emp_id";
											$sq = $hr_db->query($q);
											$sq = $hr_db->execute();
											$getEmployees = $hr_db->fetchAll();
											if(!empty($getEmployees)){
												foreach($getEmployees as $employees){
													echo "<option value='".$employees['emp_id']."'>".$employees['emp_name']."</option>";
												}
											}
											?>
											</select>
										</div>
										<div class="form-group">
											<label class="control-label">
												TASK TITLE <span class="symbol required"></span>
											</label>
											<input type="text" placeholder="Insert task title" class="form-control" id="taskTitle" name="taskTitle">
										</div>
										<div class="form-group">
											<label class="control-label">
												FORMS 
											</label>
											<select class="form-control search-select forms" id="forms" name="forms">
												<option value="">Select...</option>
												<option value="1">Form 1</option>
												<option value="2">Form 2</option>
												<option value="3">Form 3</option>
												<option value="4">Form 4</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">
												Type <span class="symbol required"></span>
											</label>
											<div>
												<label class="radio-inline">
													<input type="radio" class="grey type-callback" value="1" name="taskType" id="repeatedType">
													Repeated task
												</label>
												<label class="radio-inline">
													<input type="radio" class="grey type-callback" value="2" name="taskType"  id="normalType">
													Normal task
												</label>
											</div>
										</div>
										<div id="tasksType">
											<div class="form-group">
												<div class="repeated" style="display:none">
													<div class="checkbox">
														<label>
															<input type="checkbox" class="grey yperiod" value="1" name="services" id="service1">
															Daily
														</label>
													</div>
													<div class="checkbox">
														<label>
															<input type="checkbox" class="grey yperiod" value="2" name="services"  id="service2">
															Weekly
														</label>
													</div>
													<div class="checkbox">
														<label>
															<input type="checkbox" class="grey yperiod" value="3" name="services"  id="service3">
															Monthly
														</label>
													</div>
													<div class="checkbox">
														<label>
															<input type="checkbox" class="grey yperiod" value="4" name="services"  id="service4">
															Annually
														</label>
													</div>
												</div>
											</div>
											<div class="normal" style="display:none">
												<div class="form-group">
													<label class="control-label">
														Date Range <span class="symbol required"></span>
													</label>
													<div class="input-group">
														<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
														<input type="text" class="form-control date-range" id="taskDate" name="taskDate">
													</div>
												</div>
											</div>
										</div><br />
										<div class="form-group">
											<div class="col-sm-12">
												<button class="btn btn-dark-grey yUpload" type="button"> Upload files </button>
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
											<div class="noteWrap">
												<div class="form-group">
													<textarea class="summernote" placeholder="Write task description here..."></textarea>
												</div>
											</div>
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
		<div class="no-display" id="yfileUpload">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-white">
						<div class="panel-body">
							<!-- <form method="post" id="yTaskAttach" enctype="multipart/form-data"> -->
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<input type="hidden" value="" name=""> 
									<span class="btn btn-file btn-light-grey">
										<i class="fa fa-folder-open-o"></i>
										<span class="fileupload-new">Select file</span>
										<span class="fileupload-exists">Upload anthor</span>
										<input type="file" id="yfile" name="yfile" />
									</span>
									<span class="fileupload-preview"></span>
									<a class="close fileupload-exists float-none" href="#" data-dismiss="fileupload"> × </a>
								</div>
								<input type="hidden" value="e" name="attach_id" class="attach_id">
							<!-- </form> -->
							<div id="yAttachResults">
							</div>
						</div>
					</div>
				</div>
			</div>
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