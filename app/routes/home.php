<?php

$app->get('/',function() use ($app){
   $app->render('home.php');
   //echo $app->randomlib->generateString(128);
   // echo 'hello';
})->name('home');