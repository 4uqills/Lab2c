<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Police Emergency Service System</title>
</head>

<body>
	<?php  // if post back
	if (isset($_POST["btnDispatched"]))
	{
		
		// (1) change db_config.php to 'db.php' and go to line 149 to do the same.
		require_once 'db.php';
		
		// create database connection
		$mysqli = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
		// check connection
		if ($mysql->connect_errno)
		{
			die("Failed to connect to MySQL: ".$mysqli->connect_errno);
		}
		// (5) several typos here, find anything that is Disptached and change it to Dispatched. after that go to line 25
		$patrolcarDispatched = $_POST["chkPatrolcar"]; // array of patrolcar being dispatched from post back
		// (5) Disptached and change it to Dispatched. after that go to line 31
		$numOfPatrolcarDispatched = count($patrolcarDispatched);
	
		
		// insert new incident
		$incidentStatus;
	// (5) Disptached and change it to Dispatched. after that go to line 61
		if ($numOfPatrolcarDispatched > 0) {
			$incidentStatus='2'; // incident status to be set as Dispatched 
		} else {
			$incidentStatus='1'; // incident status to be as pending
		}
		
		$sql = "INSERT INTO incident (callerName, phoneNumber, incidentTypeId, IncidentLocation, incidentDesc,
		incidentStatusId) VALUE (?, ?, ?, ?, ?, ?)";
		
	if (!($stmt = $mysqli->prepare($sql)))
	
	{
		die("Prepare failed: ".$mysqli->errno);
	}
	if (!$stmt->bind_param('ssssss', $_POST['callerName'],
						  $_POST['contactNo'],
						  $_POST['incidentType'],
						  $_POST['location'],
						  $_POST['incidentDesc'],
						   $incidentStatus))
	{
		die ("Binding parameters failed: ".$stmt->errno);
	}
	
	if (!$stmt->execute())
	{
		die("Insert incident table failed: ".$stmt->errno);
	}
		// retrieve incident_id for the newly inserted incident 
		//typo on line 62, $incicdentId and change it $incidentId after that go to line 65
		$incidentId=mysql_insert_id($mysqli);;
		
	// update patrolcar status table and add into dispatch table 
		// (5) Disptached and change it to Dispatched. after that go to line 73
		for($i=0; $i < $numOfPatrolcarDispatched; $i++)
		{
			// update patrol car status 
			$sql = "UPDATE patrolcar SET patrolcarStatusId = '1' WHERE patrolcarId = ?";
			if (!($stmt = $mysqli->prepare($sql))) {
				die("Prepare failed: ".$mysqli->errno);
			}
			// (5) Disptached and change it to Dispatched. after that go to line 83
			if (!$stmt->bind_param('s', $numOfPatrolcarDispatched[$i])){
				die("Binding parameters failed: ".$stmt->errno);
			}
			if (!$stmt->execute()) {
				die("Update patrolcar_status table failed: ".$stmt->errno);
			}
			
			// insert dispatch data
			
			// (5) typo , timeDisptached, change to timeDispatched . go to line 208
			$sql = "INSERT INTO dispatch (incidentId, patrolcarId, timeDispatched) VALUES (?, ?, NOW())";
			
			if (!($stmt = $mysqli->prepare($mysqli))) {
				die ("Prepare failed: ".$mysqli->errno);
			}
			
			if (!$stmt->bind_param('ss', $incicdentId,
								          $patrolcarDispatched[$i])) {
				die("Binding parameters failed". $stmt->errno);
			}
			if (!$stmt->execute()) {
				die("Insert dispatch table failed: ".$stmt->errno);
			}
			
				
		}
	
		$stmt->close();
	   
	    $mysqli->close();
	} ?>
	<!--display the incident information passed from logcall.php -->
	<form name="form1" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?> ">
	<table>
		<tr>
		 <td align="center" colspan="2" bgcolor="#FF10D3"><strong>Incident Detail</strong></td>
		</tr>
		<tr> 
		<td width="50%" bgcolor="#F3B5E4">Caller's Name:</td> 
		<td><?php echo $_POST['callerName'] ?>
			<input type="hidden" name="callerName" id="callerName"
				   value="<?php echo $_POST['callerName'] ?>"></td>
		<tr>
		<td width="50%"bgcolor="#F3B5E4">Contact No :</td> 
			
		<!-- (2) typo at line 117 $POST_ change to "$_POST" . After correcting it go to line 126 -->
		<td><?php echo $_POST['contactNo']?> <input
													type="hidden" name="contactNo" id="contactNo"
													value="<?php echo $_POST['contactNo']?>"></td>
		</tr>
		<tr>
		<td width="50%" bgcolor="#F3B5E4">Location :</td> 
			<!-- (3) replace the double quotes "location" with single quote 'location'. After correcting , go to line 145 -->
		<td><?php echo $_POST['location'] ?> <input
													type="hidden" name="location" id="location"
													value="<?php echo $_POST['location'] ?>"></td>
		</tr>
		<tr> 
		<td width="50%" bgcolor="#F3B5E4">Incident Type :</td> 
		<td><?php echo $_POST['incidentType'] ?> <input
														type="hidden" name="incidentType" id="incidentType"
														value="<?php echo $_POST['incidentType'] ?>"></td>
		</tr>
		<tr>
	    <td width="50%" bgcolor="#F3B5E4">Description :</td>
		<td><textarea name="incidentDesc" cols="45" 
					  rows="5" readonly id="incidentDesc"><?php echo $_POST['incidentDesc'] ?></textarea>
			<input name="incidentDesc" type="hidden"
				   id="incidentDesc" value="<?php echo $_POST['incidentDesc'] ?>"</td>
		</tr>
		</table>
		<!-- (4) missing php on on line 145, after correcting , go to line 23 -->
		<?php
	// connect to a database 
	
	// (1) change db_config.php to 'db.php' . After this , go to line 119
	require_once 'db.php'; 
			
	//create database connection
	$mysqli = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
	//check connection
			if ($mysqli->connect_errno) {
				die("Failed to connect to MySQL: ".$mysqli->connect_error);
			}
			
  // retrieve from patrolcar table those patrol cars that are 2:Patrol or 3:Free 
 $sql = "SELECT patrolcarId, statusDesc FROM patrolcar JOIN patrolcar_status ON 
 patrolcar.patrolcarStatusId=patrolcar_status.StatusId
 WHERE patrolcar.patrolcarStatusId='2' OR patrolcar.patrolcarStatusId='3'";
			
		/* Missing these:
		(7) Copy the code blow , highlight all the code from line 177 to 179 and paste the code. After that , go to logcall.php file and go to line 73
		 
		if (!($stmt = $mysqli->prepare($sql))) {
		die("Prepare failed: ".$mysqli->errno);
	}
		   
	if (!$stmt -> execute()) {
		die("Execute failed: ".$stmt->errno);
	} 
	
	*/	
			
