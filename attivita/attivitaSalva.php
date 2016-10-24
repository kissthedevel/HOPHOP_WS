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

	$data = json_decode( file_get_contents('php://input') );
	
	if( !$data -> id ) {	//INSERT
		$stmt = $conn->prepare(
			"INSERT INTO attivita (
				altezzamax, altezzapart, bpmmax,
				bpmmedia, climatemperatura, climatempo,
				climavento, data, ora,
				dislivellomen, dislivellopos, distanzaattivita,
				distsalita, isgara, kcal,
				tempogara, tempoattivita, tempozonacardio,
				nomegara, noteattivita, pendenzamax,
				pendenzamed, posassoluto, poscategoria,
				sport, totclassificati, velmax,
				velmedia, idatleta
			)
			VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?	)"
		);
		
		$stmt->bind_param("iiiidiissiiddiisssssiiiiiiddi",		
			$data->altezzamax , $data->altezzapart, $data->bpmmax,
			$data->bpmmedia, $data->climatemperatura, $data->climatempo,
			$data->climavento, $data->data, $data->ora,
			$data->dislivellomen, $data->dislivellopos, $data->distanzaattivita,
			$data->distsalita, $data->isgara, $data->kcal,
			$data->tempogara, $data->tempoattivita, $data->tempozonacardio,
			$data->nomegara, $data->noteattivita, $data->pendenzamax,
			$data->pendenzamed, $data->posassoluto, $data->poscategoria,
			$data->sport, $data->totclassificati, $data->velmax,
			$data->velmedia, $data->idatleta
		);
		
		if ($stmt->execute()) {
			if ($stmt->insert_id) {
				array_push( $response->data, $stmt->insert_id);
				$response->message = 'Inserimento eseguito con successo!';
				$response->success = true;
			}
		} else {
			$response->success = false;
			$response->message = "Error: " . $conn->error;
		}
		
		$stmt->close();
	}else {	//UPDATE
// 		$sql = "UPDATE attivita
// 				SET 
// 					altezzamax = " . $data->altezzamax . ", altezzapart = " . $data->altezzapart . ", bpmmax = " . $data->bpmmax . ",
// 					bpmmedia = " . $data->bpmmedia . ", climatemperatura = " . $data->climatemperatura . ", climatempo = " . $data->climatempo . ",
// 					climavento = " . $data->climavento . ", data = " . $data->data . ", ora = " . $data->ora . ",
// 					dislivellomen = " . $data->dislivellomen . ", dislivellopos = " . $data->dislivellopos . ", distanzaattivita = " . $data->distanzaattivita . ",
// 					distsalita = " . $data->distsalita . ", isgara = " . $data->isgara . ", kcal = " . $data->kcal . ",
// 					tempogara = " . $data->tempogara . ", tempoattivita = " . $data->tempoattivita . ", tempozonacardio = " . $data->tempozonacardio . ",
// 					nomegara = " . $data->nomegara . ", noteattivita = " . $data->noteattivita . ", pendenzamax = " . $data->pendenzamax . ",
// 					pendenzamed = " . $data->pendenzamed . ", posassoluto = " . $data->posassoluto . ", poscategoria = " . $data->poscategoria . ",
// 					sport = " . $data->sport . ", totclassificati = " . $data->totclassificati . ", velmax = " . $data->velmax . ",
// 					velmedia = " . $data->velmedia . ", idatleta = " . $data->idatleta . "
// 				WHERE id = " . $data->id . " ";
// 		if ($conn->query($sql) === TRUE) {
// 			echo "New record updated successfully";
// 		} else {
// 			echo "Error: " . $sql . "<br>" . $conn->error;
// 		}
		echo 'da gestire';
	}

	$conn->close();
	echo json_encode($response);
?>