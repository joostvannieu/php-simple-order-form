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
function errorMessaging(){
    return
}

function validate(string $key, $input) : string {
    switch ($key) {
        case "email":
                // check if e-mail address is well-formed
                if ($input!=="" && !filter_var($input, FILTER_VALIDATE_EMAIL)) {
                    return "Invalid email format";
                }
            break;
        case "street":
            if (empty($input)){
                return "Street is required";
            }
            break;
        case "streetnumber":
            if (empty($input)){
                return "Streetnumber is required";
            } elseif (!filter_var($input, FILTER_VALIDATE_INT)) {
                return "Invalid streetnumber";
            }
            break;
        case "city":
            if (empty($input)){
                return "City is required";
            }
            break;
        case "zipcode":
            if (empty($input)){
                return "Zipcode is required";
            } elseif (!filter_var($input, FILTER_VALIDATE_INT)) {
                return "Invalid zipcode";
            }
            break;
        case "products":
            if (!$input) {
                return "Please select products you would like to order";
            }
            break;
        default: return "This shouldn't be here";
    }
    return "";
}


function getFormData() {
    $email = $street = $city = $errormsg = "";
    $streetnumber = $zipcode = 0;
    $checkvalue = false;


    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        whatIsHappening();
        foreach ($_POST as $key => $value) {
            if (!is_array($value)) {
                echo nl2br(validate($key, htmlspecialchars($value)));
                echo nl2br($key . ": " . $value . "\n");
                $errormsg
            }else {
                foreach ($value as $keyInner => $item) {
                    echo nl2br(validate($key, $item));
                    echo nl2br($key . ": " . $GLOBALS["products"][$keyInner]["name"] . "\n");
                }
            }
        }
    }
}

getFormData();
echo "All clear";