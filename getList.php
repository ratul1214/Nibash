<?php

include './dbConnect.php';
$selectSql = '';
$_q1 = mysqli_real_escape_string($conn, $_GET['q1']);
$_q2 = mysqli_real_escape_string($conn, $_GET['q2']);
$_q3 = mysqli_real_escape_string($conn, $_GET['q3']);
$_q4 = intval($_GET['q4']);
$_q5 = intval($_GET['q5']);
$_q6 = intval($_GET['q6']);
$_q7 = intval($_GET['q7']);
$_q8 = intval($_GET['q8']);

$_ord = "id";
$orderBy = " ORDER BY " . $_ord;

$limit = " LIMIT 10";
if (isset($_GET['l'])) {
    $_l = intval($_GET['l']);
    if ($_l > 0) {
        $limit = " LIMIT " . $_l . ", 10";
    }
}

function execT($Sql, $con, $_t) {

    $result = $con->query($Sql);

    if ($result->num_rows > 0) {
        while ($rows = $result->fetch_assoc()) {
            if (!($rows['location'] == "")) {
                $latlng = explode(',', $rows['location']);
                echo "<div class='card horizontal hoverable lItem' data-lat='" . trim($latlng[0]) . "' data-lng='" . trim($latlng[1]) . "' data-price='" . $rows['price'] . "' data-addr='" . $rows['fullAddress'] . "'>";
            } else {
                echo "<div class='card horizontal hoverable'>";
            }
            echo "<div class='card-image col s3' style='padding-left: 0;'>";
            echo "<img class='responsive-img' src='./img/uploads/post_640-1.jpg'>";
            echo "</div>";
            echo "<div class='card-stacked s9'>";
            echo "<div class='card-content'>";
            echo "<p class=''>Property Type: " . $rows['type'] . "</p>";
            echo "<p class=''>Location: " . $rows['area'] . ", " . $rows['district'] . "</p>";
            if ($rows['price'] == 0) {
                echo "<p class=''>Rent per month: " . "Contact For Price" . "</p>";
            } else {
                echo "<p class=''>Rent per month: " . $rows['price'] . " TK</p>";
            }
            echo "<p class=''>Free From: " . $rows['available_from'] . "</p>";
            echo "</div>";
            echo "<div class='card-action'>";
            echo "<a href='propDetails.php?q1=" . $rows['type'] . "&q2=" . $rows['id'] . "' class='' target='_blank'><i class='fa fa-lg fa-external-link' aria-hidden='true'></i>&nbsp;&nbsp;Details</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    }
}

if ($_q1 == "null" || $_q1 == "") {

    //*** apartment ***//
    $_q1 = "apartment";
    $selectSql = "SELECT * FROM " . $_q1 . " WHERE price >= " . $_q4 . " AND price <= " . $_q5;
    $selectSql = $selectSql . $orderBy . $limit;
    execT($selectSql, $conn, $_q1);

    //*** house ***//
    $_q1 = "house";
    $selectSql = "SELECT * FROM " . $_q1 . " WHERE price >= " . $_q4 . " AND price <= " . $_q5;
    $selectSql = $selectSql . $orderBy . $limit;
    execT($selectSql, $conn, $_q1);

    //*** office ***//
    $_q1 = "office";
    $selectSql = "SELECT * FROM " . $_q1 . " WHERE price >= " . $_q4 . " AND price <= " . $_q5;
    $selectSql = $selectSql . $orderBy . $limit;
    execT($selectSql, $conn, $_q1);

    //*** shop ***//
    $_q1 = "shop";
    $selectSql = "SELECT * FROM " . $_q1 . " WHERE price >= " . $_q4 . " AND price <= " . $_q5;
    $selectSql = $selectSql . $orderBy . $limit;
    execT($selectSql, $conn, $_q1);
} else {

    if ($_q2 == "null" || $_q2 == "") {// if no district
        $selectSql = "SELECT * FROM " . $_q1 . " WHERE price >= " . $_q4 . " AND price <= " . $_q5;
    } else {
        if ($_q3 == "null" || $_q3 == "") {// if no area
            $selectSql = "SELECT * FROM " . $_q1 . " WHERE district = '" . $_q2 . "' AND price >= " . $_q4 . " AND price <= " . $_q5;
        } else {
            $selectSql = "SELECT * FROM " . $_q1 . " WHERE district = '" . $_q2 . "' AND area = '" . $_q3 . "' AND price >= " . $_q4 . " AND price <= " . $_q5;
        }
    }

    if ($_q1 == "apartment") {
        if (!($_q6 == "null" || $_q6 == "")) {
            $beds = " AND beds =" . $_q6;
            $selectSql = $selectSql . $beds;
        }
        if (!($_q7 == "null" || $_q7 == "")) {
            $baths = " AND baths =" . $_q7;
            $selectSql = $selectSql . $baths;
        }
        if (!($_q8 == "null" || $_q8 == "")) {
            $park = " AND park =" . $_q8;
            $selectSql = $selectSql . $park;
        }
    }

    if ($_q1 == "house") {
        if (!($_q6 == "null" || $_q6 == "")) {
            $floor = " AND floor =" . $_q6;
            $selectSql = $selectSql . $floor;
        }
        if (!($_q7 == "null" || $_q7 == "")) {
            $lifts = " AND lifts =" . $_q7;
            $selectSql = $selectSql . $lifts;
        }
        if (!($_q8 == "null" || $_q8 == "")) {
            $park = " AND park =" . $_q8;
            $selectSql = $selectSql . $park;
        }
    }

    if ($_q1 == "office") {
        if (!($_q6 == "null" || $_q6 == "")) {
            $lifts = " AND lifts =" . $_q6;
            $selectSql = $selectSql . $lifts;
        }
        if (!($_q7 == "null" || $_q7 == "")) {
            $baths = " AND baths =" . $_q7;
            $selectSql = $selectSql . $baths;
        }
        if (!($_q8 == "null" || $_q8 == "")) {
            $rooms = " AND rooms =" . $_q8;
            $selectSql = $selectSql . $rooms;
        }
    }

    if ($_q1 == "shop") {
        if (!($_q6 == "null" || $_q6 == "")) {
            $beds = " AND floor =" . $_q6;
            $selectSql = $selectSql . $beds;
        }
//        if (!($_q7 == "null" || $_q7 == "")) {
//            $baths = " AND baths =" . $_q7;
//            $selectSql = $selectSql . $baths;
//        }
//        if (!($_q8 == "null" || $_q8 == "")) {
//            $park = " AND park =" . $_q8;
//            $selectSql = $selectSql . $park;
//        }
    }

    $selectSql = $selectSql . $orderBy . $limit;
    execT($selectSql, $conn, $_q1);
}

echo $_q1 . ", " . $_q2 . ", " . $_q3 . ", " . $_q4 . ", " . $_q5 . ", " . $_q6 . ", " . $_q7 . ", " . $_q8 . "<br />";
echo $selectSql . "<br />";



mysqli_close($conn);
