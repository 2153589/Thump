<?php

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $lname = $_POST['last_name'];
            $fname = $_POST['first_name'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $mobile = $_POST['mobile'];

        require __DIR__ . '/vendor/autoload.php';

        $client = new Google_Client();
        $client-> setApplicationName("Sample Add To Cart Function");
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig(__DIR__ . '/credentials.json');
    
        $service = new Google_Service_Sheets($client);
        $spreadSheetID = "12dfdyLC73FWC8vHr0gdSqBWxxgX7sthfY46iCpEkrNw";

        $range = "orders";

        $values = [
            [$lname]
        ];

        $body = new Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);

        $params = [
            'valueInputOption' => "RAW"
        ];

        $insert = [
            "insertDataOption" => "INSERT_ROWS"
        ];

        $result = $service->spreadsheets_values->append($spreadSheetID,$range,$body,$params,$insert);
    }

?> 