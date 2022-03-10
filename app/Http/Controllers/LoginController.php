<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function generateOtp(Request $request)
    {
        $rules = [
            "mobile_no" => "required",
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $resposne['message'] = "Validation Error";

            return response()->json([
                "status" => 200,
                "fields" => $validator->errors(),
                "message" => $resposne['message'],
            ], 200);
        } else {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://medibhai.com/api/cowinAPI/generate_OTP",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => [
                    'mobile_no' => $request->mobile_no,
                ],

            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $jsonResponse = json_decode($response);
            return $jsonResponse;
        }
    }

    public function checkOtp(Request $request)
    {

        $rules = [
            "txnId" => "required",
            "otp" => "required",
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $resposne['message'] = "Validation Error";

            return response()->json([
                "status" => 200,
                "fields" => $validator->errors(),
                "message" => $resposne['message'],
            ], 200);
        } else {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://medibhai.com/api/cowinAPI/confirm_OTP",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => [
                    'txnId' => $request->txnId,
                    'otp' => $request->otp,
                ],

            ));
            $response = curl_exec($curl);
            curl_close($curl);

            return $response;
        }
    }
}
