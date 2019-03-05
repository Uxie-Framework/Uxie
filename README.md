# What is Uxie:  
Uxie is a PHP MVC Framework.  

# Features:
#### - Perfect MVC environment.
#### - Box (Command Line Tool).
#### - Deployable with docker.
#### - DataBase Migration (phinx).
#### - Security (secured against SQL injection, XSS, CSRF).
#### - IOC (Inversion of control) Container.
#### - Router (REST).
#### - Authentication.
#### - Middlewares.
#### - Mutual Templating Engines (Blade & Pug):
#### - ORM Model.
#### - Visitors Data Recorder.
#### - Request handler & validator.
#### - Automatic Exception handling.
#### - Errors / Exceptions logger.
#### - Built-in functions (Helpers).
#### - Multi langauge support.

# Documentation:  

## Installing:

Using Composer:
```
  composer create-project uxie/uxie <path>
```
Using Docker:
```
  Docker-compose up --build
```
## Routing:
All routes are defined in : `App/Routes.php`

#### Available Methods:
GET, POST, PUT, PATCH, DELETE

To use PUT, PATCH, DELETE methods your form method must be 'POST'
inside the form you must put `csrf_method()`:
```php
<input type='hidden' name='_method' value="PUT'>
```
csrf_method('PUT') will echo this automatically.

#### Basic routes examples:
```php
$route->any('/', function(Request $request, Response $response) {
  $response->view('index');
});

$route->get('/', function(Request $request, Response $response) {
  $response->view('index');
});
// passing variables
$route->get('user/{$name}', function(Request $request, Response $response) {
  $response->view('welcom', ['name' => $request->params->name]);
});

$route->put('update', 'Controller@update');

$route->patch('update', 'Controller@update');

$route->delete('delete', 'Controller@delete');

// the default method will execute when no route could be matched
$route->default(function (Request $request, Response $response) {
  $response->view('index');
});
```
## Request & Response Objects :
The request and response object are assigned to all functions, controllers, middlewares and services automatically (by default),

### Request Object :
The request object holds all data about the recieved http request.
##### Request methods :

```php
$request->url()                         // return the full url
$request->path()                        // return the request path
$request->cookie(string $name): string  // get cookie value
$request->session(string $name): string // get session value
$request->ip(): string                  // get the request ip
$request->method(): string              // get method type
$request->validat(string $input, string $field): Validate // return validate object to validate input

##### Request arguments:

// params contain data passed by url
// example
// localhost/{$name}
echo $request->params->name;
// body contain data passed by POST request
echo $request->body->name
```
### Response Object :

$response->write(string $text): void                       // add text to response
$response->status(int $status): void                       // set response status
$response->json(array $array, int $options = null): void   // add json data to the response body
$response->send(): void                                    // send response
$response->end(): void                                     // end response
$response->exception(string $message, int $code)           // throw exception
$response->view(string $view): string                      // render a view
$response->cookie(string $name, string $value, string $date): void // set cookie
$response->unsetCookie(string $name): void                 // unset a cookie
$response->unsetAllCookies(): void                         // unset all cookies
$response->session(string $name, string $value): void      // set a session
$response->unsetSession(string $name): void                // unset a session
$response->unsetAllsessions(): void                        // unset all sessions
$response->back(): void                                    // redircect back to the previous url
$response->refresh(): void                                 // refresh current url
$response->redirect(string $url): void                     // redirect to a given url

### Using a front-end SPA framework:
if you are using uxie with a front-end framework you will need to return always the same html file
to do this in uxie you can use the default method:
```php

// this method will be used in case no other route could be matched
$route->default(function (Request $request, Response $response) {
  $response->view('index');
});
```
#### Execute methods from a controller:
```php
$route->post('test', 'Controller@method');
```

#### Resource method which contains: (index, create, store, show, edit, update and delete) same as [Laravel](https://github.com/laravel/framework/blob/5.5/src/Illuminate/Routing/Router.php#L294).  
```php
$route->resource('user', 'UserController');
```
#### Add a collection of routes with a prefix:
```php
$route->group('user', function($route) {
    $route->get('profile', function(Request $request, Response $response) {
        $response->write('Hello!')->send();
    });
    $route->post('store', 'Controller@method');
});
```
#### URL parameters :
:
in routes file :
```php
$route->get('profile/{$name}/update', 'Controller@update');
```
in Controller :
```php
public function update(Request $request, Response $response)
{
    $response->write($request->params->name)->send();
}
```

