<?php

$app->get('/recover-password',$guest(),function() use ($app){
	$app->render('auth/password/recover.php');
})->name('password.recover');

$app->post('/recover-password',$guest(),function() use ($app){

	$request=$app->request;
	$email=$request->post('email');
	$v=$app->validation;
	$v->validate([
		'email'=>[$email,'required|email']
	]);

	if($v->passes())
	{
		$user=$app->user->where('email',$email)->first();
		if($user)
		{
			$identifier=$app->randomlib->generateString(128);
			$user->update([
				'recover_hash'=>$app->hash->hash($identifier)
			]);

			$to=$user->email;
			$subject='Requesting Password Reset';
			$body='You have requested password reset.Click the link for resetting password'.'http://localhost/authentication/public/password-reset?email='.$email.'&identifier='.$identifier;
			$headers = "From: webmaster@example.com" . "\r\n";
			mail($to,$subject,$body,$headers);

			$app->flash('global','Email has been send for password recovery');
			$app->response->redirect($app->urlFor('home'));
		}
		else{
			$app->flash('global','This email is not registered');
			$app->response->redirect($app->urlFor('password.recover'));
		}
	}

	$app->render('auth/password/recover.php',[
		'errors'=>$v->errors(),
		'request'=>$request
	]);
})->name('password.recover.post');