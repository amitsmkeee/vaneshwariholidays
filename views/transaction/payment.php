<?php 
/** @var app\models\PaymentForm $payment */
use yii\helpers\Html;
use yii\web\View;

require_once('../vendor/autoload.php');

$client = new GuzzleHttp\Client();

$merchant_key = 'b4e47e11-9e6b-40cc-861c-e55bf7f2ff42';

  $data = array(
      "merchantId" => "VANESHWARONLINE",
      "merchantTransactionId" => $payment->merchantTransactionId,
      "merchantUserId" => $payment->merchantUserId,
      "amount" => $payment->amount*100,
      "redirectUrl" => "https://vaneshwariholidays.com/thank-you.html",
      "redirectMode" => "POST",
      "callbackUrl" => "https://vaneshwariholidays.com/thank-you.html",
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

  $responseObject = json_decode($response->getBody(), false);
  echo Html::label($responseObject->data->instrumentResponse->redirectInfo->url, 'urlname' ,['class' => 'copy-label', 'id' => 'copy-label']);
?>