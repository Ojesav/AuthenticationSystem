{% extends 'templates/default.php' %}

{% block title %}Recover Password{% endblock %}

{% block content %}
	<p>Enter Your Email address to start your password recover.</p>
  	<form action="{{ urlFor('password.recover.post') }}" method="post">
  		<div>
  			<label for="email">Email</label>
  			<input type="text" name="email" id="email"{% if request.post('email') %} value="{{ request.post('email') }}"{% endif %}>
  			{% if errors.first('email') %}{{ errors.first('email') }} {% endif %}
  		</div>
  		<div>
  			<input type="submit" value="Request Reset">
  		</div> 
  		<input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
  	</form>
{% endblock %}