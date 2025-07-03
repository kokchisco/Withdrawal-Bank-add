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
	
	date_default_timezone_set("Asia/Kolkata");
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
		if (isset($shonupost['language']) && isset($shonupost['random']) && isset($shonupost['signature']) && isset($shonupost['timestamp']) && isset($shonupost['withdrawid'])) {
			$language = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['language']));
			$random = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['random']));
			$signature = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['signature']));
			$withdrawid = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['withdrawid']));
			$shonustr = '{"language":'.$language.',"random":"'.$random.'","withdrawid":'.$withdrawid.'}';
			$shonusign = strtoupper(md5($shonustr));
			if($shonusign == $signature){
				$bearer = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
				$author = $bearer[1];				
				$is_jwt_valid = is_jwt_valid($author);
				$data_auth = json_decode($is_jwt_valid, 1);
				if($data_auth['status'] === 'Success') {
					$sesquery = "SELECT akshinak
					  FROM shonu_subjects
					  WHERE akshinak = '$author'";
					$sesresult=$conn->query($sesquery);
					$sesnum = mysqli_num_rows($sesresult);
					if($sesnum == 1){
						http_response_code(200);
						if($withdrawid == 1){
							echo '
								{
								  "data": {
									"banklist": [
									  {
										"bankID": 1,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Access Bank Plc",
										"reserved": "1"
									  },
									  {
										"bankID": 2,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Zenith Bank Plc",
										"reserved": "1"
									  },
									  {
										"bankID": 3,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Guaranty Trust Bank (GTBank)",
										"reserved": "1"
									  },
									  {
										"bankID": 4,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "First Bank of Nigeria Limited",
										"reserved": "1"
									  },
									  {
										"bankID": 5,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "United Bank for Africa (UBA)",
										"reserved": "1"
									  },
									  {
										"bankID": 6,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Ecobank Nigeria",
										"reserved": "1"
									  },
									  {
										"bankID": 7,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Union Bank of Nigeria Plc",
										"reserved": "1"
									  },
									  {
										"bankID": 8,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Stanbic IBTC Bank",
										"reserved": "1"
									  },
									  {
										"bankID": 9,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Fidelity Bank Plc",
										"reserved": "1"
									  },
									  {
										"bankID": 10,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Sterling Bank Plc",
										"reserved": "1"
									  },
									  {
										"bankID": 11,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Wema Bank Plc",
										"reserved": "1"
									  },
									  {
										"bankID": 12,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Polaris Bank Limited",
										"reserved": "1"
									  },
									  {
										"bankID": 13,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Keystone Bank Limited",
										"reserved": "1"
									  },
									  {
										"bankID": 14,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Heritage Bank Plc",
										"reserved": "1"
									  },
									  {
										"bankID": 15,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Citibank Nigeria Limited",
										"reserved": "1"
									  },
									  {
										"bankID": 16,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Standard Chartered Bank Nigeria",
										"reserved": "1"
									  },
									  {
										"bankID": 17,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "PalmPay Limited",
										"reserved": "1"
									  },
									  {
										"bankID": 18,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "OPay Digital Services Limited",
										"reserved": "1"
									  },
									  {
										"bankID": 19,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Kuda Bank",
										"reserved": "1"
									  },
									  {
										"bankID": 20,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Moniepoint Microfinance Bank",
										"reserved": "1"
									  },
									  {
										"bankID": 21,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "LAPO Microfinance Bank",
										"reserved": "1"
									  },
									  {
										"bankID": 22,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "AB Microfinance Bank",
										"reserved": "1"
									  },
									  {
										"bankID": 23,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Fortis Microfinance Bank",
										"reserved": "1"
									  },
									  {
										"bankID": 24,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Providus Bank Limited",
										"reserved": "1"
									  },
									  {
										"bankID": 25,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Jaiz Bank Plc",
										"reserved": "1"
									  },
									  {
										"bankID": 26,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Globus Bank Limited",
										"reserved": "1"
									  },
									  {
										"bankID": 27,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "SunTrust Bank Nigeria Limited",
										"reserved": "1"
									  },
									  {
										"bankID": 28,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Parallex Bank Limited",
										"reserved": "1"
									  },
									  {
										"bankID": 29,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "VFD Microfinance Bank",
										"reserved": "1"
									  },
									  {
										"bankID": 30,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "Accion Microfinance Bank",
										"reserved": "1"
									  }
									]
								  },
								  "code": 0,
								  "msg": "Succeed",
								  "msgCode": 0,
								  "serviceNowTime": "$shnunc"
								}
							';				
						}
						else if($withdrawid == 3){
							echo '
								{
								  "data": {
									"banklist": [
									  {
										"bankID": 55,
										"bankLogo": "https://apiimages.skywin786.in/BDGWin",
										"bankName": "TRC",
										"reserved": "3"
									  }
									]
								  },
								  "code": 0,
								  "msg": "Succeed",
								  "msgCode": 0,
								  "serviceNowTime": "$shnunc"
								}
							';	
						}
					}
					else{
						$res['code'] = writefile4;
						$res['msg'] = 'No operation permission';
						$res['msgCode'] = 2;
						http_response_code(401);
						echo json_encode($res);
					}					
				}
				else{					
					$res['code'] = 4;
					$res['msg'] = 'No operation permission';
					$res['msgCode'] = 2;
					http_response_code(401);
					echo json_encode($res);					
				}
			}
			else{
				$res['code'] = 5;
				$res['msg'] = 'Wrong signature';
				$res['msgCode'] = 3;
				http_response_code(200);
				echo json_encode($res);				
			}
		}
		else{
			$res['code'] = 7;
			$res['msg'] = 'Param is Invalid';
			$res['msgCode'] = 6;
			http_response_code(200);
			echo json_encode($res);			
		}		
	} else {		
		http_response_code(405);
		echo json_encode($res);
	}
?>