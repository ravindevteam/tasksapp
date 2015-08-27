<?php require_once("_inc/header.php"); ?>
						<!-- start: BREADCRUMB -->
						<div class="row">
							<div class="col-md-12">
								<ol class="breadcrumb">
									<li>
										<a href="#">
											Main page
										</a>
									</li>
									<li class="active">
										Task details
									</li>
								</ol>
							</div>
						</div>
						<!-- end: BREADCRUMB -->
						<!-- start: PAGE CONTENT -->
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-info">
									Here you can find the task details and discussion board for this task.
								</div>
								<!-- start: RESPONSIVE TABLE PANEL -->
								<div class="panel panel-white">
									<div class="panel-heading">
										<i class="fa fa-external-link-square"></i>
										Task Table
										<div class="panel-tools">										
											<div class="dropdown">
											<a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
												<i class="fa fa-cog"></i>
											</a>
											<ul class="dropdown-menu dropdown-light pull-right" role="menu">
												<li>
													<a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
												</li>
												<!-- <li>
													<a class="panel-refresh" href="#"> <i class="fa fa-refresh"></i> <span>Refresh</span> </a>
												</li> -->
												<li>
													<a class="panel-config" href="#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> <span>Configurations</span></a>
												</li>
												<li>
													<a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span></a>
												</li>										
											</ul>
											</div>
										</div>
									</div>
									<div class="panel-body">
										<div class="table-responsive">
											<table class="table table-bordered table-hover" id="sample-table-1">
												<thead>
													<tr>
														<th colspan="10" class="center">Task Title</th>
													</tr>
													<tr>
														<!-- <th class="center">
															<div class="checkbox-table">
																<label>
																	<input type="checkbox" class="flat-grey selectall">
																</label>
															</div>
														</th> -->
														<th>Assigned by</th>
														<th>Assigned to</th>
														<th>Start Date</th>
														<th>Due Date</th>
														<th>Done Date</th>
														<th>Task Location</th>
														<th>Repeated</th>
														<th>Desc.</th>
														<th>Attaches</th>
														<th>Status</th>
													</tr>
												</thead>
												<tbody>
													<!-- <tr>
														<td class="center">
															<div class="checkbox-table">
																<label>
																	<input type="checkbox" class="flat-grey foocheck">
																</label>
															</div>
														</td>
														<td>
															<a href="#">
																alpha.com
															</a>
														</td>
														<td>$45</td>
														<td>3,330</td>
														<td>Feb 13</td>
														<td><span class="label label-sm label-warning">Expiring</span></td>
													</tr> -->
													<tr>
														<td>Assigned by</td>
														<td>Assigned to</td>
														<td>Start Date</td>
														<td>Due Date</td>
														<td>Done Date</td>
														<td>Task Location</td>
														<td>Repeated</td>
														<td>Desc.</td>
														<td>Attaches</td>
														<td><span class="label label-sm label-warning">Expiring</span></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<!-- end: RESPONSIVE TABLE PANEL -->
							</div>
						</div>
						<!-- disucussion board -->
						<div class="col-md-12">
							<div class="panel panel-white">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Task discussion board
									<div class="panel-tools">										
										<div class="dropdown">
										<a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
											<i class="fa fa-cog"></i>
										</a>
										<ul class="dropdown-menu dropdown-light pull-right" role="menu">
											<li>
												<a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
											</li>
											<!-- <li>
												<a class="panel-refresh" href="#"> <i class="fa fa-refresh"></i> <span>Refresh</span> </a>
											</li> -->
											<li>
												<a class="panel-config" href="#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> <span>Configurations</span></a>
											</li>
											<li>
												<a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span></a>
											</li>										
										</ul>
										</div>
									</div>
								</div>
								<div class="panel-body messages">
									<ul class="messages-list col-md-12" id="ulComment">
										<li class="messages-item">
											<img class="messages-item-avatar" src="assets/images/avatar-1.jpg" alt="">
											<span class="messages-item-from">User Name</span>
								            <span class="messages-item-attachment">
												<i class="fa fa-paperclip attachs" data-attach=""></i>
											</span>
											<span class="messages-item-subject">User role</span>
											<span class="messages-item-preview">Description<input type="hidden" name="usr" class="usr" value="" /></span>
										</li>
									</ul>
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
			<?php require_once("_inc/footer.php"); ?>