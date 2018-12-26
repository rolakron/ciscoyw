<?php
//$town = $_GET["t"]; 
//$country = $_GET["c"]; 
$town = "Jakobstad";  //The town where you want to check the weather conditions.
$country = "fi"; // country where the town is.
    $BASE_URL = "http://query.yahooapis.com/v1/public/yql";
    $yql_query = 'select item.condition from weather.forecast where woeid in (select woeid from geo.places(1) where text="'. $town .',' . $country .'") and u="c"';
    $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";
    // Make call with cURL
    $session = curl_init($yql_query_url);
    curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
    $json = curl_exec($session);
    // Convert JSON to PHP object
     $phpObj =  json_decode($json);
//    var_dump($phpObj);
$condition = $phpObj->query->results->channel->item->condition->text;
$temp = $phpObj->query->results->channel->item->condition->temp;
$output = $temp ." \260" . "C " . $condition;
Header('Content-type: text/xml');
/*echo '<?xml version="1.0"?>\n';*/
?>
<CiscoIPPhoneText>
        <Title>Yahoo! Weather</Title>
        <Text> <?php echo $output; ?> </Text>
        <Prompt> <?php echo "Conditions for " . $town; ?> </Prompt>
</CiscoIPPhoneText>
