<?php

$app->get('/activate',$guest(),function() use 
	($app){
		 $request=$app->request;
		 $email=$request->get('email');
		 $identifier=$request->get('identifier');
		 $hashedIdentifier=$app->hash->hash($identifier);
		 $user=$app->user->where('email',$email)->where('active',false)->first();
		 if($user&&$app->hash->hashCheck($user->active_hash,$hashedIdentifier)) {
		 	$user->activateAccount();
		 	$app->flash('global','Account was activated');
		 	$app->response->redirect($app->urlFor('home'));
		 }
		 $app->flash('global','There was a problem activating your account');
		 $app->response->redirect($app->urlFor('home'));
	})->name('activate');
