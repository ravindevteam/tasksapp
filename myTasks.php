<?php
require_once("_inc/header.php");
$db = new db();
$userId = $_SESSION['tasks_empId'];
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
									<?php
									//get tasks assigned to me
									$q  = "SELECT * FROM `tasks` WHERE assignee_id = :id";
									$sq = $db->query($q);
									$db->bind(":id", $userId);
									$sq = $db->execute();
									$getAssigneeTo = $db->fetchAll();
									if(!empty($getAssigneeTo)){
									?>
									<table class="table table-striped table-bordered table-hover tasks" id="assignedToMe">
										<thead>
											<tr>
												<th>Task Title</th>
												<th class="hidden-xs">Start Date</th>
												<th>End Date</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach($getAssigneeTo as $assignToMe){
											?>
											<tr>
												<td><a href="taskDetails.php? k=<?php echo $assignToMe['task_id'] ?>"><?php echo $assignToMe['title'] ?></a></td>
												<td class="hidden-xs"><?php echo $assignToMe['start_date'] ?></td>
												<td><?php echo $assignToMe['due_date'] ?></td>
											</tr>	
											<?php
											} 
											?>
											
										</tbody>
									</table>
									<?php
									}else{
									?>
									<div class="alert alert-success">
										<ul class="fa-ul">
											<li>
												<i class="fa fa-info-circle fa-lg fa-li"></i>
												There is no tasks assigned to you.
											</li>
										</ul>
									</div>
									<?php
									}
									?>
									
								</div>
								<div id="panel_edit_account" class="tab-pane fade">
									<?php
									//get tasks assigned to me
									$q  = "SELECT * FROM `tasks` WHERE creator_id = :id";
									$sq = $db->query($q);
									$db->bind(":id", $userId);
									$sq = $db->execute();
									$getAssigneeBy = $db->fetchAll();
									if(!empty($getAssigneeBy)){
									?>
									<table class="table table-striped table-bordered table-hover tasks" id="assignedByMe">
										<thead>
											<tr>
												<th>Task Title</th>
												<th class="hidden-xs">Start Date</th>
												<th>End Date</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach($getAssigneeBy as $assignByMe){
											?>
											<tr>
												<td><a href="taskDetails.php? k=<?php echo $assignByMe['task_id'] ?>"><?php echo $assignByMe['title'] ?></a></td>
												<td class="hidden-xs"><?php echo $assignByMe['start_date'] ?></td>
												<td><?php echo $assignByMe['due_date'] ?></td>
											</tr>	
											<?php
											} 
											?>
										</tbody>
									</table>
									<?php
									}else{
									?>
									<div class="alert alert-success">
										<ul class="fa-ul">
											<li>
												<i class="fa fa-info-circle fa-lg fa-li"></i>
												There is no tasks assigned by you.
											</li>
										</ul>
									</div>
									<?php
									}
									?>
								</div>
								<div id="panel_projects" class="tab-pane fade">
									<?php
									//get tasks assigned to me
									$q  = "SELECT tasks.task_id, tasks.title, tasks.start_date, tasks.due_date, tasks.repeat FROM `tasks`
										   JOIN `tasks_followers` on tasks_followers.task_id = tasks.task_id
											WHERE tasks_followers.follower_id = :fid";
									$sq = $db->query($q);
									$db->bind(":fid", $userId);
									$sq = $db->execute();
									$getFollowers = $db->fetchAll();
									if(!empty($getFollowers)){
									?>
									<table class="table table-striped table-bordered table-hover tasks" id="Follower">
										<thead>
											<tr>
												<th>Task Title</th>
												<th class="hidden-xs">Start Date</th>
												<th>End Date</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach($getFollowers as $follow){
											?>
											<tr>
												<td><a href="taskDetails.php? k=<?php echo $follow['task_id'] ?>"><?php echo $follow['title'] ?></a></td>
												<td class="hidden-xs"><?php echo $follow['start_date'] ?></td>
												<td><?php echo $follow['due_date'] ?></td>
											</tr>	
											<?php
											} 
											?>
										</tbody>
									</table>
									<?php
									}else{
									?>
									<div class="alert alert-success">
										<ul class="fa-ul">
											<li>
												<i class="fa fa-info-circle fa-lg fa-li"></i>
												There is no tasks assigned by you.
											</li>
										</ul>
									</div>
									<?php
									}
									?>
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