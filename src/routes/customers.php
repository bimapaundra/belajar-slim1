<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app = new \Slim\App;

//get all customers
$app->get('/api/customers', function(Request $request, Response $response){

	$sql="SELECT * FROM customers";

	try{
		//get db object
		// variabel $db mewakili class db pada db.php
		$db = new db();
		//connect
		// memanggil fungsi connect pada class db
		$db = $db->connect();

		$stmt= $db->query($sql);

		$customers = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db= null;
		echo json_encode($customers);

	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'} }';
	}
	
});

//get one customer
$app->get('/api/customer/{id}', function(Request $request, Response $response){

	$id = $request->getAttribute('id');

	$sql="SELECT * FROM customers WHERE id =$id";

	try{
		//get db object
		// variabel $db mewakili class db pada db.php
		$db = new db();
		//connect
		// memanggil fungsi connect pada class db
		$db = $db->connect();

		$stmt= $db->query($sql);

		$customer = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db= null;
		echo json_encode($customer);

	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'} }';
	}
	
});

//add customer
$app->post('/api/customer/add', function(Request $request, Response $response){

		$first_name = $request->getParam('first_name');
		$last_name  = $request->getParam('last_name');
		$phone = $request->getParam('phone');
		$email = $request->getParam('email');
		$address = $request->getParam('address');
		$city = $request->getParam('city');
		$state = $request->getParam('state');



	$sql="INSERT INTO customers (first_name, last_name, phone, email, address, city, state) VALUES (:first_name, :last_name, :phone, :email, :address, :city, :state)";

	try{
		//get db object
		// variabel $db mewakili class db pada db.php
		$db = new db();
		//connect
		// memanggil fungsi connect pada class db
		$db = $db->connect();

		$stmt =$db->prepare($sql);

		$stmt->bindParam(':first_name', $first_name);
		$stmt->bindParam(':last_name', $last_name);
		$stmt->bindParam(':phone', $phone);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':address', $address);
		$stmt->bindParam(':city', $city);
		$stmt->bindParam(':state', $state);

		$stmt->execute();

		echo '{"error": {"text": "Customer Added"}}';

	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'} }';
	}
	
});