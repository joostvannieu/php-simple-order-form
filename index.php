<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

//your products with their price.
$products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

$products = [
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
];

$totalValue = 0;

require 'form-view.php';

//Your code here
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$emailError = $streetError = $streetnumberError = $cityError = $zipcodeError = $orderError = "";
$email = $street = $city = "";
$streetnumber = $zipcode = 0;
$order = $errorMsgs = [];



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $email = "";
    } else {
        $email = test_input($_POST["email"]);
        // check if email address syntax is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = "Invalid email format";
            $errorMsgs[] = $emailError;
        }
    }

    if (empty($_POST["street"])){
        $streetError = "Street is required";
        $errorMsgs[] = $streetError;
    } else {
        $street = test_input($_POST["street"]);
    }

    if (empty($_POST["streetnumber"])){
        $streetnumberError = "Streetnumber is required";
        $errorMsgs[] = $streetnumberError;
    } else {
        $streetnumber = test_input($_POST["streetnumber"]);
        if (!filter_var($streetnumber, FILTER_VALIDATE_INT)){
            $streetnumberError = "Streetnumber is invalid";
            $errorMsgs[] = $streetnumberError;
        }
    }

    if (empty($_POST["city"])){
        $cityError = "City is required";
        $errorMsgs[] = $cityError;
    } else {
        $city = test_input($_POST["city"]);
    }

    if (empty($_POST["zipcode"])){
        $zipcodeError = "Zipcode is required";
        $errorMsgs[] = $zipcodeError;
    } else {
        $zipcode = test_input($_POST["zipcode"]);
        if (!filter_var($zipcode, FILTER_VALIDATE_INT)) {
            $zipcodeError = "zipcode is invalid";
            $errorMsgs[] = $zipcodeError;
        }
    }

    if (empty($_POST["products"])) {
        $orderError = "what?";
        $errorMsgs[] = $orderError;
    } else {
            $order = $_POST["products"];
    }


    foreach ($order as $key => $item){
        $totalValue +=  $products[$key]["price"];
        $_SESSION["totalValue"] = $totalValue;
    }

    $_SESSION["errors"] = $errorMsgs;

    whatIsHappening();

    if (!empty($errorMsgs)){
        foreach ($errorMsgs as $msg){
            echo nl2br($msg . "\n");
        }
    }
    echo nl2br($email . "\n" . $street . "\n" . $streetnumber . "\n" . $city . "\n" . $zipcode . "\n");
    echo number_format($totalValue, 2);
}
