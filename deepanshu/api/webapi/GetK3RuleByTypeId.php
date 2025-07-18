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
			$random = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['random']));
			$signature = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['signature']));
			$typeId = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['typeId']));
			$shonustr = '{"language":'.$language.',"random":"'.$random.'","typeId":'.$typeId.'}';
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
						if($typeId == 9){
							$data['typeID'] = $typeId;
							$data['gamePresentation'] = '
								<p class="p0">Fast 1 open with 3 numbers in each period as the opening number. The opening numbers are 111 to 666, Natural numbers, No zeros in the array, and the opening numbers are in no particular order. Quick 3 is to guess all or part of the 3 winning numbers.</p><p class="p0">Sum Value</p><p class="p0">Place a bet on the sum of three numbers.</p><p class="p0">Choose 3 same number all</p><p class="p0">For all the same three numbers (111, 222, ..., 666), make an all-inclusive bet.</p><p class="p0">Choose 3 same number single</p><p class="p0">From all the same three numbers (111, ..., 666), choose a group of numbers in any of them to place bets.</p><p class="p0">Choose 2 Same Multiple</p><p class="p0">Place a bet on two designated same numbers and an arbitrary number among the three numbers.</p><p class="p0">Choose 2 Same Single</p><p class="p0">Place a bet on two designated same numbers and a designated different number among the three numbers.</p><p class="p0">3 numbers different</p><p class="p0">Place a bet on three different numbers.</p><p class="p0">2 numbers different</p><p class="p0">Place a bet on two designated different numbers and an arbitrary number among the three numbers.</p><p class="p0">Choose 3 Consecutive number all</p><p class="p0">For all three consecutive numbers (123, 234, 345, 456), place a bet.</p><p class="p0">Description of winning and odds:</p><p class="p0">Sum Value</p><p class="p0">A bet with the same opening number and value is the winning bet.</p><p class="p0">Choose 3 same number all</p><p class="p0">If the opening numbers are any three of the same number, it is the winning bet.</p><p class="p0">Choose 3 same numbers single</p><p class="p0">A bet that is exactly the same as the opening number is the winning bet.</p><p class="p0">Choose 2 Same Multiple</p><p class="p0">The same number as the two same numbers in the opening number (except for the three same numbers) is the winning bet.</p>

                                ';
						} else if($typeId == 10){
							$data['typeID'] = $typeId;
							$data['gamePresentation'] = '
								<p class="p0">Fast 3 open with 3 numbers in each period as the opening number. The opening numbers are 111 to 666, Natural numbers, No zeros in the array, and the opening numbers are in no particular order. Quick 3 is to guess all or part of the 3 winning numbers.</p><p class="p0">Sum Value</p><p class="p0">Place a bet on the sum of three numbers.</p><p class="p0">Choose 3 same number all</p><p class="p0">For all the same three numbers (111, 222, ..., 666), make an all-inclusive bet.</p><p class="p0">Choose 3 same number single</p><p class="p0">From all the same three numbers (111, ..., 666), choose a group of numbers in any of them to place bets.</p><p class="p0">Choose 2 Same Multiple</p><p class="p0">Place a bet on two designated same numbers and an arbitrary number among the three numbers.</p><p class="p0">Choose 2 Same Single</p><p class="p0">Place a bet on two designated same numbers and a designated different number among the three numbers.</p><p class="p0">3 numbers different</p><p class="p0">Place a bet on three different numbers.</p><p class="p0">2 numbers different</p><p class="p0">Place a bet on two designated different numbers and an arbitrary number among the three numbers.</p><p class="p0">Choose 3 Consecutive number all</p><p class="p0">For all three consecutive numbers (123, 234, 345, 456), place a bet.</p><p class="p0">Description of winning and odds:</p><p class="p0">Sum Value</p><p class="p0">A bet with the same opening number and value is the winning bet.</p><p class="p0">Choose 3 same number all</p><p class="p0">If the opening numbers are any three of the same number, it is the winning bet.</p><p class="p0">Choose 3 same numbers single</p><p class="p0">A bet that is exactly the same as the opening number is the winning bet.</p><p class="p0">Choose 2 Same Multiple</p><p class="p0">The same number as the two same numbers in the opening number (except for the three same numbers) is the winning bet.</p>

							';
						} else if($typeId == 11){
							$data['typeID'] = $typeId;
							$data['gamePresentation'] = '
							<p class="p0">Fast 5 open with 3 numbers in each period as the opening number. The opening numbers are 111 to 666, Natural numbers, No zeros in the array, and the opening numbers are in no particular order. Quick 3 is to guess all or part of the 3 winning numbers.</p><p class="p0">Sum Value</p><p class="p0">Place a bet on the sum of three numbers.</p><p class="p0">Choose 3 same number all</p><p class="p0">For all the same three numbers (111, 222, ..., 666), make an all-inclusive bet.</p><p class="p0">Choose 3 same number single</p><p class="p0">From all the same three numbers (111, ..., 666), choose a group of numbers in any of them to place bets.</p><p class="p0">Choose 2 Same Multiple</p><p class="p0">Place a bet on two designated same numbers and an arbitrary number among the three numbers.</p><p class="p0">Choose 2 Same Single</p><p class="p0">Place a bet on two designated same numbers and a designated different number among the three numbers.</p><p class="p0">3 numbers different</p><p class="p0">Place a bet on three different numbers.</p><p class="p0">2 numbers different</p><p class="p0">Place a bet on two designated different numbers and an arbitrary number among the three numbers.</p><p class="p0">Choose 3 Consecutive number all</p><p class="p0">For all three consecutive numbers (123, 234, 345, 456), place a bet.</p><p class="p0">Description of winning and odds:</p><p class="p0">Sum Value</p><p class="p0">A bet with the same opening number and value is the winning bet.</p><p class="p0">Choose 3 same number all</p><p class="p0">If the opening numbers are any three of the same number, it is the winning bet.</p><p class="p0">Choose 3 same numbers single</p><p class="p0">A bet that is exactly the same as the opening number is the winning bet.</p><p class="p0">Choose 2 Same Multiple</p><p class="p0">The same number as the two same numbers in the opening number (except for the three same numbers) is the winning bet.</p>

   
							';
						} else if($typeId == 12){
							$data['typeID'] = $typeId;
							$data['gamePresentation'] = '
								<p class="p0">Fast 10 open with 3 numbers in each period as the opening number. The opening numbers are 111 to 666, Natural numbers, No zeros in the array, and the opening numbers are in no particular order. Quick 3 is to guess all or part of the 3 winning numbers.</p><p class="p0">Sum Value</p><p class="p0">Place a bet on the sum of three numbers.</p><p class="p0">Choose 3 same number all</p><p class="p0">For all the same three numbers (111, 222, ..., 666), make an all-inclusive bet.</p><p class="p0">Choose 3 same number single</p><p class="p0">From all the same three numbers (111, ..., 666), choose a group of numbers in any of them to place bets.</p><p class="p0">Choose 2 Same Multiple</p><p class="p0">Place a bet on two designated same numbers and an arbitrary number among the three numbers.</p><p class="p0">Choose 2 Same Single</p><p class="p0">Place a bet on two designated same numbers and a designated different number among the three numbers.</p><p class="p0">3 numbers different</p><p class="p0">Place a bet on three different numbers.</p><p class="p0">2 numbers different</p><p class="p0">Place a bet on two designated different numbers and an arbitrary number among the three numbers.</p><p class="p0">Choose 3 Consecutive number all</p><p class="p0">For all three consecutive numbers (123, 234, 345, 456), place a bet.</p><p class="p0">Description of winning and odds:</p><p class="p0">Sum Value</p><p class="p0">A bet with the same opening number and value is the winning bet.</p><p class="p0">Choose 3 same number all</p><p class="p0">If the opening numbers are any three of the same number, it is the winning bet.</p><p class="p0">Choose 3 same numbers single</p><p class="p0">A bet that is exactly the same as the opening number is the winning bet.</p><p class="p0">Choose 2 Same Multiple</p><p class="p0">The same number as the two same numbers in the opening number (except for the three same numbers) is the winning bet.</p>

							';
						} else {
							$res['code'] = 8;
							$res['msg'] = 'Invalid typeId';
							$res['msgCode'] = 7;
							http_response_code(400);
							echo json_encode($res);
							exit;
						}
						
						$res['data'] = $data;
						$res['code'] = 0;
						$res['msg'] = 'Succeed';
						$res['msgCode'] = 0;
						http_response_code(200);
						echo json_encode($res);					
					} else {
						$res['code'] = 4;
						$res['msg'] = 'No operation permission';
						$res['msgCode'] = 2;
						http_response_code(401);
						echo json_encode($res);
					}					
				} else {					
					$res['code'] = 4;
					$res['msg'] = 'No operation permission';
					$res['msgCode'] = 2;
					http_response_code(401);
					echo json_encode($res);					
				}
			} else {
				$res['code'] = 5;
				$res['msg'] = 'Wrong signature';
				$res['msgCode'] = 3;
				http_response_code(200);
				echo json_encode($res);				
			}
		} else {
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
