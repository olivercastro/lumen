<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
session_start();
$app->get('/', function () use ($app) {
    $_SESSION['captcha'] = generateCaptCha();
    $capt = json_decode($_SESSION['captcha']);
    return view('base',['data' =>$capt, 'postpath' => route('postpath')]);
});

$app->post('/store',['as' => 'postpath',function() use($app){
    $request = $app->request;
    $captchaObj = json_decode($_SESSION['captcha'],true);
    if($captchaObj['a'] == $request->input('captcha')){
        DB::table('comments')->insert(
            [
                'firstname' => $request->input('fn'),
                'lastname'  => $request->input('ln'),
                'email'     => $request->input('email'),
                'comment'   => $request->input('comment')
            ]
        );
        return response()->json(['message' => 'Ok', 'status' => '200']);
    }else{
        return response()->json(['message' => 'Incorrect captcha', 'status' => '500']);
    }
}]);

$app->post('/generate', function() use($app){
    $_SESSION['captcha'] = generateCaptCha();
    return response($_SESSION['captcha'])->header('Content-Type','application/json');
});

function generateCaptCha(){
    $operatorArray = array('+','-','*');
    $operand1 = rand(0,9);
    $operator = rand(0,2);
    $operand2 = rand(0,9);
    $answer = 0;
    switch($operatorArray[$operator]){
        case '+':
            $answer = $operand1 + $operand2;
            break;
        case '-' :
            $answer = $operand1 - $operand2;
            break;
        case '*' :
            $answer = $operand1 * $operand2;
            break;
        case '/' :
            $answer = $operand1 / $operand2;
            break;
    }
    $captJson = json_encode(array(
        'a' => $answer,
        'opr' => $operatorArray[$operator],
        'op1'  => $operand1,
        'op2'   => $operand2
    ));
    return $captJson;
}