<?php
session_start();

//turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', TRUE);


//require autoload
require_once('vendor/autoload.php');
require_once('models/validation-functions.php');


//create and instance of the Base class
$f3 = Base::instance();

//array of colors
$f3->set('color', array('pink', 'green', 'blue'));


//turn on fat free error reporting
$f3->set('DEBUG', 3);

//define a default route
$f3->route('GET /', function () {
    echo '<h1>My Pets</h1>';
    echo '<a href="order">Order a pet</a>';
    //$view = new View;
    //echo $view->render('views/home.html');
});

$f3->route('GET /@animal', function ($f3, $params) {
    $sound = 'chirp';
    $_SESSION['sound'] = $sound;
    $validAnimals = ['dog', 'chicken', 'cat', 'tiger', 'cow'];
    $animal = $params['animal'];

    if (!inarray($animal, $validAnimals)) {
        $f3->error(404);

    } else {
        switch ($animal) {

            case 'dog':
                echo "<p>Woof!</p>";
                break;

            case 'chicken':
                echo "<p>Cluck!</p>";
                break;

            case 'cat':
                echo "<p>Meow!</p>";
                break;

            case 'tiger':
                echo "<p>Rawr!</p>";
                break;

            case 'cow':
                echo "<p>Moo!</p>";
                break;


        }
        $_SESSION['sound'] = $sound;
    }


});

$f3->route('GET|POST /order',

    function ($f3) {

        $_SESSION - array();

        if (isset($_POST['animal'])) {

            $animal = $_POST['animal'];

            if (validText($animal)) {

                $_SESSION['animal'] = $animal;

                $f3->reroute('/form2');

            } else {

                $f3->set("errors['animal']", "Please enter an animal.");
            }
        }
        $template = new Template();

        echo $template->render('views/form1.html');
    });


$f3->route('POST /form2', function () {

    $_SESSION["animal"] = $_POST['animal'];

    $template=  new Template();
    echo $template->render('views/form2.html');
});

$f3->route('GET|POST /results', function ($f3) {


    $_SESSION["color"] = $_POST['color'];
    $f3->set("animal", $_SESSION["animal"]);
    $f3->set("color", $_SESSION["color"]);
    $f3->set("sound", $_SESSION["sound"]);
    $template = new Template();
    echo $template->render('views/results.html');
});

//run fat free
$f3->run();