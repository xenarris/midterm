<?php
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//start a session
session_start();

//Require autoload file
require_once('vendor/autoload.php');

//Create an instance of the base class
$f3 = Base::instance();

//Define a default route
$f3 -> route('GET /', function() {
    //display the homepage
    $view = new Template();
    echo $view->render('views/home.html');
}
);

//Define survey route
$f3 -> route('GET|POST /survey', function($f3) {
    //initialize variables
    $options = array("easy"=>"This Midterm is easy", "likable"=>"I like midterms", "monday"=>"Today is Monday");
    //set survey options
    $f3->set('survey', $options);


    //if post
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($_POST['name'] != "" || $_POST['name'] != null) {
            $_SESSION['name'] = $_POST['name'];
            $validName = true;
        }
        else {
            $validName = false;
            $f3->set('errors[name]', 'Name cannot be empty');
        }

        if (!empty($_POST['survey'])) {
            $_SESSION['survey'] = implode(", ", $_POST['survey']);
            $validSurvey = true;
        }
        else {
            $validSurvey = false;
            $f3->set('errors[opt]', 'Please select at least one option!');
        }

        if ($validName && $validSurvey) {
            header('location: summary');
        }

    }


    //display the homepage
    $view = new Template();
    echo $view->render('views/survey.html');
}
);

//Define Summary route
$f3 -> route('GET /summary', function () {
    $view = new Template();
    echo $view -> render('views/summary.html');
});

//Run fat free
$f3->run();