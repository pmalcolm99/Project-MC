<?php

require 'DB.php';
require 'MojangAPI.php';
$db = new DBClass();

if (!isset($_GET['id'])) {
    echo '
    <br><br>
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card text-white bg-danger mb-3">
            <div class="card-header">Please provide a transaction ID!</div>
        </div>
    </div>
    ';
    return;
}

$transactionQuery = $db->query("SELECT * FROM transactions WHERE id=".$_GET['id']);
$transactionData = $db->fetchAll($transactionQuery);

$buyer = $transactionData[0]['buyer'];
$seller = $transactionData[0]['seller'];
$auctionType = $transactionData[0]['auctiontype'];
$startPrice = $transactionData[0]['startprice'];
$buyNowPrice = $transactionData[0]['buynowprice'];
$increment = $transactionData[0]['increment'];
$item = $transactionData[0]['item'];
$displayName = $transactionData[0]['displayname'];
$lore = $transactionData[0]['lore'];
$enchantments = $transactionData[0]['enchantments'];
$auctionID = $transactionData[0]['auctionid'];
$timeSold = $transactionData[0]['timesold'];
$finalPrice = $transactionData[0]['finalprice'];

$loreArr = explode(";", $lore);
$enchArr = explode(";", $enchantments);
$enchArr = array_filter($enchArr);

?>

<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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

	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<h4>View Transaction ID:
					<?php echo $_GET['id']?>
				</h4>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
						<?php 
                            echo '
                                <a href="./player.php?uuid='.$seller.'"><img src="https://crafatar.com/avatars/'.$seller.'?size=100"></a>
                            ';
                        ?>
					</div>
					<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
						<br>
						<p>
							<strong>Seller: </strong>
							<?php echo MojangAPI::getUsername($seller)?>
						</p>
						<p>
							<strong>UUID: </strong>
							<?php echo $seller;?>
						</p>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
						<?php 
                            echo '
                                <a href="./player.php?uuid='.$buyer.'"><img src="https://crafatar.com/avatars/'.$buyer.'?size=100"></a>
                            ';
                        ?>
					</div>
					<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
						<br>
						<p>
							<strong>Buyer: </strong>
							<?php echo MojangAPI::getUsername($buyer)?>
						</p>
						<p>
							<strong>UUID: </strong>
							<?php echo $buyer;?>
						</p>
					</div>
				</div>
				<hr>
				<br>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-3 col-lg-4 col-xl-4">
						<div class="card text-white bg-success mb-3" style="max-width: 18rem;">
							<div class="card-header">Start Price: $
								<strong>
									<?php echo number_format($startPrice); ?>
								</strong>
							</div>
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
						<div class="card text-white bg-success mb-3" style="max-width: 18rem;">
							<div class="card-header">Buy Now Price: $
								<strong>
									<?php echo number_format($buyNowPrice); ?>
								</strong>
							</div>
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
						<div class="card text-white bg-success mb-3" style="max-width: 18rem;">
							<div class="card-header">Bid Increment: $
								<strong>
									<?php echo number_format($increment); ?>
								</strong>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<br>
				<h5>Auction Item</h5>
				<br>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<?php echo '<img style="margin:10px;" src="./assets/items/'.$item.'.png"> <strong>Display Name: </strong>'.$displayName?>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<br>
						<h6>Item Lore</h6>
						<ul class="list-group">
							<?php 
                            for ($i = 0; $i < count($loreArr); $i++) {
                                echo '
                                <li class="list-group-item">'.$loreArr[$i].'</li>
                                ';
                            }
                            ?>
						</ul>
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<br>
						<h6>Item Enchantments</h6>
						<ul class="list-group">
							<?php 
                            for ($i = 0; $i < count($enchArr); $i++) {
                                $ench = explode(",", $enchArr[$i]);
                                echo '
                                <li class="list-group-item">'.$ench[0].' '.$ench[1].'</li>
                                ';
                            }
                            ?>
						</ul>
					</div>
				</div>
                <br>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
						<div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
							<div class="card-header">Buy Type: <br>
								<strong>
									<?php echo $auctionType; ?>
								</strong>
							</div>
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
						<div class="card text-white bg-success mb-3" style="max-width: 18rem;">
							<div class="card-header">Final Price: <br>
								<strong>
									<?php echo '$'.number_format($finalPrice); ?>
								</strong>
							</div>
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
						<div class="card text-white bg-info mb-3" style="max-width: 18rem;">
							<div class="card-header">Time Sold: <br>
								<strong>
									<?php echo $timeSold; ?>
								</strong>
							</div>
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
						<div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
							<div class="card-header">Auction ID: <br>
								<strong>
									<?php echo $auctionID; ?>
								</strong>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>