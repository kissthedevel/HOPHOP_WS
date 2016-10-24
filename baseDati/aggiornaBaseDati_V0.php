<?php
	require_once('../parameters.php');
	
	// Create connection
	$conn = new mysqli(SERVERNAME, USERNAME_DB, PWD_DB, DBNAMEMAIN);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	echo '<br>************************************************<br>';
	// sql to create table
	$sql = "CREATE TABLE TEAM (
				id INT(7) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				nome VARCHAR(30) NOT NULL,
				citta VARCHAR(30) NOT NULL,
				email VARCHAR(50),
				tel VARCHAR(30),
				datacreazione DATETIME,
				datanascita DATETIME,
				codsquadra VARCHAR(20),
				federazione VARCHAR(20),
				colorisociali VARCHAR(20)
			)";
	if ($conn->query($sql) === TRUE) {
		echo "Table TEAM created successfully";
	} else {
		echo "Error creating table: " . $conn->error;
	}
	
	echo '<br>************************************************<br>';
	// sql to create table
	$sql = "CREATE TABLE ATLETA (
				id INT(7) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
				nome VARCHAR(30) NOT NULL,
				cognome VARCHAR(30) NOT NULL,
				email VARCHAR(50),
				tel VARCHAR(30),
				datacreazione DATETIME,
				datanascita DATETIME,
				cittanascita VARCHAR(30),
				cittaresidenza VARCHAR(30),
				sesso VARCHAR(1),
				altezzacm INT(3),
				peso DOUBLE,
				codsquadra INT(7),
				codtessera VARCHAR(20),
				bici1 VARCHAR(50),
				bici2 VARCHAR(50),
				bici3 VARCHAR(50),
				username VARCHAR(20),
				password VARCHAR(20),
				INDEX (codsquadra)
			)";
	if ($conn->query($sql) === TRUE) {
		echo "Table ATLETA created successfully";
	} else {
		echo "Error creating table: " . $conn->error;
	}
	
	echo '<br>************************************************<br>';
	// sql to create table
	$sql = "CREATE TABLE ATTIVITA (
				id INT(7) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				idatleta INT(7) UNSIGNED NOT NULL,
				altezzamax INT(5),
				altezzapart INT(5),
				bpmmax INT(3),
				bpmmedia INT(3),
				climatemperatura DOUBLE,
				climatempo INT(2),
				climavento INT(2),
				data DATETIME NOT NULL,
				ora TIME,
				dislivellomen INT(5),
				dislivellopos INT(5),
				distanzaattivita DOUBLE NOT NULL,
				distsalita DOUBLE,
				isgara BOOLEAN,
				kcal INT(5),
				tempogara TIME,
				tempoattivita TIME NOT NULL,
				tempozonacardio TIME,
				nomegara VARCHAR(30),
				noteattivita VARCHAR(300),
				pendenzamax INT(2),
				pendenzamed INT(2),
				posassoluto INT(5),
				poscategoria INT(5),
				sport INT(5) NOT NULL,
				totclassificati INT(5),
				velmax DOUBLE,
				velmedia DOUBLE,
				INDEX (idatleta)
			)";
	if ($conn->query($sql) === TRUE) {
		echo "Table ATLETA created successfully";
	} else {
		echo "Error creating table: " . $conn->error;
	}
	
	$conn->close();
?>