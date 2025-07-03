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
		if (isset($shonupost['language']) && isset($shonupost['pageNo']) && isset($shonupost['pageSize']) && isset($shonupost['random']) && isset($shonupost['signature']) && isset($shonupost['timestamp'])) {
			$language = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['language']));
			$pageNo = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['pageNo']));
			$pageSize = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['pageSize']));
			$random = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['random']));
			$signature = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['signature']));
			$shonustr = '{"language":'.$language.',"pageNo":'.$pageNo.',"pageSize":'.$pageSize.',"random":"'.$random.'"}';
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
                        $data["list"][0]["bannerTitle"] = "First Deposit Bonus";
                        $data["list"][0]["bannerID"] = 71;
                        $data["list"][0]["bannerUrl"] = "https://ossimg.jalwa-jalwa.com/Jalwa/banner/Banner_20250324130803du5l.jpg";
                        $data["list"][0]["jumpType"] = 2;
                        $data["list"][0]["contents"] = "/activity/FirstRecharge";
                        
                        $data["list"][1]["bannerTitle"] = "Invitation Bonus";
                        $data["list"][1]["bannerID"] = 62;
                        $data["list"][1]["bannerUrl"] = "https://ossimg.jalwa-jalwa.com/Jalwa/banner/Banner_2025031913463468d9.jpg";
                        $data["list"][1]["jumpType"] = 2;
                        $data["list"][1]["contents"] = "/main/InvitationBonus";
                        
                        $data["list"][2]["bannerTitle"] = "Win Streak 2X Price Happy Hour";
                        $data["list"][2]["bannerID"] = 53;
                        $data["list"][2]["bannerUrl"] = "https://ossimg.jalwa-jalwa.com/Jalwa/banner/Banner_20250331135148gwm3.jpg";
                        $data["list"][2]["jumpType"] = 1;
                        $data["list"][2]["contents"] = "";
                        
                        $data["list"][3]["bannerTitle"] = "Lucky Spin To Win Iphone 16 Pro Max";
                        $data["list"][3]["bannerID"] = 59;
                        $data["list"][3]["bannerUrl"] = "https://ossimg.jalwa-jalwa.com/Jalwa/banner/Banner_20250319134140rpj6.jpg";
                        $data["list"][3]["jumpType"] = 2;
                        $data["list"][3]["contents"] = "/activity/Turntable";
                        
                        $data["list"][4]["bannerTitle"] = "Daily Bonus Until 1 CRORE";
                        $data["list"][4]["bannerID"] = 69;
                        $data["list"][4]["bannerUrl"] = "https://ossimg.jalwa-jalwa.com/Jalwa/banner/Banner_20250324130748d4lf.jpg";
                        $data["list"][4]["jumpType"] = 1;
                        $data["list"][4]["contents"] = "";
                        
                        $data["list"][5]["bannerTitle"] = "Monthly VIP Bonus";
                        $data["list"][5]["bannerID"] = 46;
                        $data["list"][5]["bannerUrl"] = "https://ossimg.jalwa-jalwa.com/Jalwa/banner/Banner_20250324143742sd37.jpg";
                        $data["list"][5]["jumpType"] = 2;
                        $data["list"][5]["contents"] = "/vip";
                        
                       

						
						$data['pageNo'] = $pageNo;
						$data['totalPage'] = 1;
						$data['totalCount'] = 20;
						
						$res['data'] = $data;
						$res['code'] = 0;
						$res['msg'] = 'Succeed';
						$res['msgCode'] = 0;
						http_response_code(200);
						echo json_encode($res);			
					}
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