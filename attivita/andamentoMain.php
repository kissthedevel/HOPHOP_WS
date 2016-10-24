<?php
	require_once('../parameters.php');
	require_once('../std_functions.php');

	class HOPHOPResponse {
		var $success;
		var $message;
		var $data = [];
	}
	$response = new HOPHOPResponse;
	
	// Create connection
	$conn = new mysqli(SERVERNAME, USERNAME_DB, PWD_DB, DBNAMEMAIN);
	// Check connection
	if ($conn->connect_error) {
// 		die("Connection failed: " . $conn->connect_error);
		$response->success = false;
		$response->message = "Error: " . $conn->connect_error;
	} 
	
	if ( isset($_GET['idatleta']) ) {
		$dataDal = isset($_GET['datadal']) ? $_GET['datadal'] : '1899-12-31';
		$dataAl = isset($_GET['dataal']) ? $_GET['dataal'] : date("Y-m-d H:i:s");
				
		$stmt = $conn->prepare("
			SELECT *
			FROM attivita a
			WHERE a.idatleta = ?
			AND a.data BETWEEN ? AND ?
			ORDER BY a.data ASC
		");
		$stmt->bind_param("iss", $_GET['idatleta'], $dataDal, $dataAl);
		
		if ($stmt->execute()) {
			$response->success = true;
			$response->message = 'Ricerca eseguita con successo!';
			$result = $stmt->get_result();
			
			$numAttivita = 0;
			$kmPercorsi = 0;
			$tempoPercorso = '00:00:00';
			$dislivelloPositivo = 0;
			$kmSalita = 0;
			$alitudineMax = 0;
			$tempoInZona = '00:00:00';
			$kcalTotali = 0;
			$totaleGare = 0;
			// conteggio dei record
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$numAttivita++;
					$kmPercorsi = $kmPercorsi + $row['distanzaattivita'];
					if( $row['tempoattivita'] )
						$tempoPercorso = sum_the_time( $tempoPercorso, $row['tempoattivita'] );
					$dislivelloPositivo = $dislivelloPositivo + $row['dislivellopos'];
					$kmSalita = $kmSalita + $row['distsalita'];
					if( $alitudineMax < $row['altezzamax'] )
						$alitudineMax = $row['altezzamax'];
					if( $row['tempozonacardio'] )
						$tempoInZona = sum_the_time( $tempoInZona, $row['tempozonacardio'] );
					$kcalTotali = $kcalTotali + $row['kcal'];
					if( $row['isgara'] )
						$totaleGare++;
// 					$row['id'];
// 					$row['data'];
// 					$row['ora'];
// 					$row['sport'];
				}
			}
			
			$response->data['sommatorie']['numAttivita'] = $numAttivita;
			$response->data['sommatorie']['kmPercorsi'] = $kmPercorsi;
			$response->data['sommatorie']['tempoPercorso'] = $tempoPercorso;
			$response->data['sommatorie']['dislivelloPositivo'] = $dislivelloPositivo;
			$response->data['sommatorie']['kmSalita'] = $kmSalita;
			$response->data['sommatorie']['alitudineMax'] = $alitudineMax;
			$response->data['sommatorie']['tempoInZona'] = $tempoInZona;
			$response->data['sommatorie']['kcalTotali'] = $kcalTotali;
			$response->data['sommatorie']['totaleGare'] = $totaleGare;
		} else {
			$response->success = false;
			$response->message = "Error: " . $conn->error;
		}
		
		$stmt->close();
	}

	$conn->close();
	echo json_encode($response);
?>