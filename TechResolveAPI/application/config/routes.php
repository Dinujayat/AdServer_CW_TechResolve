<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//  specifies the default controller to be loaded when no controller is specified in the URL.
$route['default_controller'] = 'welcome';

// specifies the controller/method to be called when a 404 (Page Not Found) error occurs. 
// If it's set to an empty string (''), CodeIgniter will handle the 404 error by displaying its default error page.
$route['404_override'] = '';

// determines whether CodeIgniter should auto-convert dashes in controller/method URLs. 
// If set to TRUE, dashes in the URL will be automatically converted to underscores when determining the controller and method to call. 
// If set to FALSE, dashes will not be converted.
$route['translate_uri_dashes'] = FALSE;

$route['abouts'] = 'welcome/demo';

// Login and Register for user and admin
$route['register']['POST'] = 'Auth/AuthenticationController/register';
$route['login']['POST'] = 'Auth/AuthenticationController/login';
$route['authenticate']['GET'] = 'Auth/AuthenticationController/isLoggedIn';
$route['logout']['GET'] = 'Auth/AuthenticationController/logout';
$route['isAdmin']['GET'] = 'Auth/AuthenticationController/isAdmin';

// for questions and answers
$route['questions']['GET'] = 'QueAns/QuestionController/allQuestions';
$route['postquestion']['POST'] = 'QueAns/QuestionController/postQuestion';
$route['deleteq']['POST'] = 'QueAns/QuestionController/removeQuestion';
$route['updateq']['POST'] = 'QueAns/QuestionController/updateQuestion';

$route['answer']['POST'] = 'QueAns/AnswerController/postAnswer';
$route['updateans']['POST'] = 'QueAns/AnswerController/editAnswer';
$route['deleteans']['POST'] = 'QueAns/AnswerController/removeAnswer';
$route['getanswer']['GET'] = 'QueAns/AnswerController/answerForQuestion';