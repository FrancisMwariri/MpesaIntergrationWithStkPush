<?php
include 'config.php';

header("Content-Type: application/json");
$stkCallbackResponse = file_get_contents('php://input');
$logFile = "Mpesastkresponse.json";
$log = fopen($logFile, "a");
fwrite($log, $stkCallbackResponse);
fclose($log);
$data = json_decode($stkCallbackResponse);

$MerchantRequestID = $data->Body->stkCallback->MerchantRequestID;
$CheckoutRequestID = $data->Body->stkCallback->CheckoutRequestID;
$ResultCode = $data->Body->stkCallback->ResultCode;
$ResultDesc = $data->Body->stkCallback->ResultDesc;
$Amount = $data->Body->stkCallback->CallbackMetadata->Item[0]->Value;
$TransactionId = $data->Body->stkCallback->CallbackMetadata->Item[1]->Value;
$UserPhoneNumber = $data->Body->stkCallback->CallbackMetadata->Item[4]->Value;
//CHECK IF THE TRASACTION WAS SUCCESSFUL
if ($ResultCode == 0) {

    // code to know if the user has payed

    // $stmt = $con->prepare("INSERT INTO transaction (transactionAmount, transactionCode, phoneNumber) VALUES (?, ?, ?)");
    // $stmt->bind_param("dss", $Amount, $TransactionId, $UserPhoneNumber);
    // $stmt->execute();
    // the comented code is just to add the transaction in the database if and only of the transaction is complete
}