#### How to use $_POST values (this can apply to PUT PATCH DELETE methods also):
in routes file :
```php
 $route->post('user/store', 'UserController@store');
```
in UserController.php :
```php
public function store(Request $request, Response $response)
{
  $name = $request->body->name;
  // equivalent to $_POST['name'];
}
```
## Authentication:
Authentication will validate your users login automatically
#### Login:
```php
  use Authenticator\Auth;

  if (Auth::attempt(['table', 'name' => $inputName, 'password' => $inputPassword)) {
    // logged in
  }

  // in case of second field required to validate for example e-mail & user-name:

  if (Auth::attempt(['table', 'name' => $inputName, 'password' => $inputPassword, 'email' => $inputEmail])) {
    // logged in
  }
```
#### Check if user loged in:
```php
  if (Auth::check())
  {
    // user is logged-in
  }
  // in case you want to check a user value from database row:

  if (Auth::check(['name' => 'someone'])
  {
    echo "i'm someone";
  }
```
#### Logout a user:
```php
  Auth::logout();
```

#### Hashing:
you need to hash a password before storing it in database
```php
  $password = Auth::hash($password);
```
#### User data:
To access user data stored in database for example age, email or anything else :
```php
  $email = Auth::user()->email;
```

## Middlewares
to use middlewares you need to add middleware() method to your route call
example:

```php
$route->get('profile/user', 'controller@show')->middleware('MiddlewereTest');
```
you can add a late middleware just add true argument to middleware() method:
(a late middleware is executed at the end of the application)
```php
  $route->get('profile', 'controller@index')->middleware('MiddlewareTest, true);
```
All middlewares are defined in './Middlewares' folder.



A middleware must contain a construct method:
```php
namespace Middleware;

class Middlewaretest
{
    public function __construct(Request $request, Response $response)
    {
        $response->write('this is a middleware');
    }
}
```

#### Middlewares locators:

To use Middlewares and short names you must first register the shortname in App/MiddlewaresLocator:
```php
return [
    'statistics' => \Middleware\Statistics::class,
];

```
#### How To assign a middleware to a route
```php
// 'statistics' short name example:
$route->get('user', 'controller@method')->middleware('statistics');

## Security ( against SQL injection, XSS, CSRF):

#### SQL injection:
Uxie is secured against both first and second order sql injection attacks.

#### XSS:
Both Uxie templating engines (Blade + Pug) escape html+js when printing data.

#### CSRF:
Uxie comes with built in feature that protect against CSRF when using ('POST','PATCH','PUT','DELETE') methods,
So every form should contain: csrf_field()

```php
    <form ...>
        csrf_file();
        <input ...>
    </form>
```

## Mutual Templating Engine (Blade & Pug):

#### Important Notes:
- All views must be inside 'App/Views' folder.

#### How to use it:
Use helper function view(string $view, array $variables):  
```php
view('YourView', ['data' => $data, 'name' => 'MyName']);

// To use Pug view use:
pugView(string $view, array $data);

// to use Blade view use:
bladeView(string $view, array $data);
```
#### How to Chose wich Templating engine to use:
To change Templating engine you should edit .env file
```
Engine = Blade
# or
Engine = Pug
```

## IOC Container:
uxie comes with a IOC container that resolves all of your classes dependencies and their dependencies and so on
to use it :
```php

// instead of this:
$myClass = new \Namespace\MyClass( new Class1(), new Class2( new Class3()));

// you can use this:
$myClass = container()->build('\Namespace\MyClass');

// if you have some arguments
// instead of this:
$myClass = new \Namespace\MyClass('argument1', 'argument2');

// use this
container()->build('\Namespace\Myclass', ['argument1', 'argument2']);

container()->get('MyClass')->someMethod();
// or this:
contaienr()->MyClass->someMethod();
```

#### IOC Service Provider:

Service provider located in ```App/Services.php```
It contains aliases and sevices that should be loaded when the application start:

```php
        'ServiceLocators' => [
            'Router'     => \Router\Router::class,
            'Kernel'     => \Kernel\Kernel::class,
            'Compiler'   => \Kernel\Compiler\Compiler::class,
            'Middleware' => \App\Middleware\Middleware::class,
            'Dotenv'     => \Dotenv\Dotenv::class,
            'Auth'       => \Authenticator\Auth::class,
        ],

        'ServiceProviders' => [
            Jenssegers\Blade\Blade::class,
        ],
```


#### The global $container:

the ```container()```function is global in the framework (can be used everywhere, it contains all the objects created by the IOC container),



```php
// create an instance
container()->build('someclass');

// access created instance
container()->someClass->someMethod();

