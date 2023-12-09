<?php 
require_once('../vendor/autoload.php');
$client = new GuzzleHttp\Client();

$amount = 1;
$merchant_key = 'b4e47e11-9e6b-40cc-861c-e55bf7f2ff42';

  $data = array(
      "merchantId" => "VANESHWARONLINE",
      "merchantTransactionId" => "MT785058106",
      "merchantUserId" => "MUID123",
      "amount" => $amount*100,
      "redirectUrl" => "https://enqi503h2ivdp.x.pipedream.net",
      "redirectMode" => "POST",
      "callbackUrl" => "https://enqi503h2ivdp.x.pipedream.net",
      "paymentInstrument" => array(
          "type" => "PAY_PAGE"
      )
  );
  // Convert the Payload to JSON and encode as Base64
  $payloadMain = base64_encode(json_encode($data));

  $payload = $payloadMain."/pg/v1/pay".$merchant_key;
  $Checksum = hash('sha256', $payload);
  $Checksum = $Checksum.'###1';

  $response = $client->request('POST', 'https://api.phonepe.com/apis/hermes/pg/v1/pay', [
    'body' => '{"request":"'. $payloadMain .'"}',
    'headers' => [
      'Content-Type' => 'application/json',
      'X-VERIFY' => "".$Checksum."",
      'accept' => 'application/json',
    ],
  ]);

  echo $response->getBody();

// require_once('../vendor/autoload.php');

// $client = new \GuzzleHttp\Client();

// $response = $client->request('POST', 'https://api.phonepe.com/apis/hermes/pg/v1/pay', [
//   'body' => '{"request":"eyJtZXJjaGFudElkIjoiVkFORVNIV0FST05MSU5FIiwibWVyY2hhbnRUcmFuc2FjdGlvbklkIjoiTVQ3ODUwNTgxMDQiLCJtZXJjaGFudFVzZXJJZCI6Ik1VSUQxMjMiLCJhbW91bnQiOjEwMDAwLCJyZWRpcmVjdFVybCI6InBheW1lbnRzdWNtZXJjaGFudF9LZXljZXNzLnBocCIsInJlZGlyZWN0TW9kZSI6IlBPU1QiLCJjYWxsYmFja1VybCI6InBheW1lbnRzdWNjZXNzLnBocCIsIm1vYmlsZU51bWJlciI6Ijk4MjU0NTQ1ODgiLCJwYXltZW50SW5zdHJ1bWVudCI6eyJ0eXBlIjoiUEFZX1BBR0UifX0="}',
//   'headers' => [
//     'Content-Type' => 'application/json',
//     'X-VERIFY' => '42db5cca094802e7ed102acb86862622fa8dbb9004c71e60021b8e2ca7d020cb###1',
//     'accept' => 'application/json',
//   ],
// ]);

// echo $response->getBody();

?>