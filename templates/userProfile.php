
<?php 
require_once '../src/data/dbconfig.php';

$imageUrl = null;
function imageList(){
    global $connection;
    $sqlStmt = "SELECT image_url FROM image_gallery";
    $queryId = mysqli_query($connection, $sqlStmt);
    
    // Count the number of rows returned
    $nbRows = mysqli_num_rows($queryId);

    // Loop through each image row and create HTML for each image
	$count = 0;
    while ($row = mysqli_fetch_array($queryId)) {
        // Get the image URL from the database
        $url = $row['image_url'];
		if($url == null){
			continue;
		}
        echo '<div class="work">';
		echo '<img src="'.$url.'"/>';
        echo '</div>';
    }

    // Close the database connection
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html>

	<head>

		<title>User Profile</title>

		<link rel="stylesheet" type="text/css" href="styles/userProfile.css">
		<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
        <!-- <script src="js/userProfiles.js" defer></script> -->
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta content="IE=edge" http-equiv="X-UA-Compatible">
		<meta name="x-apple-disable-message-reformatting">
		<meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86">

	</head>

	<body>

		<header class="side-header">

			<a href="#">
				<div class="logo">
					<img src="../public/images/Logo.png">
				</div>
			</a>

			<nav class="navbar-side">
				
				<ul>
					
					<li class="active"><a href="index.html">
						<div class="svg-space">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="355 95 43 43">
								<path d="M368,109 C366.896,109 366,108.104 366,107 C366,105.896 366.896,105 368,105 C369.104,105 370,105.896 370,107 C370,108.104 369.104,109 368,109 L368,109 Z M368,103 C365.791,103 364,104.791 364,107 C364,109.209 365.791,111 368,111 C370.209,111 372,109.209 372,107 C372,104.791 370.209,103 368,103 L368,103 Z M390,116.128 L384,110 L374.059,120.111 L370,116 L362,123.337 L362,103 C362,101.896 362.896,101 364,101 L388,101 C389.104,101 390,101.896 390,103 L390,116.128 L390,116.128 Z M390,127 C390,128.104 389.104,129 388,129 L382.832,129 L375.464,121.535 L384,112.999 L390,118.999 L390,127 L390,127 Z M364,129 C362.896,129 362,128.104 362,127 L362,126.061 L369.945,118.945 L380.001,129 L364,129 L364,129 Z M388,99 L364,99 C361.791,99 360,100.791 360,103 L360,127 C360,129.209 361.791,131 364,131 L388,131 C390.209,131 392,129.209 392,127 L392,103 C392,100.791 390.209,99 388,99 L388,99 Z" id="image-picture" sketch:type="MSShapeGroup">
								</path>
							</svg>
						</div>  Image Gallery</a>
					</li>
				
					<li><a href="../src/features/UX/asc_index.php">
						<div class="svg-space"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="-3 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve"><g><g><g><path d="M30.488 13.431l-14-12c-0.13-0.112-0.301-0.18-0.488-0.18s-0.358 0.068-0.489 0.181l0.001-0.001-14 12c-0.161 0.138-0.262 0.342-0.262 0.569v16c0 0.414 0.336 0.75 0.75 0.75h28c0.414-0 0.75-0.336 0.75-0.75v0-16c-0-0.227-0.101-0.431-0.261-0.569l-0.001-0.001zM11.75 29.25v-5.25c0-2.347 1.903-4.25 4.25-4.25s4.25 1.903 4.25 4.25v0 5.25zM29.25 29.25h-7.5v-5.25c0-3.176-2.574-5.75-5.75-5.75s-5.75 2.574-5.75 5.75v0 5.25h-7.5v-14.905l13.25-11.356 13.25 11.356z"></path></g></g></g></svg></div> Return</a>
					</li>

					<li class="bottom"><a href="../src/app/auth/logout.php">
						<div class="svg-space"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="-5 -1 30 30" enable-background="new 0 0 30 30" xml:space="preserve">  <g id="Logout">
							<g>
							  <path  d="M20.968,18.448a2.577,2.577,0,0,1-2.73,2.5c-2.153.012-4.306,0-6.459,0a.5.5,0,0,1,0-1c2.2,0,4.4.032,6.6,0,1.107-.016,1.589-.848,1.589-1.838V5.647A1.546,1.546,0,0,0,19,4.175a3.023,3.023,0,0,0-1.061-.095H11.779a.5.5,0,0,1,0-1c2.224,0,4.465-.085,6.687,0a2.567,2.567,0,0,1,2.5,2.67Z"/>
							  <path  d="M3.176,11.663a.455.455,0,0,0-.138.311c0,.015,0,.028-.006.043s0,.027.006.041a.457.457,0,0,0,.138.312l3.669,3.669a.5.5,0,0,0,.707-.707L4.737,12.516H15.479a.5.5,0,0,0,0-1H4.737L7.552,8.7a.5.5,0,0,0-.707-.707Z"/>
							</g>
						  </g></svg></div> Logout</a>
					</li>

				</ul>

			</nav>

		</header>

		<main class="main-wrapper">
			
			<header class="top-navbar">
				
				<div class="page-title">
					Image Gallery
				</div>
<!-- 
				<form class="searchbar">
					<input type="search" name="" placeholder="Search...">
					<a href="#" class="js-close-bar">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 54 67.5" version="1.1" x="0px" y="0px"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g fill="#ffffff" fill-rule="nonzero"><path d="M0.738461538,53.2615385 C1.10769231,53.6307692 1.56923077,53.8153846 2.07692308,53.8153846 C2.58461538,53.8153846 3.04615385,53.6307692 3.41538462,53.2615385 L27,29.6769231 L50.5846154,53.2615385 C50.9538462,53.6307692 51.4153846,53.8153846 51.9230769,53.8153846 C52.3846154,53.8153846 52.8923077,53.6307692 53.2615385,53.2615385 C54,52.5230769 54,51.3230769 53.2615385,50.5846154 L29.6769231,27 L53.2615385,3.41538462 C54,2.67692308 54,1.47692308 53.2615385,0.738461538 C52.5230769,-8.60422844e-16 51.3230769,-8.60422844e-16 50.5846154,0.738461538 L27,24.3230769 L3.41538462,0.738461538 C2.67692308,-2.77555756e-17 1.47692308,-2.77555756e-17 0.738461538,0.738461538 C-2.77555756e-17,1.47692308 -2.77555756e-17,2.67692308 0.738461538,3.41538462 L24.3230769,27 L0.738461538,50.5846154 C-2.77555756e-17,51.3230769 -2.77555756e-17,52.5230769 0.738461538,53.2615385 Z"/></g></g></svg>
					</a>
				</form> -->

			</header>

			<section class="works smooth-in">
				<?php imageList(); ?>
			</section>

			<footer>
				
				<nav class="footer-nav">
					<ul>
						<li>
							<a href="#">Made by: </a>
						</li>
						<li>
							<a href="#">Alex Santa Cruz</i></a>
						</li>
						<li>
							<a href="#">Mel Tran</a>
						</li>
                        <li>
							<a href="#">Tim Vu</i></a>
						</li>
					
					</ul>
				</nav>

			</footer>

		</main>
    
	</body>

</html>