<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function midtransHandler(Request $request)
    {
        $data = $request->all();

        $signatureKey = $data["signature_key"];

        $orderId = $data["order_id"];
        $statusCode = $data["status_code"];
        $grossAmount = $data["gross_amount"];
        $serverKey = env("MIDTRANS_SERVER_KEY");

        $mySignatureKey = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        // get data from body
        $transactionStatus = $data["transaction_status"];
        $type = $data["payment_type"];
        $fraudStatus = $data["fraud_status"];

        // compare between signatureKey from midtrans and mySignatureKey
        if($signatureKey !== $mySignatureKey)
        {
            return response()->json([
                "status" => "error",
                "data" => "invaid signature key"
            ], 400);
        }

        return true;
    }
}
