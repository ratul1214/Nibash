<?php
include './header.php';

//if (!$inSession) {
//    header("Location:index.php");
//}

$admin = FALSE;
$profileData = "SELECT * FROM users WHERE user_id='$s_id'";

$resultD = $conn->query($profileData);

if ($resultD->num_rows > 0) {
    $rowsD = $resultD->fetch_assoc();
    if ($rowsD['role'] == 1)
        $admin = TRUE;
}

$usrID = NULL;

function numberTowords($num) {
    $ones = array(
        1 => "one",
        2 => "two",
        3 => "three",
        4 => "four",
        5 => "five",
        6 => "six",
        7 => "seven",
        8 => "eight",
        9 => "nine",
        10 => "ten",
        11 => "eleven",
        12 => "twelve",
        13 => "thirteen",
        14 => "fourteen",
        15 => "fifteen",
        16 => "sixteen",
        17 => "seventeen",
        18 => "eighteen",
        19 => "nineteen"
    );
    $tens = array(
        1 => "ten",
        2 => "twenty",
        3 => "thirty",
        4 => "forty",
        5 => "fifty",
        6 => "sixty",
        7 => "seventy",
        8 => "eighty",
        9 => "ninety"
    );
    $hundreds = array(
        "hundred",
        "thousand",
        "million",
        "billion",
        "trillion",
        "quadrillion"
    ); //limit t quadrillion 
    $num = number_format($num, 2, ".", ",");
    $num_arr = explode(".", $num);
    $wholenum = $num_arr[0];
    $decnum = $num_arr[1];
    $whole_arr = array_reverse(explode(",", $wholenum));
    krsort($whole_arr);
    $rettxt = "";
    foreach ($whole_arr as $key => $i) {
        if ($i < 20) {
            $rettxt .= $ones[$i];
        } elseif ($i < 100) {
            $rettxt .= $tens[substr($i, 0, 1)];
            $rettxt .= " " . $ones[substr($i, 1, 1)];
        } else {
            $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
            $rettxt .= " " . $tens[substr($i, 1, 1)];
            $rettxt .= " " . $ones[substr($i, 2, 1)];
        }
        if ($key > 0) {
            $rettxt .= " " . $hundreds[$key] . " ";
        }
    }
    if ($decnum > 0) {
        $rettxt .= " and ";
        if ($decnum < 20) {
            $rettxt .= $ones[$decnum];
        } elseif ($decnum < 100) {
            $rettxt .= $tens[substr($decnum, 0, 1)];
            $rettxt .= " " . $ones[substr($decnum, 1, 1)];
        }
    }
    return $rettxt;
}
?>

<?php
if (isset($_GET['q1']) && isset($_GET['q2'])) {
    $_q1 = mysqli_real_escape_string($conn, $_GET['q1']);
    $_q2 = intval($_GET['q2']);
    $seletSql = "SELECT * FROM " . $_q1 . " WHERE id = '" . $_q2 . "'";
    //echo $seletSql;
}
?>


