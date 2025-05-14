<?php
if (isset($_POST['deposit'])) {
    include 'accessToken.php';

    // Collect form input
    $amount = $_POST['amount'];
    $accountnumber = $_POST['accountnumber'];
    $phone = $_POST['phone'];

    // Format phone number: Replace 07... with 2547...
    $phone = preg_replace('/^0/', '254', $phone);

    date_default_timezone_set('Africa/Nairobi');

    // Business Info
    $BusinessShortCode = '174379'; // Sandbox Shortcode
    $passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
    $Timestamp = date('YmdHis');
    $Password = base64_encode($BusinessShortCode . $passkey . $Timestamp);

    // Callback URL (must be publicly accessible or use ngrok during dev)
    $callbackurl = 'https://' . $_SERVER['HTTP_HOST'] . '/Online_Bookstore/callback.php';
    // $callbackurl = 'https://d8af-41-89-227-171.ngrok-free.app/Online_Bookstore/callback.php';

    //    $callbackurl = 'https://example.com/dummy-callback.php'; // Use a valid HTTPS URL

    // Set headers and body
    $stkpushheader = [
        'Content-Type:application/json',
        'Authorization:Bearer ' . $access_token
    ];

    $curl_post_data = [
        'BusinessShortCode' => $BusinessShortCode,
        'Password' => $Password,
        'Timestamp' => $Timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $amount,
        'PartyA' => $phone,
        'PartyB' => $BusinessShortCode,
        'PhoneNumber' => $phone,
        'CallBackURL' => $callbackurl,
        'AccountReference' => $accountnumber,
        'TransactionDesc' => 'STK Push Test'
    ];

    $data_string = json_encode($curl_post_data);

    // Make STK Push request
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
    curl_setopt($curl, CURLOPT_HTTPHEADER, $stkpushheader);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    $curl_response = curl_exec($curl);

    // Handle errors
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
        echo "<script>window.location.href='cart?error=" . urlencode("cURL Error: $error_msg") . "'</script>";
        exit;
    }

    $data = json_decode($curl_response);
    if ($data && isset($data->ResponseCode) && $data->ResponseCode == "0") {
        echo "<script>window.location.href='cart?sucess=Please Enter Your Mpesa Pin To Complete The Transaction'</script>";
    } else {
        $error = isset($data->errorMessage) ? $data->errorMessage : 'Please Try Again Later';
        echo "<script>window.location.href='cart?error=" . urlencode($error) . "'</script>";
    }
}