if (!($stmt = $mysqli->prepare($sql))) {
		die("Prepare failed: ".$mysqli->errno);
	}
		   
	if (!$stmt -> execute()) {
		die("Execute failed: ".$stmt->errno);
	} 

if (!($resultset = $stmt->get_result())) {
	die("Getting result set failed: ".$stmt->error);
}
			$patrolcarArray;

while ($row = $resultset->fetch_assoc()) {
	$patrolcarArray[$row['patrolcarId']] =$row['statusDesc'];
}			
			
$stmt->close();
			
$resultset->close();
			
$mysqli->close();

?>

	  <!-- populate table with patrol car data -->
<br><br><table border="1" align="center">
		<tr>
		<td colspan="3">Dispatch patrolcar Panel</td>
		</tr>
		<?php
		//(6) missing $ on patrolcarArray , change to $patrolcarArray on line 209 . after that go to line 164.
		   foreach($patrolcarArray as $key=>$value){
			   ?>
		<tr>
		<td><input type="checkbox" name="chkPatrolcar[]"
				   value="<?php echo $key?>"></td>
		<td><?php echo $key ?></td>
		<td><?php echo $value ?></td>
		</tr>
		<?php } ?>
		<tr>
		<td><input type="reset" name="btnCancel" id="btnCancel" value="Reset"></td>
		<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btnDispatch" id="btnDospatch" valau="Dispatch"></td>
		</tr>
		</table>
	</form>
</body>
</html>
