{% extends 'templates/default.php' %}

{% block title %}Reset Your Password{% endblock %}

{% block content %}
    <form action="{{ urlFor('Password.reset.post') }}?email={{ email }}&identifier={{ identifier|url_encode }}" method="post">
    	<div>
  			<label for="password">Password</label>
  			<input type="password" name="password" id="password">
  			{% if errors.first('password') %}{{ errors.first('password') }} {% endif %}
  		</div>
  		<div>
  			<label for="password_confirm">Confirm Password</label>
  			<input type="password" name="password_confirm" id="password_confirm">
  			{% if errors.first('password_confirm') %}{{ errors.first('password_confirm') }} {% endif %}
  		</div>
  		<div>
  			<input type="submit" value="Request Reset">
  		</div> 
  		<input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
    </form>
{% endblock %}