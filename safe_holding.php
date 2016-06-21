<?php
include_once "sql.php";
include_once "config.php";

$journal = getFullWallet();

foreach ($journal as $row)
{
    print_r($row);
    $sql = "INSERT INTO `{$GLOBALS["TABLE"]}`(`date`,`refID`,`refTypeID`,`ownerName1`, `ownerID1`, `ownerName2`, `ownerID2`, `argName1`, `argID1`, `amount`, `balance`, `reason`, `owner1TypeID`, `owner2TypeID`) VALUES ('{$row["date"]}','{$row["refID"]}','{$row["refTypeID"]}','{$row["ownerName1"]}', '{$row["ownerID1"]}', '{$row["ownerName2"]}', '{$row["ownerID2"]}', '{$row["argName1"]}', '{$row["argID1"]}', '{$row["amount"]}', '{$row["balance"]}', '{$row["reason"]}', '{$row["owner1TypeID"]}', '{$row["owner2TypeID"]}')";
    echo $sql;
    var_dump(sql_write($sql));
}

function getFullWallet()
{
$journal = [];
$data = getWallet(999999999999999);
while ($data->row->count() > 0)
{

foreach ($data->row as $row){
array_push($journal,$row);
}

$data = getWallet($row["refID"]);
}
return $journal;
}

function getWallet($tranID){
$url = "https://api.eveonline.com/corp/WalletJournal.xml.aspx?keyID={$GLOBALS["API_KEYID"]}&vCode={$GLOBALS["API_vCode"]}&rowCount=2560&accountKey=1000&fromID=$tranID";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
	// Set so curl_exec returns the result instead of outputting it.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Does not verify peer
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// Get the response and close the channel.
    $headers = Array(
        "Reddit: Shegox",
        "IGN: Shegox Gabriel"
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");

    $response = curl_exec($ch);
    curl_close($ch);
    $response = simplexml_load_string($response);
    $response = $response->result->rowset;
  return $response;
}
