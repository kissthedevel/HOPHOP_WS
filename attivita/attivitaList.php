<?php
	require_once('../parameters.php');

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
	
	if ( isset($_GET['idatleta']) || isset($_GET['id']) ) {
		if ( isset($_GET['idatleta']) ) {
			$dataDal = isset($_GET['datadal']) ? $_GET['datadal'] : '1899-12-31';
			$dataAl = isset($_GET['dataal']) ? $_GET['dataal'] : date("Y-m-d H:i:s");
			
			$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
			
			$stmt = $conn->prepare("
				SELECT *
				FROM attivita a
				WHERE a.idatleta = ?
				AND a.data BETWEEN ? AND ?
				ORDER BY a.data DESC
				LIMIT 10 OFFSET ?
			");
			$stmt->bind_param("issi", $_GET['idatleta'], $dataDal, $dataAl, $offset);
		} else if ( isset($_GET['id']) ) {
			$stmt = $conn->prepare("
				SELECT *
				FROM attivita a
				WHERE a.id = ?
				ORDER BY a.data DESC
			");
			$stmt->bind_param("i", $_GET['id']);
		}
		
		if ($stmt->execute()) {
			$response->success = true;
			$response->message = 'Ricerca eseguita con successo!';
			$result = $stmt->get_result();
			// conteggio dei record
			if ($result->num_rows > 0) {
				$countRecord = 0;
				while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$response->data[$countRecord]['id'] = $row['id'];
					$response->data[$countRecord]['data'] = $row['data'];
					$response->data[$countRecord]['ora'] = $row['ora'];
					$response->data[$countRecord]['altezzamax'] = $row['altezzamax'];
					$response->data[$countRecord]['altezzapart'] = $row['altezzapart'];
					$response->data[$countRecord]['bpmmax'] = $row['bpmmax'];
					$response->data[$countRecord]['bpmmedia'] = $row['bpmmedia'];
					$response->data[$countRecord]['climatemperatura'] = $row['climatemperatura'];
					$response->data[$countRecord]['climatempo'] = $row['climatempo'];
					$response->data[$countRecord]['climavento'] = $row['climavento'];
					$response->data[$countRecord]['dislivellomen'] = $row['dislivellomen'];
					$response->data[$countRecord]['dislivellopos'] = $row['dislivellopos'];
					$response->data[$countRecord]['distanzaattivita'] = $row['distanzaattivita'];
					$response->data[$countRecord]['distsalita'] = $row['distsalita'];
					$response->data[$countRecord]['isgara'] = $row['isgara'];
					$response->data[$countRecord]['kcal'] = $row['kcal'];
					$response->data[$countRecord]['tempogara'] = $row['tempogara'];
					$response->data[$countRecord]['tempoattivita'] = $row['tempoattivita'];
					$response->data[$countRecord]['tempozonacardio'] = $row['tempozonacardio'];
					$response->data[$countRecord]['nomegara'] = $row['nomegara'];
					$response->data[$countRecord]['noteattivita'] = $row['noteattivita'];
					$response->data[$countRecord]['pendenzamax'] = $row['pendenzamax'];
					$response->data[$countRecord]['pendenzamed'] = $row['pendenzamed'];
					$response->data[$countRecord]['posassoluto'] = $row['posassoluto'];
					$response->data[$countRecord]['poscategoria'] = $row['poscategoria'];
					$response->data[$countRecord]['sport'] = $row['sport'];
					$response->data[$countRecord]['totclassificati'] = $row['totclassificati'];
					$response->data[$countRecord]['velmax'] = $row['velmax'];
					$response->data[$countRecord]['velmedia'] = $row['velmedia'];
					$countRecord++;
				}
			}
		} else {
			$response->success = false;
			$response->message = "Error: " . $conn->error;
		}
		
		$stmt->close();
	}

	$conn->close();
	echo json_encode($response);
?>