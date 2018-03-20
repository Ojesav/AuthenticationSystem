{% extends 'templates/default.php' %}

{% block title %}{{ user.getFullNameorUsername() }}{% endblock %}

{% block content %}
    <h2>{{ user.username }}</h2>
    <img src="{{ user.getAvatarUrl({size:30}) }}" alt="profile pic">
    <dl>
    	{% if user.getFullName() %}
    		<dt>Full Name</dt>
    		<dd>{{ user.getFullName() }}</dd>
    	{% endif %}
    	<dt>Email</dt>
    	<dd>{{ user.email }}</dd>
    </dl>
{% endblock %}