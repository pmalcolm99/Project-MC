<?php

require 'DB.php';
require 'MojangAPI.php';
$db = new DBClass();

//Load all the transactions
//probably a shitty idea

$transactionArray = array();
$query = $db->query("SELECT * FROM transactions ORDER BY id DESC");
$results = $db->fetchAll($query);

?>

<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="shortcut icon" href="./assets/<?php echo Settings::$FAVICON_NAME;?>" type="image/png">
	<title>
		<?php echo Settings::$PAGE_TITLE;?> | All Transactions
	</title>
</head>

<body>

	<nav class="navbar navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand" href="index.php">
				<img src="./assets/<?php echo Settings::$NAVBAR_ICON_NAME;?>" width="30" height="30" style="margin-right:5px;" class="d-inline-block align-top" alt="">
				<?php echo Settings::$NAVBAR_TITLE;?>
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					<li class="nav-item active">
						<a class="nav-link" href="index.php">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="transactions.php">All Transactions</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

    <br><br>

	<div class="container">
		<div class="row">
			<?php
                if(sizeof($results) == 0) {
                    echo '
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                            <div class="card-header">No transactions have been found</div>
                        </div>
                    </div>
                    ';
                    return;
                }

                for ($i = 0; $i < sizeof($results); $i++) {    
                    echo '
                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <div class="card" style="width: 18rem; min-height:265px;">
                            <div class="card-body">
                                <h5 class="card-title">Transaction ID: '.$results[$i]['id'].'</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Sold for: $'.number_format($results[$i]['finalprice']).'</h6>
                                <p class="card-text"><img src="./assets/items/'.$results[$i]['item'].'.png"><strong> '.$results[$i]['displayname'].'</strong></p>
                                <p class="card-text"><strong>Seller: </strong>'.MojangAPI::getUsername($results[$i]['seller']).'</p>
                                <p class="card-text"><strong>Buyer: </strong>'.MojangAPI::getUsername($results[$i]['buyer']).'</p>
                                <a class="btn btn-outline-success" role="button" href="./transaction.php?id='.$results[$i]['id'].'">View Full Transaction</a>
                            </div>
                        </div>
                    </div>
                    ';
                }
            ?>
		</div>
	</div>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>