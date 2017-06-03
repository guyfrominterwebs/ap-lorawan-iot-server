<?php

namespace Lora;

/**
	NOTE: Replace the contents of these functions with actual session management logic
	in order to restrict system access.
	
	Some changes to RequestHandler may be required in order to make these functions work 
	in a fluid manner.
*/
/**
	A function to contain login routine.
*/
function login () {
	return true;
}

/**
	A function to contain logout routine.
*/
function logout () {
}

/**
	A function for checking whether or not the user has an active session.
*/
function isLoggedIn ($session = null) { # Should take session information as parameter.
	getUser ();
	return true;
}

/**
	A function to determine whether or not the user should be allowed to access requested content.
	\TODO Should take user information as parameter.
*/
function allowAccess () {
	return true;
}

/**
	A function to return current user object performing the request.
	\return An instance of user.
*/
function getUser () {
	return \Lora\Database\User::dummy ();
}
