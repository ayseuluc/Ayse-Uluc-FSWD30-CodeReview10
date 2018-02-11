<?php  
	ob_start();
	session_start();

 require_once 'dbconnect.php';

	// // if session is not set this will redirect to login page
	// if( !isset($_SESSION['users']) ) {
	// 	header("Location: index.php");
	// 	exit;
	// }

	$res=mysqli_query($conn, "SELECT * FROM users WHERE user_id=".$_SESSION['user']);

	$userRow=mysqli_fetch_array($res, MYSQLI_ASSOC);

	$sql = "SELECT * FROM media";
	// $sql = "SELECT name FROM author_interpret";
	// $sql = "SELECT name FROM publisher";
	// $sql = "SELECT type FROM type";
	$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
	<title>BIG Library</title>


<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>

<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body>

	<header>
		<h1 >Welcome to the BIG Library <?php echo $userRow['user_name']; ?>!</h1>
			</hr>
				<button class="btn">
					<a href="logout.php?logout">Sign Out</a>
				</button>
			</li>  	    
	  	</ul>
	</nav>
	</header>

        <div class="row container center">
			<div class="col col-sm-12 col-md-6 col-lg-3 col-md-offset-3" >
		
		<table class="table">
			<thead>
				<tr>
					
					<th scope="col">MediaID</th>
					<th scope="col">Image</th>
					<th scope="col">ISBM</th>
					<th scope="col">Title</th>
					<th scope="col">Author/Interpret</th>
					<th scope="col">description</th>
					<th scope="col" id="thA">publishing date</th>
					<th scope="col">publisher</th>
					<th scope="col">type</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					while ($row = mysqli_fetch_assoc($result)) {
						echo 
							" 
							<tr>
								
								
			 					<td scope='row'>".$row["media_id"]."</td>
			 					<td> <img src='".$row["fk_image_i"]."'></td>
								<td>".$row["ISBN_code"]."</td>
								<td>".$row["title"]."</td>
								<td>".$row["fk_author_id"]."</td>
								<td>".$row["short_description"]."</td>
								<td>".$row["publish_date"]."</td>
								<td>".$row["fk_publisher_id"]."</td>
								<td>".$row["fk_type_id"]."</td>
							</tr>
							";
					};
				?>
			</tbody>
		</table>
	</div>
</div>
</body>
</html>

<?php ob_end_flush(); ?>