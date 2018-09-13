<?PHP
$id1 = "76561198087092729";//Steam Id HEre
$query = "http://localhost:591/marketwh.tk/Profiles/".$id1."/inventory/json/440/2/prices.json";//Prices .json of items want to sell
$json = @file_get_contents($query);
$data = json_decode($json, true);
$prices = $data["rgPrice"];

$id2 = "76561198076819824";
$query = "http://steamcommunity.com/profiles/".$id2."/inventory/json/440/2/";//Invetnroy fetch
$json = @file_get_contents($query);
$data = json_decode($json, true);
$items = $data["rgDescriptions"];

error_reporting(E_ALL); 
?>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="Style.css">
</head>
<body>

<div class="container">         
  <table class="table table-bordered">
	<thead>
		<tr>
			<th>Item Name</th>
			<th>Item Id</th>
			<th>Type</th>
			<th>Quality</th>
			<th>Tradeable</th>
			<th>Buy / Sell Price</th>
		</tr>
	</thead>
	<tbody>
	<?php

foreach($items as $item) {
	$image_url = "http://cdn.steamcommunity.com/economy/image/";

	if($item["icon_url"]) {
		$image_url = "http://cdn.steamcommunity.com/economy/image/".$item["icon_url"];
	}
	$classid = @$item['classid'];
	$defindex = @$item['app_data']['def_index'];
	$itemname = @$item['market_hash_name'];
	$flag_cannot_trade = @$item['tradable'];
	$quality = @$item['app_data']['quality'];
	$type = @$item['tags'][1]['name'];
		
	$appid = $item['appid'];
	if ($appid == 440){
		foreach($prices as $price){
			$pdefindex = @$price['app_data']['def_index'].$defindex;
			if($defindex === $pdefindex){
				$pquality = @$defindex.$quality;
				$pricebuy = @$pquality['price']['buy'];
				$pricesell = @$pquality['price']['sell'];
			}
			$quality = getQuality($quality);
			$flag_cannot_trade = getTradable($flag_cannot_trade);
			
?>
		<tr>
			<td aria-label="Job Title" class="<?PHP echo $quality ?>">
				<a href="<?PHP echo "http://steamcommunity.com/profiles/".$id2."/inventory/#".$appid."_2_".$classid.""?>"><?PHP echo $itemname?></a>
			</td>
			<td aria-label="Location" class="<?PHP echo $quality ?>"><?php echo $defindex?></td>
			<td class="<?PHP echo $quality ?>"><?PHP echo $type ?></td>
			<td class="<?PHP echo $quality ?>"><?PHP echo $quality ?></td>
			<td aria-label="Department" <?PHP if($flag_cannot_trade == "Not_Tradable"){ ?>style="background-color:#7F0000" style="color:white"<?PHP } else {?>class="<?PHP echo $quality ?>" <?PHP } ?>><?PHP echo $flag_cannot_trade ?></td>
			<td aria-label="Posted" class="<?PHP echo $quality ?>"><?PHP echo $pricebuy*9 ." / ".$pricesell*9 ?></td>
		</tr>
<?PHP
			}
		}
	}
	function getCraftable($craftable)
    {
		if($craftable == "( Not Usable in Crafting )")
			return "Not_Craftable";
		
		if($craftable != "( Not Usable in Crafting )")
			return "Craftable";
	}
	
	function getTradable($flag_cannot_trade)
   	{
		if ($flag_cannot_trade == 0)
            return "Not_Tradable";
		if ($flag_cannot_trade != 0)
            return "Tradable";
	}
    function getQuality($quality)
    {
        if ($quality == 1)
            return "Genuine";
        if ($quality == 3)
            return "Vintage";
        if ($quality == 5)
            return "Unusual";
        if ($quality == 6)
            return "Unique";
        if ($quality == 7)
            return "Community";
        if ($quality == 9)
            return "Self-Made";
        if ($quality == 11)
            return "Strange";
        if ($quality == 13)
            return "Haunted";
		if ($quality == 13)
			return "Normal";		
		if ($quality == 13)
			return "Collectors";
		if ($quality == 13)
			return "Decorated";
		if ($quality == 13)
			return "Valve";
    }
?>
	</tbody>
</table>
</div>

</body>
</html>