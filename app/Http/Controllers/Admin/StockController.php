<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
     public function getLiveData()
    {
        $apiKey = 'BZXOJ3TTYJ60AJMT';  // Replace with your Alpha Vantage API key
        $symbol = 'AAPL';  // Example stock symbol (Apple)
        $function = 'TIME_SERIES_INTRADAY';
        $interval = '5min';

        // Construct the Alpha Vantage API URL
        $url = "https://www.alphavantage.co/query?function=$function&symbol=$symbol&interval=$interval&apikey=$apiKey";

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // Execute cURL request and fetch the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if(curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        }

        // Close the cURL session
        curl_close($ch);

        // Decode the JSON response
        $data = json_decode($response, true);

        // Check if the data is available
        if (isset($data['Time Series (5min)'])) {
            // You can modify the response here as per your needs
            return response()->json([
                'status' => 'success',
                'data' => $data['Time Series (5min)'],
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not fetch stock data or invalid symbol.',
            ]);
        }
    }
}
