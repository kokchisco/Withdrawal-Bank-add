<?php 
include "../../conn.php";
include "../../functions2.php";

header('Content-Type: application/json; charset=utf-8');
header('Strict-Transport-Security: max-age=31536000');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Access-Control-Allow-Credentials: true');
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
header('Access-Control-Allow-Origin: ' . $origin);
header('vary: Origin');

date_default_timezone_set("Africa/Lagos");
$shnunc = date("Y-m-d H:i:s");

$res = [
    'code' => 11,
    'msg' => 'Method not allowed',
    'msgCode' => 12,
    'serviceNowTime' => $shnunc,
];

$shonubody = file_get_contents("php://input");
$shonupost = json_decode($shonubody, true);

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    if (
        isset($shonupost['accountno']) &&
        isset($shonupost['bankid']) &&
        isset($shonupost['beneficiaryname']) &&
        isset($shonupost['codeType']) && // KEEPING THIS
        isset($shonupost['language']) &&
        isset($shonupost['mobileno']) &&
        isset($shonupost['random']) &&
        isset($shonupost['signature']) &&
        isset($shonupost['timestamp'])
    ) {
        $accountno = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['accountno']));
        $bankid = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['bankid']));
        $beneficiaryname = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['beneficiaryname']));
        $codeType = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['codeType']));
        $language = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['language']));
        $mobileno = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['mobileno']));
        $random = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['random']));
        $signature = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['signature']));

        $shonustr = '{"accountno":"'.$accountno.'","bankid":'.$bankid.',"beneficiaryname":"'.$beneficiaryname.'","codeType":'.$codeType.',"language":'.$language.',"mobileno":"'.$mobileno.'","random":"'.$random.'"}';
        $shonusign = strtoupper(md5($shonustr));

        if ($shonusign == $signature) {
            $bearer = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
            $author = $bearer[1];				
            $is_jwt_valid = is_jwt_valid($author);
            $data_auth = json_decode($is_jwt_valid, 1);

            if ($data_auth['status'] === 'Success') {
                $sesquery = "SELECT akshinak FROM shonu_subjects WHERE akshinak = '$author'";
                $sesresult = $conn->query($sesquery);

                if ($sesresult->num_rows == 1) {
                    $url = 'https://api.skywin786.in/api/webapi/GetBankList';
                    $payld = [
                        'language' => 0,
                        'random' => 'bbfdf080be3d4529aee34c148e0ad9f8',
                        'signature' => 'FD7919EAADBA695B1C123E396B9786A2',
                        'timestamp' => 1718516163,
                        'withdrawid' => 1
                    ];
                    $jsonData = json_encode($payld);
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($jsonData),
                        'Authorization: ' . $_SERVER['HTTP_AUTHORIZATION']
                    ]);
                    $response = curl_exec($ch);
                    curl_close($ch);

                    $rcvdt = json_decode($response, true);
                    $banklist = $rcvdt['data']['banklist'];
                    $bankName = '';
                    foreach ($banklist as $bank) {
                        if (isset($bank["bankID"]) && $bank["bankID"] == $bankid) {
                            $bankName = $bank['bankName'];
                            break;
                        }
                    }

                    $shonuid = $data_auth['payload']['id'];
                    $insert = mysqli_query($conn, "INSERT INTO `khate` (`byabaharkarta`, `khatesankhye`, `khatakrama`, `phalanubhavi`, `kodprakara`, `khatehesaru`, `duravani`, `sthiti`) VALUES ('$shonuid', '$accountno', '$bankid', '$beneficiaryname', '$codeType', '$bankName', '$mobileno', '1')");

                    $res['data'] = null;
                    $res['code'] = 0;
                    $res['msg'] = 'Succeed';
                    $res['msgCode'] = 0;
                    http_response_code(200);
                    echo json_encode($res);
                    exit;
                }
            }

            $res['code'] = 4;
            $res['msg'] = 'No operation permission';
            $res['msgCode'] = 2;
            http_response_code(401);
            echo json_encode($res);
            exit;

        } else {
            $res['code'] = 5;
            $res['msg'] = 'Wrong signature';
            $res['msgCode'] = 3;
            http_response_code(200);
            echo json_encode($res);
            exit;
        }
    } else {
        $res['code'] = 7;
        $res['msg'] = 'Param is Invalid';
        $res['msgCode'] = 6;
        http_response_code(200);
        echo json_encode($res);
        exit;
    }
} else {
    http_response_code(405);
    echo json_encode($res);
    exit;
}

mysqli_close($conn);
?>
