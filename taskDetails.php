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
						<?php
							if(empty($_GET['k'])){
								echo '<script>window.location.href="home.php";</script>';
							}

						?>
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
												<!-- <li>
													<a class="panel-config" href="#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> <span>Configurations</span></a>
												</li> -->
												<li>
													<a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span></a>
												</li>										
											</ul>
											</div>
										</div>
									</div>
									<div class="panel-body">
										<div class="table-responsive">
											<?php
												$db->query("SELECT * FROM tasks WHERE task_id = :tsk");
												$db->bind(":tsk",base64_decode($_GET['k']));
												$getTask = $db->fetch();
												if(!empty($getTask)){
											?>
											<input type="hidden" id="mTaskId" value="<?php echo $getTask['task_id']; ?>"  />
											<table class="table table-bordered table-hover" id="sample-table-1">
												<thead>
													<tr>
														<th colspan="10" class="center"><?php echo $getTask['title']; ?></th>
													</tr>
													<tr>
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
													<tr>
														<?php
															$creator = $getTask['creator_id'];
															$assignee = $getTask['assignee_id'];
															$hr->query("SELECT name FROM users WHERE emp_id = :emp1
																		UNION 
																		SELECT name FROM users WHERE emp_id = :emp2");
															$hr->bind(":emp1",$getTask['creator_id']);
															$hr->bind(":emp2",$getTask['assignee_id']);
															$getusers = $hr->fetchAll();
															if(!empty($getusers)){
																foreach($getusers AS $user){
																	echo '<td>'.$user['name'].'</td>';
																}
															}
														?>
														<input type="hidden" value="<?php echo $creator; ?>" id="creator" />
														<input type="hidden" value="<?php echo $assignee; ?>" id="assignee" />
														<td><?php echo $getTask['start_date']; ?></td>
														<td><?php echo $getTask['due_date']; ?></td>
														<td><?php echo $getTask['done_date']; ?></td>
														<td>
															<?php
																$hr->query("SELECT loc FROM locations WHERE locId = :lid");
																$hr->bind(":lid",$getTask['loc_id']);
																$getLoc = $hr->fetch();
																if(!empty($getLoc)){
																	echo $getLoc['loc'];
																}
															?>
														</td>
														<td>
															<?php
																if($getTask['repeat'] == 1){
																	echo 'Daily';
																}elseif($getTask['repeat'] == 2){
																	echo 'Weekly';
																}elseif($getTask['repeat'] == 3){
																	echo 'Monthly';
																}elseif($getTask['repeat'] == 4){
																	echo 'Yearly';
																}
															?>
														</td>
														<td><?php echo $getTask['desc']; ?></td>
														<td class="center">
															<?php 
																if($getTask['attach_group_id'] != 0){
																	echo '<span class="messages-item-attachment attachLabel">
																				<i class="fa fa-paperclip mAttachs" data-attach="'.$getTask['attach_group_id'].'" style="font-size:25px;cursor:pointer"></i>
																			</span>';
																}
															?>
														</td>
														<td>
															<?php
																if($getTask['status'] == 1){
																	echo '<span class="label label-sm label-warning">Pending</span>';
																}elseif($getTask['status'] == 2){
																	echo '<span class="label label-sm label-success">Done</span>';
																}elseif($getTask['status'] == 3){
																	echo '<span class="label label-sm label-danger">Canceled</span>';
																}
															?>
														</td>
													</tr>
												</tbody>
											</table>
											<?php
													$taskRate = $getTask['rating'];
												}else{
													echo "This task isn't exist";
												}
											?>
										</div>
									</div>
								</div>
								<!-- end: RESPONSIVE TABLE PANEL -->
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-info">
									Rate the task
								</div>
								<div class="panel panel-white">
									<div class="panel-body">
										<?php
											if($creator == $_SESSION['tasks_empId']){
												$attr = "";
											}else{
												$attr = "disabled";
											}
										?>
										<div class="col-md-11">
											<input type="number" <?php echo $attr; ?> class="rating taskRating" value="<?php echo $taskRate; ?>"  />
											<input type="hidden" value="<?php echo $taskRate ?>" class="mTmpRate" />
										</div>
										<div class="col-md-1">
											<?php
												if($assignee == $_SESSION['tasks_empId']){
											?>
													<input type="button" name="dispute" id="dispute" value="Dispute" class="btn btn-red" />
											<?php
												}
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- disucussion board -->
						<div class="row">
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
												<!-- <li>
													<a class="panel-config" href="#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> <span>Disput</span></a>
												</li> -->
												<li>
													<a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span></a>
												</li>										
											</ul>
											</div>
										</div>
									</div>
									<div class="panel-body messages">
										<input type="hidden" value="<?php echo $creator; ?>" class="commentor" />
										<input type="hidden" value="<?php echo $assignee; ?>" class="commentor" />
										<?php
										$db->query("SELECT follower_id FROM tasks_followers WHERE task_id = :tsk");
										$db->bind(":tsk",base64_decode($_GET['k']));
										$getFollowers = $db->fetchAll();
										if(!empty($getFollowers)){
											foreach($getFollowers AS $follower){
												if($follower['follower_id'] != $creator && $follower['follower_id'] != $assignee){
													echo '<input type="hidden" value="'.$follower['follower_id'].'" class="commentor" />';
												}
											}
										}
										?>
										<ul class="messages-list col-md-12" id="ulComment">
											<?php
												$db->query("SELECT * FROM comments WHERE task_id = :tsk");
												$db->bind(":tsk",base64_decode($_GET['k']));
												$comments = $db->fetchAll();
												if(!empty($comments)){
													foreach($comments AS $row){
														$hr->query("SELECT users.*, jobs.job FROM users
																	INNER JOIN employees ON users.emp_id = employees.emp_id
																	INNER JOIN jobs ON employees.job_id = jobs.jobId
																	WHERE users.emp_id = :emp");
														$hr->bind(":emp",$row['user_id']);
														$getUser = $hr->fetch();
														if(!empty($getUser)){
															$userName = $getUser['name'];
															$userImg  = "http://iravin.com/devteam/attendance/assets/profileImages/".$getUser['img'];
															$userJob  = $getUser['job'];
														}else{
															$userName = "User Name";
															$userImg  = "http://iravin.com/devteam/attendance/assets/profileImages/avatar-1-xl.jpg";
															$userJob  = "User role";
														}
											?>
														<li class="messages-item">
															<img class="messages-item-avatar" src="<?php echo $userImg; ?>" alt="">
															<span class="messages-item-from"><?php echo $userName; ?></span>
															<?php 
																if($row['attach_group_id'] != 0){
															?>
												            <span class="messages-item-attachment">
																<i class="fa fa-paperclip mAttachs" data-attach="<?php echo $row['attach_group_id']; ?>"></i>
															</span>
															<?php
																}
															?>
															<span class="messages-item-subject"><?php echo $userJob; ?></span>
															<span class="messages-item-preview"><?php echo $row['comment_desc'] ?><input type="hidden" name="commentor" class="commentor" value="<?php echo $row['user_id']; ?>" /></span>
														</li>
											<?php
													}
												}else{
											?>
													<li class="messages-item">There is no comments yet !!!</li>
											<?php 
												}
											?>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
									<div class="panel panel-white">
										<div class="panel-body messages">
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="commentForm">
													<tbody>
														<tr>
															<td class="center" style="width:90%">
												                <textarea name="commentarea" id="commentarea" style="width: 80%; height: 75px;border: 1px solid; #000"></textarea>
												                <input type="hidden" name="attach_id" id="attach_id" value="e" />
												                <input type="hidden" name="user" id="usr" value="<?php echo $_SESSION['tasks_empId']; ?>" />
												            </td>
												            <td class="center">
												            	<div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="">
																	<span class="btn btn-file btn-light-grey"><i class="fa fa-folder-open-o"></i> <span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span>
																		<input type="file" name="file" class="mTaskUploadFile">
																	</span>
																	<span class="fileupload-preview"></span>
																	<a href="#" class="close fileupload-exists float-none" data-dismiss="fileupload">×</a>
																</div>
												            </td>
														</tr>
														<tr>
											              <td class="center" colspan="2"><input type="button" name="addcom" id="addcom" value="add your comment" class="btn btn-green" /></td>
											            </tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- end: PAGE CONTENT-->
					</div>
					<div class="no-display" id="mShowAttachs">
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-white">
									<div class="panel-body">
										<div class="col-sm-12" id="mResDiv"></div>
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
			<?php require_once("_inc/footer.php"); ?>