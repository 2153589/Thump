<?php

require __DIR__ . '/vendor/autoload.php';

$client = new \Google_Client();
$client-> setApplicationName('Sample Sheet in PHP');
$client-> setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client-> setAccessType('offline');
$client-> setAuthConfig(__DIR__ . '/sampleCredentials.json');

$service = new Google_Service_Sheets($client);
$spreadsheetId = "1Emvfb4CS8Q7Bpbt8JCwqfgSk6CpkW4gd8mzKDZ6bURk";

$range = "sheet1!A1:B4";
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values =  $response->getValues();

$mask = "%s\n %s\n";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
    <?php
        foreach($values as $data){
    ?>
        <tr>
            <td><?php echo $data[0] ?></td>
            <td><?php echo $data[1] ?></td>
        </tr>

        <?php
        }
        ?>
    </table>
</body>
</html>