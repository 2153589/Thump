<?php
   use PHPMailer\PHPMailer\PHPMailer;

    $json = array();

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $vin = $_POST['vin'];
        $ref_no = $_POST['ref_no'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $tel_no  = $_POST['tel_no'];
        $cell_no = $_POST['cell_no'];
        $model = $_POST['model'];
        $date = $_POST['date'];
        $country = $_POST['country'];
        $or_no = $_POST['or_no'];
        $parts = $_POST['parts'];
        $issue = $_POST['issue'];

        $reference = "";
        if($country == 'Australia') {
            $reference = 'AUWC-' . $ref_no;
        }
        else if($country == 'New Zealand') {
            $reference = 'NZWC-' . $ref_no;
        }
        else if($country == 'USA') {
            $reference = 'USWC-' . $ref_no;
        }
        else {
            $reference = 'TSWC-' . $ref_no;
        }

        
        require __DIR__ . '/vendor/autoload.php';
        $client = new Google_Client();
        $client-> setApplicationName("Warranty Validation");
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig(__DIR__ . '/credentials.json');
    
        $service = new Google_Service_Sheets($client);
        $spreadSheetID = "1x7igPtF6lNNsqN8eF4fzj7yXwhjuRSRBGan2YOfyuhs";

        $range = "DASHBOARD";

        $values = [
            [$reference,$vin,$name,$email,$tel_no,$cell_no,$address,$date,$country,$model,$or_no]
        ];

        $body = new Google_Service_Sheets_ValueRange([
            "values" => $values
        ]);

        $params = [
            'valueInputOption' => "RAW"
        ];

        $insert = [
            'insertDataOption' => "INSERT_ROW"
        ];

        $result =$service->spreadsheets_values->append($spreadSheetID,$range,$body,$params,$insert);

        if($result){
                //Recipients
                $mail = new PHPMailer();
                $mail->setFrom('warranty@thumpstar.com', 'Thumpstar Motorcycles'); //Sender of email
                $mail->addAddress('thumpstarapi@gmail.com', 'Mike');     // Add a recipient

                if(array_key_exists('supporting_file', $_FILES)){
                for ($i = 0; $i < count($_FILES['supporting_file']['tmp_name']); $i++) {
                    $uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['supporting_file']['name'][$i]));
                    $filename = $_FILES['supporting_file']['name'][$i];
                    if (move_uploaded_file($_FILES['supporting_file']['tmp_name'][$i], $uploadfile)) {
                        $mail->addAttachment($uploadfile, $filename);
                    } else {
                        $msg .= 'Failed to move file to ' . $uploadfile;
                    }
                    }
                }

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $or_no . ' - Thumpstar Warranty';
                $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;">Hi,</p>';
                $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;">A warranty claim has been submitted. Please look into this.</p>';
                $mail->Body .= '<br style="margin:0">';
                $mail->Body .= '<hr style="margin:0">';
                $mail->Body .= '<br style="margin:0">';
                $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>BIKE MODEL: </b>' . $model . '</p>';
                $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>PURCHASE DATE: </b>' . $date . '</p>';
                $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>REFERENCE: </b>' . $ref_no . '</p>';
                $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>ORDER NUMBER: </b>' . $or_no . '</p>';
                $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>VIN : </b>' . $vin . '</p>';
                $mail->Body .= '<br style="margin:0">';
                $mail->Body .= '<hr style="margin:0">';
                $mail->Body .= '<br style="margin:0">';
                $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>BIKE ISSUE: </b>' . $issue . '</p>';
                $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>REQUESTED PART: </b>' . $parts . '</p>';
                $mail->Body .= '<br style="margin:0">';
                $mail->Body .= '<hr style="margin:0">';
                $mail->Body .= '<br style="margin:0">';
                $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>CUSTOMER NAME: </b>' . $name . '</p>';
                $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>EMAIL ADDRESS: </b>' . $email . '</p>';
                $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>TELEPHONE: </b>' . $tel_no . '</p>';
                $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>CELLPHONE: </b>' . $cell_no . '</p>';
                $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>CUSTOMER ADDRESS: </b>' . $address . '</p>';
                $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>COUNTRY: </b>' . $country . '</p>';
                $mail->Body .= '<br style="margin:0">';
                $mail->Body .= '<hr style="margin:0">';
                $mail->Body .= '<br style="margin:0">';

        
        if($mail->send()){
            // header("Location:success.php");
            echo "Sent";
        }else{
            echo "failed to process";
        }

        }else{
            echo "An error occured";
        }

        // header('Content-type: application/json');
        // echo json_encode($json);
    }

?>
