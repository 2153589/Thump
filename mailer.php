<?php
use PHPMailer\PHPMailer\PHPMailer;
    $fullname = $_POST['Fullname'];
    $email = $_POST['Email'];
    $telephone = $_POST['Telephone'];
    $cellphone = $_POST['Cellphone'];
    $country = $_POST['Country'];
    $model = $_POST['Model'];
    $address = $_POST['Address'];
    $issue = $_POST['Issue'];
    $purchase_date = $_POST['Date_of_Purchase'];
    $order_number = $_POST['Order_Number'];
    $requested_part = $_POST['Requested_Part'];
    $reference = $_POST['Ref_Number'];
    $msg = '';
    if (array_key_exists('supporting_file', $_FILES)) {
        require 'vendor/autoload.php';
        // Create a message
        $mail = new PHPMailer;
        $mail->setFrom('warranty@thumpstar.com', 'Thumpstar Motorcycles');
        if($country == 'USA') {
            $mail->addAddress('genuinethumpstar@gmail.com', 'Eden');
            $mail->addAddress('thecrkid@tboltusa.com', 'Vince');
        }
        $mail->addAddress('parts@thumpstar.com.au', 'Anson');
        $mail->addAddress('307697052@qq.com', 'Janice');
        $mail->addAddress('contact@thumpstar.com.au', 'Contact');
        $mail->addAddress('anthonette@thumpstar.com.au', 'Anthonette');
        $mail->addAddress('romiel@thumpstar.com.au', 'Romiel');
        $mail->Subject = $order_number . ' - Thumpstar Warranty';
        $mail->IsHTML(true);	
        $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;">Hi,</p>';
        $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;">A warranty claim has been submitted. Please look into this.</p>';
        $mail->Body .= '<br style="margin:0">';
        $mail->Body .= '<hr style="margin:0">';
        $mail->Body .= '<br style="margin:0">';
        $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>BIKE MODEL: </b>' . $model . '</p>';
        $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>PURCHASE DATE: </b>' . $purchase_date . '</p>';
        $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>REFERENCE: </b>' . $reference . '</p>';
        $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>ORDER NUMBER: </b>' . $order_number . '</p>';
        $mail->Body .= '<br style="margin:0">';
        $mail->Body .= '<hr style="margin:0">';
        $mail->Body .= '<br style="margin:0">';
        $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>BIKE ISSUE: </b>' . $issue . '</p>';
        $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>REQUESTED PART: </b>' . $requested_part . '</p>';
        $mail->Body .= '<br style="margin:0">';
        $mail->Body .= '<hr style="margin:0">';
        $mail->Body .= '<br style="margin:0">';
        $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>CUSTOMER NAME: </b>' . $fullname . '</p>';
        $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>EMAIL ADDRESS: </b>' . $email . '</p>';
        $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>TELEPHONE: </b>' . $telephone . '</p>';
        $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>CELLPHONE: </b>' . $cellphone . '</p>';
        $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>CUSTOMER ADDRESS: </b>' . $address . '</p>';
        $mail->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;"><b>COUNTRY: </b>' . $country . '</p>';
        $mail->Body .= '<br style="margin:0">';
        $mail->Body .= '<hr style="margin:0">';
        $mail->Body .= '<br style="margin:0">';
        
        for ($ct = 0; $ct < count($_FILES['supporting_file']['tmp_name']); $ct++) {
            $uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['supporting_file']['name'][$ct]));
            $filename = $_FILES['supporting_file']['name'][$ct];
            if (move_uploaded_file($_FILES['supporting_file']['tmp_name'][$ct], $uploadfile)) {
                $mail->addAttachment($uploadfile, $filename);
            } else {
                $msg .= 'Failed to move file to ' . $uploadfile;
            }
        }
        
        if (!$mail->send()) {
            $msg .= 'Mailer Error: '. $mail->ErrorInfo;
        } 
        else {
            header("Location: https://warranty.thumpstar.com.au/success.php");
        }
        
        $mail2 = new PHPMailer;
        $mail2->setFrom('noreply@thumpstar.com', 'Thumpstar Warranty');
        $mail2->addAddress($email);
        $mail2->Subject = 'Thumpstar Warranty';
        $mail2->IsHTML(true);
        $mail2->Body = 'Dear ' . $fullname . ',' ;
        $mail2->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;">This is to confirm that your warranty claim has been received.</p>';
        $mail2->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;">Our Team needs to check if your claim is valid and if you provide all necessary information.</p>';
        $mail2->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;">Your reference number is: <b>' . $reference. '</b></p>';
        $mail2->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;">If you have any question, you can send an email to support@thumpstar.com.au and provide your reference number.</p>';
        $mail2->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;">Regards,</p>';
        $mail2->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;">Thumpstar Motorcycles</p>';
        $mail2->Body .= '<br>';
        $mail2->Body .= '<hr>';
        $mail2->Body .= '<br>';
        $mail2->Body .= '<p style="letter-spacing: 1px;margin-bottom: 10px;">This is an auto generated response to your warranty claim. Please do not reply as it will not be received.</p>';
    
        if (!$mail2->send()) {
            echo 'Mailer Error: '. $mail2->ErrorInfo;
        }
    }
?>
