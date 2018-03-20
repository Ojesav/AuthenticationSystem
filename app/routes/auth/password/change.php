<?php

$app->get('/change-password',
	$authenticated(),function() use ($app){
	$app->render('auth/password/change.php');
})->name('password.change');


$app->post('/change-password',
	$authenticated(),function() use 
	($app){

		$request=$app->request;
		$passwordOld=$app->request->post('password_old');
		$password=$app->request->post('password');
		$passwordConfirm=$app->request->post('password_confirm');

		$v=$app->validation;
		$v->validate([
			'password_old'=>[$passwordOld,'required|matchesCurrentPassword'],
			'password'=>[$password,'required|min(6)'],
			'password_confirm'=>[$passwordConfirm,'required|matches(password)']
		]);

		if($v->passes())
		{
			$app->auth->update([
				'password'=>$app->hash->password($password)
			]);

			//send an email
			//Sending password has been changed
			$to=$user->email;
			$subject='Password Change';
			$body='Your Password has been changed.';
			$headers = "From: webmaster@example.com" . "\r\n";
			mail($to,$subject,$body,$headers);

			$app->flash('global','You Password has been Changed ');
			$app->response->redirect($app->urlFor('home'));
		}
		$app->render('auth/password/change.php',[
			 'errors'=>$v->errors()
		]);
})->name('password.change.post');