```

## Uxie Model:
how to use it:
```php
use Model/Model;
```
Insert data:
```php
Model\table::insert([
  'value1' => $value1,
  'value2' => $value2,
])->save();
```
Retrieve data:  
```php
$data = Model\table::select()->where('name', '=', 'user')->limit(10)->get();
```
Retrieve single row:
```php
$user = Model\table::find('name', 'MyName');
```
Soft delete :
by default uxie migration add a softdelete column to the table
softdelete method will change the value of softdelete column
NOTE: select won't return any soft deleted rows
```php
  Model\table::delete()->where('id' , '=', $id)->save();
```
to hard delete a row use hardDelete method.
plenty of other methods such as limit(), orderBy(), groupBy(), count(), join, update and delete.
simple example:
```php
Model\table::select()->where('name', '=', 'user')->or('name', '=', 'other-user')->orderBy('date')->get();
```

## Visitors Statistics:
It's a built-in middleware that record each user data and store it in a database table,
Data such as ip, browser, os, PreviousUrl, CurrentUrl, date, and memory usage


#### Validation:
Available validation methods :
required(), length($min, $max), email(), isip(), isint(), isfloat(), url(), unique($model, $column), equals($input, $value)
To validate POST inputs:
```php
public function store(Request $request, Response $response)
{
  $request->validate($request->body->name, 'Name Field')->required()->length(10, 30);
  $request->validate($request->body->email, 'Your Email')->required()->length(5, 40)->email();
  var_dump($request->getErrors());
}
```
the above example will return error messages in this form:
```php
[
    [
        'Name Field Length must be bettwen 10 and 30',
        'Name Field is Required',
        'Your Email is not a valid email',
        'Your Email Length must be bettwen 5 and 40',
    ]
]
```
All Error messages teamplates are defined in multiple 'resources/languages/validation.php' to make theme so easy to modify.

## Exception handler:
`Uxie` comes with a built-in exceptions handler that will handle thrown exceptions / errors automatically.  

## Errors logger:
All errors/exceptions thrown during runtime will be logged in `log/All_errors.log` with information about error such as file, line, code and error-Message.  

## Helpers:
Helpers are functions available to use everywhere inside the framework such as `csrf_field()`, `csrf_token()`, `container()`.  
All function are listed in `framework/helpers/helpers.php`.

examples:
```php

csrf_field();
// echo something like this <input type='hidden' name='_token' value='l2465431sd534sd'>

csrf_token();
// returns csrf token value

method_field(string $method);
// echo something like <input type='hidden' name='_method' value="$method'>

container();
// returns the global IOC container
```

## Box (Command Line Tool):
Box is a command line tool to create Controllers, models & middlewares templates
for example:

```
// to create a controller:
php box Controller TestC

// to create resourceful controller
php box Controller TestC -r

// to create a Model
php box Model TestC

// to create a Middleware
php box Middleware TestC
```

## DataBase Migration:
All migration files located in '/Migrations'

It's based on phinx migration to create a migration pass this command:
```
php phinx create MyMigration
```
To Migrate existing migration files:

```
php phinx migrate
```

## Multi langauge support

- All languages files in 'resources/languages'
- By default uxie language is 'en' which means english
#### How to modify and add languages :
for example to edit validation messages you need to modify 'resources/languages/validations.php' ($$ represent the field name):
```php
    'english' => [
        'length'   => '$$ Length must be bettwen $$ and $$',
        'required' => '$$ Is Required',
        'email'    => '$$ Must be a valide Email',
        'url'      => '$$ Must be a valide URL',
        'isint'    => '$$ Must be of type integer',
        'isfloat'  => '$$ Must be of type float',
        'isip'     => '$$ Must be a valide IP',
    ],

    'francais' => [
        'length'   => '$$ Doit etre entre $$ et $$',
        'required' => '$$ Est un Champ obligatoire',
        'email'    => '$$ Doit etre un e-mail',
        'url'      => '$$ Doit etre un URL valide',
        'isint'    => '$$ Doit etre de type entier',
        'isfloat'  => '$$ Doit etre de type float',
        'isip'     => '$$ Doit etre un IP valide',
    ],
```
#### How to set & get teh current language :
Uxie default language is 'english'
To set a language use 'langauge(string $lang)' function
example:
```php
  // this will set language to 'francais'
  langauge('francais')
```

To get current language just use 'language()'
```php
  echo language();
  // should echo 'english'
```
#### how to use translation :
use translation(string $langFile) to get a language file content ($langFile is the file inside resources/langauges folder
example:
```php
    $translation = translation('Validations');
    var_dump($translation);
    // this should dispaly an array:
    // 'english'  => [ ....],
    // 'francais' => [ ....]
```
