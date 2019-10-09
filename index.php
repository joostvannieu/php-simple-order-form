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
if ($_GET["food"] == 1 || $_GET["food"] == null) {
    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
} elseif ($_GET["food"] == 0) {
    $products = [
        ['name' => 'Cola', 'price' => 2],
        ['name' => 'Fanta', 'price' => 2],
        ['name' => 'Sprite', 'price' => 2],
        ['name' => 'Ice-tea', 'price' => 3],
    ];
}

$totalValue = 0;



//Your code here
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$emailError = $streetError = $streetnumberError = $cityError = $zipcodeError = $orderError = $deliveryError = "";
$email = $street = $city = $delivery = "";
$streetnumber = $zipcode = 0;
$order = $errorMsgs = [];
$deliveryTime = time();
$isValidOrder = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $_SESSION = $_POST;

    if (empty($_SESSION["email"])) {
        $email = "";
    } else {
        $email = test_input($_SESSION["email"]);
        // check if email address syntax is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = "Invalid email format";
            $errorMsgs[] = $emailError;
        }
    }

    if (empty($_SESSION["street"])){
        $streetError = "Street is required";
        $errorMsgs[] = $streetError;
    } else {
        $street = test_input($_SESSION["street"]);
    }

    if (empty($_SESSION["streetnumber"])){
        $streetnumberError = "Streetnumber is required";
        $errorMsgs[] = $streetnumberError;
    } else {
        $streetnumber = test_input($_SESSION["streetnumber"]);
        if (!filter_var($streetnumber, FILTER_VALIDATE_INT)){
            $streetnumberError = "Streetnumber is invalid";
            $errorMsgs[] = $streetnumberError;
        }
    }

    if (empty($_SESSION["city"])){
        $cityError = "City is required";
        $errorMsgs[] = $cityError;
    } else {
        $city = test_input($_SESSION["city"]);
    }

    if (empty($_SESSION["zipcode"])){
        $zipcodeError = "Zipcode is required";
        $errorMsgs[] = $zipcodeError;
    } else {
        $zipcode = test_input($_SESSION["zipcode"]);
        if (!filter_var($zipcode, FILTER_VALIDATE_INT)) {
            $zipcodeError = "zipcode is invalid";
            $errorMsgs[] = $zipcodeError;
        }
    }

    if (empty($_SESSION["products"])) {
        $orderError = "Please select items you would like to order";
        $errorMsgs[] = $orderError;
    } else {
            $order = $_SESSION["products"];
    }

    if (empty($_SESSION["delivery"])){
        $deliveryError = "Delivery method is required";
        $errorMsgs[] = $deliveryError;
    } else {
        $delivery = test_input($_SESSION["delivery"]);
    }

    foreach ($order as $key => $item){
        $totalValue +=  $products[$key]["price"];
        $_SESSION["totalValue"] = $totalValue;
    }

    //If the order is completely without errors
    $_SESSION["errors"] = $errorMsgs;
    if (empty($_SESSION["errors"])){
        $isValidOrder = true;
        //$_SESSION["isValid"] = $isValidOrder;
    }

    //whatIsHappening();

    //If the order is valid
    if ($isValidOrder){
        if ($_SESSION["delivery"] == "express"){
            $deliveryTime += (45 * 60);
        }else {
            $deliveryTime += (2 * 60 * 60);
        }
        if (!isset($_COOKIE["PHPsandwiches"])){
            setcookie("PHPsandwiches", (string)$_SESSION["totalValue"], time() + (10 * 365 * 24 * 60 * 60));
        } else {
            setcookie("PHPsandwiches", (string)($_COOKIE["PHPsandwiches"] + $_SESSION["totalValue"]), time() + (10 * 365 * 24 * 60 * 60));
        }

        $_SESSION["checker"] = true;
        //clear session for next order
        //unset($_SESSION);
        unset($_POST);
        header('Location:'.$_SERVER['PHP_SELF']);
        //die;
    }

}

if ($_SESSION["checker"]){

    whatIsHappening();

}

// keep this at the bottom
require 'form-view.php';