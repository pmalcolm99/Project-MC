<?php 

include 'DB.php';

$db = new DBClass();

$createTableString = "
CREATE TABLE IF NOT EXISTS `transactions` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `buyer` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
 `seller` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
 `auctiontype` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
 `startprice` int(11) NOT NULL,
 `buynowprice` int(11) NOT NULL,
 `increment` int(11) NOT NULL,
 `item` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
 `displayname` text COLLATE utf8_unicode_ci NOT NULL,
 `lore` text COLLATE utf8_unicode_ci NOT NULL,
 `enchantments` text COLLATE utf8_unicode_ci NOT NULL,
 `auctionid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
 `timesold` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
 `finalprice` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

$newQuery = "CREATE TABLE IF NOT EXISTS `transactions` ( `id` INT NOT NULL AUTO_INCREMENT , `transaction_type` TEXT NOT NULL , `seller` TEXT NOT NULL , `buyer` TEXT NOT NULL , `start_price` TEXT NOT NULL , `bid_increment` TEXT NOT NULL , `buy_now_price` TEXT NOT NULL , `final_price` TEXT NOT NULL , `time_left` INT NOT NULL , `auction_id` TEXT NOT NULL , `time_completed` TEXT NOT NULL , `item_type` TEXT NOT NULL , `item_name` TEXT NOT NULL , `item_lore` TEXT NOT NULL , `item_enchants` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";
                   

if ($db->query($newQuery)) {
    echo "Successfully created the transactions table, the website should be functional along with data upload from the MC server.";
}