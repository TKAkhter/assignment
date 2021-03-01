<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Packet Pricing</title>
</head>

<body>
    <h2>Task 2</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <fieldset>
            <legend>Required Information</legend>

            <div class="group-field">
                <p><b>Number of bottles</b></p>
                <input required class="input-style" type="text" id="Required-Bottles" name="Required-Bottles" placeholder="Enter Number of bottles" />
                <p class="tooltip-info"><i>EX: 15</i></p>
            </div>

            <div class="group-field">
                <p><b>Prices</b></p>
                <input required class="input-style" type="text" id="Prices-Bottles" name="Prices-Bottles" placeholder="Enter Prices for single, pack and box" />
                <p class="tooltip-info"><i>EX: [2.3, 25, 230]</i></p>
            </div>

            <div class="group-field">
                <p><b>Number of bottles</b></p>
                <input required class="input-style" type="text" id="Quantity-Bottles" name="Quantity-Bottles" placeholder="Enter Quantity for single, pack and box" />
                <p class="tooltip-info"><i>EX: [1, 12, 12*10]</i></p>
            </div>

            <div class="group-field">
                <input type="submit" value="Submit">
            </div>
        </fieldset>
    </form>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('error_reporting', E_ALL);
    ini_set('display_startup_errors', 1);
    error_reporting(-1);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $required_bottles = $_POST['Required-Bottles'];
        // $required_bottles = 1;
        $prices_bottles = $_POST['Prices-Bottles'];
        // $prices_bottles = '2.3,25,230';
        $prices_bottles =  explode(",", trim($prices_bottles));
        // print_r($prices_bottles);

        $quantity_bottles = $_POST['Quantity-Bottles'];
        // $quantity_bottles = '1,12,120';
        $quantity_bottles =  explode(",", trim($quantity_bottles));
        // print_r($quantity_bottles);

        $bottles = 0;
        $packs = 0;
        $boxes = 0;
        $remain = $required_bottles;
        while ($remain > 0) {
            // echo 'hi-a ' . $prices_bottles[1] . '<' . $remain * $prices_bottles[0];
            $final_price = ($bottles * $prices_bottles[0]) + ($packs * $prices_bottles[1]);
            // echo $final_price . '=' . $remain . '>';
            if ($final_price > $prices_bottles[2]) {
                // if ($prices_bottles[2] < ($remain * $prices_bottles[1]) && $remain > 0) {
                // echo 'hi-e';
                $remain = $remain - $quantity_bottles[2];
                $boxes++;
                $bottles = 0;
                $packs = 0;
                continue;
            }
            if ($prices_bottles[1] < ($remain * $prices_bottles[0]) && $remain > 0) {
                // echo 'hi-b';
                $remain = $remain - $quantity_bottles[1];
                $packs++;
                continue;
            }
            // echo 'hi-d';
            $remain = $remain - $quantity_bottles[0];
            $bottles++;
        }

        $final_price = ($bottles * $prices_bottles[0]) + ($packs * $prices_bottles[1]) + ($boxes * $prices_bottles[2]);
        // echo '"bottles" : ' . $bottles . ',“packs”: ' . $packs . ',“Box”: ' . $boxes . ',"price" : ' . $final_price;

        response($final_price, $bottles, $packs, $boxes, $quantity_bottles, $prices_bottles);
    }

    function response($final_price, $bottles, $packs, $boxes, $quantity_bottles, $prices_bottles)
    {
        $response['pricelist']['piece']['name'] = "Bottles";
        $response['pricelist']['piece']['quantity'] = $quantity_bottles[0];
        $response['pricelist']['piece']['price'] = $prices_bottles[0];
        $response['pricelist']['pack']['name'] = "12-pack";
        $response['pricelist']['pack']['quantity'] = $quantity_bottles[1];
        $response['pricelist']['pack']['price'] = $prices_bottles[1];
        $response['pricelist']['box']['name'] = "Big box";
        $response['pricelist']['box']['quantity'] = $quantity_bottles[2];
        $response['pricelist']['box']['price'] = $prices_bottles[2];
        $response['result']['bottles'] = $bottles;
        $response['result']['packs'] = $packs;
        $response['result']['Box'] = $boxes;
        $response['result']['price'] = $final_price;

        $json_response = json_encode($response);
        echo $json_response;
    }

    ?>
    <p><strong>Task 2.</strong> Assume the following JSON data is available to the frontend via GET request (this is an example):</p>
    <p><br />{<br />"<strong><span style="color: #800080;">pricelist</span></strong>" : [<br />{<br />"<strong><span style="color: #800080;">piece</span></strong>" : { "<strong><span style="color: #800080;">name</span></strong>" : "<strong><span style="color: #008000;">Bottle</span></strong>" , "<strong><span style="color: #800080;">quantity</span></strong>" : <strong><span style="color: #0000ff;">1</span></strong> , "<strong><span style="color: #800080;">price</span></strong>" : <span style="color: #0000ff;"><strong>2.3</strong></span> },<br />"<strong><span style="color: #800080;">pack</span></strong>" : { "<strong><span style="color: #800080;">name</span></strong>" : "<strong><span style="color: #008000;">12-pack</span></strong>" , "<strong><span style="color: #800080;">quantity</span></strong>" : <span style="color: #0000ff;">12</span> , "<strong><span style="color: #800080;">price</span></strong>" : <span style="color: #0000ff;"><strong>25</strong></span> },<br />"<strong><span style="color: #800080;">box</span></strong>" : { "<strong><span style="color: #800080;">name</span></strong>" : "<span style="color: #008000;"><strong>Big box</strong></span>" , "<strong><span style="color: #800080;">quantity</span></strong>" : <span style="color: #0000ff;"><strong>120</strong> </span>, "<strong><span style="color: #800080;">price</span></strong>" : <span style="color: #0000ff;"><strong>230</strong> </span>}<br />}<br />]}</p>
    <p><br />Design and code a visualization of the pricelist with a possibility for a buyer to input the minimum required number of pieces of each product and get a calculation of how many packages of each product one needs to buy to maximally save money using the API written in Task 1 and fetch the data through GET API written in Task 2. Choose any Javascript framework Preferably React or Angular or Vue.js. It would be good if you write Unit tests for each component.</p>
    <p>Please, provide source codes in a zip archive for the programs to <a href="mailto:abdul.moeed@progstream.com">abdul.moeed@progstream.com</a> with CODING in the subject and a couple of screenshots, illustrating how the solution works. Would be nice if the solution will work when the html file is opened in the browser.</p>
</body>

</html>