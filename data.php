<?php
	function attemptRequest($params = [])
	{
		$curl = curl_init();

		curl_setopt_array($curl, $params);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		
		return $err ? $err : $response;
	}

	if(!isset($_SESSION['data'])) {
		$data = attemptRequest([
			CURLOPT_URL => "https://developers.zomato.com/api/v2.1/search?entity_id=280&entity_type=city&collection_id=1",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => [
				"user-key: 5c01f92d6713da5d93aaaa36d1de171d",
				"Content: application/json"
			]
		]);

		$_SESSION['data'] = $data;
	}

	echo $data;
?>