<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>EstateBD</title>
        <link rel="icon" type="image/png" href="./favicon.ico">
        <link type="text/css" href="./css/icon.css" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="./css/nouislider.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="./css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="./css/font-awesome.min.css"/>
        <link type="text/css" rel="stylesheet" href="./css/jquery.auto-complete.css" />
        <link type="text/css" rel="stylesheet" href="./css/style.css" />
        <link type="text/css" rel="stylesheet" href="./overrider.css" />
        <style>

            input[type]:not(.browser-default), input[type]:not(.browser-default):focus:not([readonly]){
                border-bottom: 1px solid #4a148c;
                box-shadow: 0 1px 0 0 #4a148c;
            }

            /* label color */
            .input-field label{
            }
            .input-field input[type]:focus + label.active {
                color: #4a148c;
            }
            /* label focus color */
            .input-field input[type=text]:focus + label {
                color: #4a148c;
            }
            /* label underline focus color */
            .input-field input[type=text]:focus {
                border-bottom: 1px solid #4a148c;
                box-shadow: 0 1px 0 0 #4a148c;
            }
            /*             valid color 
                        .input-field input[type=text].valid {
                            border-bottom: 1px solid #4a148c;
                            box-shadow: 0 1px 0 0 #4a148c;
                        }
                         invalid color 
                        .input-field input[type=text].invalid {
                            border-bottom: 1px solid #4a148c;
                            box-shadow: 0 1px 0 0 #4a148c;
                        }
                         icon prefix focus color 
                        .input-field .prefix.active {
                            color: #4a148c;
                        }*/

            label#srch, label#srch.active{
                color: #4a148c !important;
            }

            a.underlin{
                text-decoration: underline;
            }

            .brd-r{
                border-right: 2px solid #4a148c;
            }

            .brd-r-light{
                border-right: 2px solid #e040fb;
            }

            .brd-r-teal{
                border-right: 2px solid #26a69a;
            }

            @media only screen and (min-width: 470px){
                .modal {
                    width: 40%;
                }
            }


            #modalLog{
                max-height: 81%;
            }

            .checkbox-pruple[type="checkbox"].filled-in:checked + label:after{
                border: 2px solid #e040fb;
                background-color: #e040fb;
            }

            #map {
                width: 100%;
                height: 290px;
            }

            /* Only necessary for window height sized blocks */
            html, body, .block {
                height: 100%;
            }

            .topped {
                position: fixed;
                top: 0;
                left: 0;
                z-index: 999;
                width: 100%;
                height: 23px;
            }

            .topped-filters {
                top: 80px;
            }

            .topped-map {
                top: 167px;
                right: 0 !important;
            }

            .bgWhite{
                border-radius: 10px;
                background-color: #ffffff;
            }

            /*            .select-dropdown{
                            border-bottom: 1px solid #26a69a !important;
                            box-shadow: 0 1px 0 0 #26a69a !important;
                        }*/

            .noUi-target .range-label, .noUi-connect {
                background-color: #4a148c;
            }

            ul.dropdown-content.select-dropdown li span {
                color: #e040fb;
            }

            ul.dropdown-content.select-dropdown li.disabled span{
                color: rgba(0,0,0,0.3);
            }

            .card-eff{
                background: #fff;
                margin: 1rem;
                box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
            }

            #materialbox-overlay{
                opacity: 0.5 !important;
            }

            .carousel {
                height: 295px;
            }

            .carousel-item .active .material-placeholder .materialboxed{
                cursor: zoom-in;
            }

            #infoTabs{
                margin-top: -96px;
            }

        </style>
    </head>
    <body>

        <div class="page-wrap">
            <?php include './nav2.php'; ?>




            <div class="container-fluid">
                <div class="section">

                    <div class="row">

                        <div class="col l7 m7 s12 offset-l2">
                            <!--                            <h4 class="purple-text text-accent-2">Details</h4>-->
                            <?php
                            $result = $conn->query($seletSql);
                            if ($result->num_rows > 0) {
                                while ($rows = $result->fetch_assoc()) {
                                    $usrID = $rows['owner_id'];
                                    ?>
                                    <div class="card">
                                        <div class="card-image">
<!--                                            <div class="carousel">
                                                <?php
                                                $arrayImg = explode(',', $rows['img']);
                                                $i = 1;
                                                foreach ($arrayImg as $imgV) {
                                                    if ($imgV != '') {
                                                        ?>
                                                        <a class="carousel-item" href="#<?php echo numberTowords($i); ?>!"><img class="materialboxed" style="max-height: 640px; max-width: 960px;" src="./img/uploads/<?php echo trim($imgV); ?>"></a>
                                                        <?php
                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </div>

                                        </div>-->
                                        <div id="infoTabs" class="card-content">
                                            <ul class="collapsible popout" data-collapsible="expandable" data-collapsed="false">
<!--                                                <li>
                                                    <div class="collapsible-header active not-collapse"><i class="material-icons">place</i>Location</div>
                                                    <div class="collapsible-body"><span><?php echo $rows['area'] . ", " . $rows['district']; ?></span></div>
                                                </li>-->
                                                <li>
                                                    <div class="collapsible-header active not-collapse"><i class="material-icons">filter_drama</i>Details</div>
                                                    <div class="collapsible-body"><p><?php echo $rows['details']; ?>...</p>
                                                    </div>
                                                </li>
<!--                                                <li>
                                                    <div class="collapsible-header active not-collapse"><i class="material-icons">whatshot</i>Rent</div>
                                                    <div class="collapsible-body">
                                                        <span> 
                                                        <?php 
                                                        if($rows['price'] == 0){
                                                            echo "Contact For Price";
                                                        }else{
                                                            echo $rows['price'];
                                                        }
                                                        ?> 
                                                        </span>
                                                    </div>
                                                </li>-->
                                                <?php
                                                if ($admin || $s_id == $usrID) {
                                                    ?>
                                                    <li>
                                                        <div class="collapsible-header active not-collapse"><i class="material-icons">build</i>Actions</div>
                                                        <div class="collapsible-body">
                                                            <a id="" target="_blank" href="updateProp.php?q1=<?php echo $rows['type']; ?>&q2=<?php echo $rows['id']; ?>&q3=<?php echo $rows['owner_id']; ?>" class="waves-effect waves-grey btn white" style="color: initial;">Edit</a>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <a id="" href="deleteProp.php?q1=<?php echo $rows['type']; ?>&q2=<?php echo $rows['id']; ?>&q3=<?php echo $rows['owner_id']; ?>" class="waves-effect waves-grey btn red accent-2" style="color: initial;">Delete</a>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <!--                                <div class="card-action">
                                                                            <a href="#">This is a link</a>
                                                                        </div>-->
                                    </div>
                                    <?php
                                }
                                $propUsr = $conn->query('SELECT * FROM users WHERE user_id=' . $usrID);
                            }
                            ?>
                        </div>
                        <?php
                        if ($propUsr->num_rows > 0) {
                            $usr_rows = $propUsr->fetch_assoc();
                            ?>
                            <div class="col hide-on-small-only m3 l3 s12 topped topped-map">
                                <div class="card">
                                    <div class="card-image">
                                        <img style="max-height: 314.75px;" src="<?php
                                        if ($usr_rows['img'] != '') {
                                            echo trim($usr_rows['img']);
                                        } else {
                                            echo "img/uploads/default_159_8584217216.jpg";
                                        }
                                        ?>">
                                    </div>
                                    <div class="card-content">
                                        <h5>Owner Info</h5>
                                        <hr />
                                        <p>
                                            Name:&nbsp;
                                            <span style="text-transform: capitalize;">
                                                <?php echo $usr_rows['fname'] . ' ' . $usr_rows['lname']; ?>
                                            </span>
                                        </p>
                                        <p>
                                            Email:&nbsp;
                                            <span style="text-transform: capitalize;">
                                                <?php echo $usr_rows['mail']; ?>
                                            </span>
                                        </p>
                                        <p>
                                            Phone:&nbsp;
                                            <span style="text-transform: capitalize;">
                                                <?php echo $usr_rows['contact']; ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>

            </div>

        </div>
        <?php include './footer.php'; ?>


        <script type="text/javascript" src="./js/jquery.auto-complete.min.js"></script>
        <script type="text/javascript" src="./js/nouislider.js"></script>
        <script type="text/javascript" src="./js/init.js"></script>
        <script type="text/javascript" src="./overrider.js"></script>

        <script>

            (function ($) {
                $(function () {

                    $('.carousel').carousel();
                    $('.collapsible').collapsible();
                    $(".not-collapse").on("click", function (e) {
                        e.stopPropagation();
                    });
                    $('.materialboxed').materialbox();
                    $('select').material_select();
                    $('.dropdown-button').dropdown({
                        hover: true,
                        belowOrigin: true
                    });


                    $('#category').change(function () {

                    });

                    $('#district').change(function () {

                    });

                }); // end of document ready
            })(jQuery);

        </script>
    </body>
</html>

