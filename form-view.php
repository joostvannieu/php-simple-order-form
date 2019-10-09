<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Order food & drinks</title>
</head>
<body>
<!-- Header for user feedback on input -->
<header class="alert alert-danger <?php if (empty($_SESSION["errors"][0])){echo "d-none";} ?>">
    <?php
        foreach ($_SESSION["errors"] as $msg) {
            echo nl2br($msg . "\n");
        }
    ?>
</header>
<header class="alert alert-success <?php if (!$_SESSION["checker"]){echo "d-none"; $_SESSION["checker"] = false; var_dump($_SESSION["checker"]);} ?>">
    Thank you for your order.<br>
    It should arrive at <?php echo date("H:i", $deliveryTime) ?>
</header>
<!-- END Header for user feedback on input -->

<div class="container">
    <h1>Order food in restaurant "the Personal Ham Processors"</h1>

    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" class="form-control" value="<?php
                echo $_SESSION["email"] ?>">
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:*</label>
                    <input type="text" name="street" id="street" class="form-control" required value="<?php
                            echo $_SESSION["street"] ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:*</label>
                    <input type="number" step="1" min="1" id="streetnumber" name="streetnumber" class="form-control" required value="<?php
                    echo $_SESSION["streetnumber"] ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:*</label>
                    <input type="text" id="city" name="city" class="form-control" required value="<?php
                    echo $_SESSION["city"] ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode:*</label>
                    <input type="number" step="1" min="1000" max="9999" id="zipcode" name="zipcode" class="form-control" required value="<?php
                    echo $_SESSION["zipcode"] ?>">
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="1" name="products[<?php echo $i ?>]" <?php
                        if ($_SESSION["products"][$i]) echo "checked"; ?>>
                    <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
        </fieldset>
        <fieldset>
            <legend>Delivery</legend>
            <div>
                <div>
                    <input type="radio" id="deliveryMethod1"
                           name="delivery" value="regular" checked>
                    <label for="deliveryMethod1">Regular delivery: 2 hours</label>
                </div>
                <div>
                    <input type="radio" id="deliveryMethod2"
                           name="delivery" value="express">
                    <label for="deliveryMethod2">Express delivery: 45 minutes</label>
                </div>
            </div>
        </fieldset>

        <button type="submit" class="btn btn-primary">Order!</button>
    </form>

    <footer>You already ordered <strong>&euro; <?php echo $_COOKIE["PHPsandwiches"]?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>
