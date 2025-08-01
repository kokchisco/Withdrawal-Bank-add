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
		if (isset($shonupost['language']) && isset($shonupost['random']) && isset($shonupost['signature']) && isset($shonupost['timestamp'])) {
			$language = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['language']));
			$pageNo = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['pageNo']));
			$pageSize = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['pageSize']));
			$random = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['random']));
			$signature = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['signature']));
			$typeId = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['typeId']));
			$shonustr = '{"language":'.$language.',"pageNo":'.$pageNo.',"pageSize":'.$pageSize.',"random":"'.$random.'","typeId":'.$typeId.'}';
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
						if($typeId == 13){
							$jayshriram = 'gellaluhogiondu_trx';
						}
						else if($typeId == 14){
							$jayshriram = 'gellaluhogiondu_trx3';
						}
						else if($typeId == 15){
							$jayshriram = 'gellaluhogiondu_trx5';
						}
						else if($typeId == 16){
							$jayshriram = 'gellaluhogiondu_trx10';
						}
						$samatolana = ($pageNo - 1) * 10;
						$samasye = "SELECT kalaparichaya, phalitansa, banna, bele, bh, hash,dinankavannuracisi
						  FROM ".$jayshriram."
						  ORDER BY shonu DESC LIMIT $pageSize OFFSET $samatolana";
						$samasyephalitansa = $conn->query($samasye);
						
						if ($samasyephalitansa->num_rows > 0) {
                             $i = 0;
                             $data['data'] = []; 
                             $data['data']['date'] = [
                                 'serviceTime' => date('Y-m-d H:i:s')  
                             ];
                             $data['data']['gameslist'] = [];  

                             while ($row = $samasyephalitansa->fetch_assoc()) {
                                 $data['data']['gameslist'][$i] = [
                                     'issueNumber' => $row['kalaparichaya'],
                                     'number' => $row['phalitansa'],
                                     'colour' => $row['banna'],
                                     'premium' => $row['bele'],
                                     'blockID' => $row['hash'],
                                     'blockNumber' => $row['bh'],
                                     'blockTime' => $row['dinankavannuracisi'],
                                     //'premium' => $row['bele'],
                                 ];
                                $i++;
                             }
                         }

						else{
							$data['list'] = null;
						}
						
						$samasye_ondu = "SELECT shonu
						  FROM ".$jayshriram;
						$samasyephalitansa_ondu = $conn->query($samasye_ondu);
						$samasyephalitansa_sankhye = mysqli_num_rows($samasyephalitansa_ondu);
						
						$data['pageNo'] = $pageNo;
						$data['totalPage'] = ceil($samasyephalitansa_sankhye/10);
						$data['totalCount'] = $samasyephalitansa_sankhye;
						
						$res['data'] = $data;
						$res['code'] = 0;
						$res['msg'] = 'Succeed';
						$res['msgCode'] = 0;
						http_response_code(200);
						echo json_encode($res);					
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