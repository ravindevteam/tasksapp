<?php
require_once("_inc/header.php");
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
								My Tasks
							</li>
						</ol>
					</div>
				</div>
				<!-- end: BREADCRUMB -->
				<!-- start: PAGE CONTENT -->
				<div class="row">
					<div class="col-sm-12">
						<div class="tabbable">
							<ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
								<li class="active">
									<a data-toggle="tab" href="#panel_overview">
										Assigned to me
									</a>
								</li>
								<li>
									<a data-toggle="tab" href="#panel_edit_account">
										Assigned by me
									</a>
								</li>
								<li>
									<a data-toggle="tab" href="#panel_projects">
										Follower in them
									</a>
								</li>
							</ul>
							<div class="tab-content">
								<div id="panel_overview" class="tab-pane fade in active">
									<table class="table table-striped table-bordered table-hover tasks" id="projects">
										<thead>
											<tr>
												<th>Task Title</th>
												<th class="hidden-xs">Start Date</th>
												<th>End Date</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><a href="#">IT Help Desk</a></td>
												<td class="hidden-xs">Master Company</td>
												<td>11 november 2014</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div id="panel_edit_account" class="tab-pane fade">
									<table class="table table-striped table-bordered table-hover tasks" id="projects">
										<thead>
											<tr>
												<th>Task Title</th>
												<th class="hidden-xs">Start Date</th>
												<th>End Date</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><a href="#">IT Help Desk</a></td>
												<td class="hidden-xs">Master Company</td>
												<td>11 november 2014</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div id="panel_projects" class="tab-pane fade">
									<table class="table table-striped table-bordered table-hover tasks" id="projects">
										<thead>
											<tr>
												<th>Task Title</th>
												<th class="hidden-xs">Start Date</th>
												<th>End Date</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><a href="#">IT Help Desk</a></td>
												<td class="hidden-xs">Master Company</td>
												<td>11 november 2014</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
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