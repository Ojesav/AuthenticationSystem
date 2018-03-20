 <?php

use CodeCourse\User\UserPermission;

$app->get('/register',$guest(),function() use 
	($app) {
	$app->render('auth/register.php');
})->name('register');

$app->post('/register',$guest(),function() use 
	($app){
		$request=$app->request;
		$email=$request->post('email');
		$username=$request->post('username');
		$password=$request->post('password');
		$password_confirm=$request->post('password_confirm');

		$v=$app->validation;

		$v->validate([
			'email'=> [$email,'required|email|uniqueEmail'],
			'username'=> [$username,'required|alnumDash|max(20)|uniqueUsername'],
			'password'=>[$password,'required|min(6)'],
			'password_confirm'=> [$password_confirm,'required|matches(password)']
		]);

		if($v->passes()){

			$identifier=$app->randomlib->generateString(128);
			$user=$app->user->create([
			'email'=>$email,
			'username'=>$username,
			'passwd'=>$app->hash->password($password),
			'active'=>false,
			'active_hash'=>$app->hash->hash($identifier)

		]); 

		$user->permissions()->create(UserPermission::$defaults);

	 	$to=$user->email;
		$subject='Thanks For Registering';
		$body='You have been registered.Click the link for confirming registration'.'http://localhost/authentication/public/activate?email='.$email.'&identifier='.$identifier;
		$headers = "From: webmaster@example.com" . "\r\n";
		mail($to,$subject,$body,$headers);

		$app->flash('global','You have been registered.');
		$app->response->redirect($app->urlFor('home'));
		}
		
		$app->render('/auth/register.php',['errors'=> $v->errors(),
			   'request'=>$request,
	          ]); 		 
})->name('register.post');