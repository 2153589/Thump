<?php
    // $json=array();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $ref_num = $_POST['ref_no'];
        $vin = $_POST['vin'];
        $fullname = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $tel_num = $_POST['tel_num'];
        $cell_num = $_POST['cell_num'];
        $date = $_POST['date'];
        $country = $_POST['country'];
        $model = $_POST['model'];
        $ornum = $_POST['ornum'];
        // $receipt = $_POST['receipt'];

        require __DIR__ . '/vendor/autoload.php';

        $client = new Google_Client();
        $client-> setApplicationName("Sample Add To Cart Function");
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig(__DIR__ . '/credentials.json');
    
        $service = new Google_Service_Sheets($client);
        $spreadSheetID = "1x7igPtF6lNNsqN8eF4fzj7yXwhjuRSRBGan2YOfyuhs";

        $range = "DASHBOARD";

        $values = [
            [$ref_num,$vin,$fullname,$email,$tel_num,$cell_num,$address,$date,$country,$model,$ornum]
        ];

        $body = new Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);

        $params = [
            'valueInputOption' => "RAW"
        ];

        $insert = [
            'insertDataOption' => "ROWS"
        ];

        $result = $service->spreadsheets_values->append($spreadSheetID,$range,$body,$params,$insert);

        // if($result){
        //     $json['status'] = 100;
        //     $json['msg'] = "Waranty Request Sent";
        // }else{
        //     $json['status'] = 104;
        //     $json['msg'] = "Data are not sent";
        // }

        // if(!empty($receipt)){
        //     do upload syntax heres
        // }
        // if(!empty($_POST['fullname']) ){

        // }
    }
    // header('Content-type: application/json');
    // echo json_encode($json);
?>