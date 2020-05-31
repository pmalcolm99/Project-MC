<?php

require 'DB.php';
require 'MojangAPI.php';
$db = new DBClass();

function array_most_common($input) {
  $counted = array_count_values($input);
  arsort($counted);
  return(key($counted));	
}

$finalPrices = array();
$averageAuctionType = array();
$finalPriceQuery = $db->query("SELECT * FROM transactions");
$finalPriceResult = $db->fetchAll($finalPriceQuery);
for ($i = 0; $i < sizeof($finalPriceResult); $i++) {  
    array_push($finalPrices, $finalPriceResult[$i]['finalprice']);
    array_push($averageAuctionType, $finalPriceResult[$i]['auctiontype']);
}

?>

<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="./css/style.css">
	<link rel="shortcut icon" href="./assets/<?php echo Settings::$FAVICON_NAME;?>" type="image/png">
	<title>
		<?php echo Settings::$PAGE_TITLE;?>
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

	<br>
	<br>

	<img width="70%;" class="img-fluid mx-auto d-block" src="./assets/<?php echo Settings::$SERVER_LOGO_NAME;?>" alt="">

	<br>
	<br>

	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
				<div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
					<div class="card-header">Total Transactions Made:
						<br>
						<?php 
                            $res = $db->query("SELECT * FROM transactions");
                            echo '<strong>'.sizeof($db->fetchAll($res)).'</strong>';
                        ?>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
				<div class="card text-white bg-success mb-3" style="max-width: 18rem;">
					<div class="card-header">Average Transaction Type:
						<?php echo '<strong>'.(count($averageAuctionType) == 0 ? "Not determined" : array_most_common($averageAuctionType)).'</strong>';?>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
				<div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
					<div class="card-header">Average Transaction Price: $
						<?php echo '<strong>'.(count($finalPrices) == 0 ? "Not determined" : number_format(round(array_sum($finalPrices)/count($finalPrices)))).'</strong>';?>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
				<div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
					<div class="card-header">Highest Transaction Price: $
						<?php echo '<strong>'.(count($finalPrices) == 0 ? "Not determined" : number_format(max($finalPrices))).'</strong>';?>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<h3 style="margin:0 auto;" class="text-center">Lastest Transactions</h3>
			</div>
		</div>
		<br>
		<div class="row">
			<?php
            $result = $db->query("SELECT * FROM transactions ORDER BY id DESC LIMIT ".Settings::$MAX_TRANSACTIONS_MAIN_PAGE);
            $data = $db->fetchAll($result);
            if(sizeof($data) == 0) {
                echo '
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                        <div class="card-header">No transactions have been found</div>
                    </div>
                </div>
                ';
                return;
            }

            for ($i = 0; $i < sizeof($data); $i++) {       
                //<img src="https://crafatar.com/avatars/'.$data[$i]['seller'].'?size=100" alt="">
                echo '
                <div style="margin-bottom:5px;" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            Transaction ID: '.$data[$i]['id'].'
                        </div>
                        <div class="card-body">
                            <img style="margin:5px;" src="./assets/items/'.$data[$i]['item'].'.png"> '.$data[$i]['displayname'].'
                            <hr>
                            <div class="container">
                                <div class="row">
                                    <div style="margin-bottom:5px;" class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                                    <img src="https://crafatar.com/avatars/'.$data[$i]['seller'].'?size=100" alt="">
                                                </div> 
                                                <div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
                                                    <p><strong>Seller: </strong>'.MojangAPI::getUsername($data[$i]['seller']).'</p>
                                                    <a class="text-dark btn btn-outline-success" role="button" href="./player.php?uuid='.$data[$i]['seller'].'">View User Transactions</a>  
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <div style="margin-bottom:5px;" class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                                    <img src="https://crafatar.com/avatars/'.$data[$i]['buyer'].'?size=100" alt="">
                                                </div> 
                                                <div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
                                                    <p><strong>Buyer: </strong>'.MojangAPI::getUsername($data[$i]['buyer']).'</p>
                                                    <a class="text-dark btn btn-outline-success" role="button" href="./player.php?uuid='.$data[$i]['buyer'].'">View User Transactions</a>    
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a class="btn btn-primary" role="button" href="./transaction.php?id='.$data[$i]['id'].'">View Full Transaction</a>
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
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>