<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packet Pricing</title>
</head>

<body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <fieldset>
            <legend>Required Information</legend>

            <div class="group-field">
                <p><b>Number of bottles</b></p>
                <input class="input-style" type="text" id="Required-Bottles" name="Required-Bottles" placeholder="Enter Number of bottles" />
                <p class="tooltip-info"><i>EX: 15</i></p>
            </div>

            <div class="group-field">
                <p><b>Prices</b></p>
                <input class="input-style" type="text" id="Prices-Bottles" name="Prices-Bottles" placeholder="Enter Prices for single, pack and box" />
                <p class="tooltip-info"><i>EX: [2.3, 25, 230]</i></p>
            </div>

            <div class="group-field">
                <p><b>Number of bottles</b></p>
                <input class="input-style" type="text" id="Quantity-Bottles" name="Quantity-Bottles" placeholder="Enter Quantity for single, pack and box" />
                <p class="tooltip-info"><i>EX: [1, 12, 12*10]</i></p>
            </div>

            <div class="group-field">
                <input type="submit" value="Submit">
            </div>
        </fieldset>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $required_bottles = $_POST['Required-Bottles'];
        // $required_bottles = 1;
        // $prices_bottles = $_POST['Prices-Bottles'];
        $prices_bottles = '2.3,25,230';
        $prices_bottles =  explode(",", trim($prices_bottles));
        print_r($prices_bottles);

        // $quantity_bottles = $_POST['Quantity-Bottles'];
        $quantity_bottles = '1,12,120';
        $quantity_bottles =  explode(",", trim($quantity_bottles));
        print_r($quantity_bottles);

        $bottles = 0;
        $packs = 0;
        $boxes = 0;
        $n = 1;
        $remain = $required_bottles;
        while ($remain > 0) {
            // echo 'hi-a ' . $prices_bottles[1] . '<' . $remain * $prices_bottles[0];
            $final_price = ($bottles * 2.3) + ($packs * 25);
            echo $final_price . '=' . $remain . '>';
            if ($final_price > $prices_bottles[2]) {
                // if ($prices_bottles[2] < ($remain * $prices_bottles[1]) && $remain > 0) {
                echo 'hi-e';
                $remain = $remain - 120;
                $boxes++;
                $bottles = 0;
                $packs = 0;
                continue;
            }
            if ($prices_bottles[1] < ($remain * $prices_bottles[0]) && $remain > 0) {
                // echo 'hi-b';
                $remain = $remain - 12;
                $packs++;
                continue;
            }
            // echo 'hi-d';
            $remain = $remain - 1;
            $bottles++;
        }

        $final_price = ($bottles * 2.3) + ($packs * 25) + ($boxes * 230);
        echo '"bottles" : ' . $bottles . ',“packs”: ' . $packs . ',“Box”: ' . $boxes . ',"price" : ' . $final_price;
    }
    ?>
    <p>The coding challenge consists of two related tasks. The second task may not be solved without<br />solving the
        first task first. The second task's visual appearance can be wireframe quality Please,<br />tell us if both
        tasks required more than 3 hours to solve.</p>
    <p><br />Your work will not be used for any other purpose than this recruitment process. However, we do<br />suggest
        licensing your work with an Open Source license. We kindly ask you to agree not to<br />distribute this material
        without any prior written permission from us.</p>
    <p><br /><strong>Task 1.</strong> A bottle costs 2 euros 30 cents apiece. A pack of twelve bottles costs 25 euros. A
        box<br />of 10 packs - 230 euros. Write an API, containing a function (see below), that given a number
        of<br />bottles needed to calculate the number of bottles, packs and boxes. The program should<br />maximally
        save buyer&rsquo;s money.</p>
    <p><br />More specifically, the function must have the following signature:</p>
    <p><br /><span style="color: #ff6600;">calculate</span> ( <span style="color: #3366ff;">requiredBottles </span>,
        <span style="color: #3366ff;">prices</span> , <span style="color: #3366ff;">pieces</span> )
    </p>
    <p><br />where n is a minimally required number of bottles, prices is a list of prices for a bottle, a
        pack,<br />and a box, and pieces is a list of quantities of bottles in each package, for example: [1,
        12,<br />12*10]. The function must return a list of units in each package to satisfy the number of bottles.</p>
    <p><br />For example, api should take input in following format</p>
    <p><br />{<br />"requiredBottles" : 11,<br />"prices" : [2.3, 25, 230],<br />"pieces" : [1, 12, 12*10]<br />}</p>
    <p><br />and result of the above input is</p>
    <p><br />{<br />"bottles" : 0,,<br />&ldquo;packs&rdquo;: 1,<br />&ldquo;Box&rdquo;: 0,<br />"price" : 25<br />}</p>
    <p><br />Where [0, 1, 0] as a result of calculation will mean 0 individual bottles, 1 pack of bottles and
        0<br />boxes. And price is (0 + 25*1 + 0 = 25)</p>
    <p><br />Another example, api should take input in following format</p>
    <p><br />{<br />"requiredBottles" : 2,<br />"prices" : [2.3, 15, 1],<br />"pieces" : [1, 12, 12*10]<br />}</p>
    <p><br />and result of the above input is</p>
    <p><br />{<br />"bottles" : 0,<br />&ldquo;packs&rdquo;:0 ,<br />&ldquo;Box&rdquo;: 1,<br />"price" : 1<br />}</p>
    <p><br />Where [0, 0, 1] as a result of calculation will mean 0 individual bottles, 0 pack of bottles and
        1<br />box. And price is (0+0+1*1=1)<br />Choose preferably PHP (Laravel) or NodeJS or any programming language.
        It would be good if<br />you also consider writing Unit and Integration tests.</p>
</body>

</html>