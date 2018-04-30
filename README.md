Zerobounce Utility class
=========================

This package contains a general client, for creating requests and checking emails,
through the Zerobounce api. 

Environment variables needed to make the package work

- ZEROBOUNCE_DOMAIN = https://api.zerobounce.net/v1/
- ZEROBOUNCE_KEY = [your personal key]

General docs - https://docs.zerobounce.net/docs
To get api key(need personal login) - https://www.zerobounce.net/members/apikey/

Features
--------
**How to start**

- (new ZeroBounce())->email([custom email you want to check])->get();

if you call the get() method directly after setting the email you will get the direct response back from Zerobounce

**Full Check**

- (new ZeroBounce())->email([custom email you want to check])->full_check()->get();
- (new ZeroBounce())->email([custom email you want to check])->full_check()->trueOrFalse();

_returns:_

if everything goes through: 
get response - ['success' => true, 'message' => 'message from zerobounce']
boolean response - true

if something is not valid: 
get response - ['success' => false, 'message' => 'message from zerobounce']
boolean response - false

**Check if is the email is valid**

- (new ZeroBounce())->email([custom email you want to check])->isValid->get();
- (new ZeroBounce())->email([custom email you want to check])->isValid->trueOrFalse();

_returns:_

if everything goes through: 

- get response - ['success' => true, 'message' => 'message from zerobounce']
- boolean response - true

if something is not valid: 
- get response - ['success' => false, 'message' => 'message from zerobounce']
- boolean response - false

**Check if is the email is a toxic email**

- (new ZeroBounce())->email([custom email you want to check])->isToxic->get();
- (new ZeroBounce())->email([custom email you want to check])->isToxic->trueOrFalse();

_returns:_

if the email is registered as a toxic email: 

- get response - ['success' => true, 'message' => 'message from zerobounce']
- boolean response - true

if nothing is wrong: 

- get response - ['success' => false, 'message' => 'message from zerobounce']
- boolean response - false

**Check if is the email is a disposable email**

- (new ZeroBounce())->email([custom email you want to check])->isDisposable->get();
- (new ZeroBounce())->email([custom email you want to check])->isDisposable->trueOrFalse();

_returns:_

if the email is registered as a disposable email: 

- get response - ['success' => true, 'message' => 'message from zerobounce']
- boolean response - true

if nothing is wrong: 

- get response - ['success' => false, 'message' => 'message from zerobounce']
- boolean response - false

Notice 1
--------

if you are using any of the function available:

- isValid
- isDisposable
- isToxic
- full_check


Then you can either call get() or trueOrFalse()

get will always return an array with success and a message, while trueOrFalse will just return a boolean

Notice 2
--------

You can utilize chaining of the methods if you want to check something specific and all

_first:_

Initiate like this: 

- $zerobounce = (new ZeroBounce())->email([custom email you want to check]);

then you can check multiple functions, and get different results back instead of using calls to the Zerobounce api
a couple examples, could look like this: 

- $zerobounce->get();
- $zerobounce->isDisposable()->trueOrFalse();
- $zerobounce->isToxic()->trueOrFalse();


  













