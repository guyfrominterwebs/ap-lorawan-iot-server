<?php

/*
	NOTE: Replace the contents of these functions with actual session management logic
	in order to restrict system access.
*/
namespace Lora;

function login () {
	return true;
}

function logout () {
}

function isLoggedIn ($session = null) { # Should take session information as parameter.
	getUser ();
	return true;
}

function allowAccess () { # Should take user information as parameter.
	return true;
}

function getUser () {
	return User::Dummy ();
}
