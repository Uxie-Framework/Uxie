# What is Uxie:  
Uxie is a PHP MVC Framework.  

# Features:
#### - Perfect MVC environment.
#### - Security (secured against SQL injection, XSS, CSRF).
#### - IOC (injection of control) Container.
#### - Global Container:
#### - Routing.
#### - Middlewares.
#### - Mutual Templating Engine (Blade & Pug):
#### - Ready to use Model.
#### - Visitors Statistics Recorder.
#### - Request handler & validator.
#### - Automatic Exception handling.
#### - Errors / Exceptions logger.
#### - Helper functions.

# Documentation:  

## Routing:
`web/Routes.php`

### Basic route `get`:
```php
$this->get('', function() {
  view('index');
});
// passing variables
$this->get('user/{$name}', function($name) {
  view('welcom', ['name' => $name]);
});
```
### Execute methods from a controller:
```php
$this->post('test', 'Controller@method');
```

### Resource method which contains: (index, create, store, show, edit, update and delete) same as [Laravel](https://github.com/laravel/framework/blob/5.5/src/Illuminate/Routing/Router.php#L294).  
```php
$this->resource('user', 'UserController');
```
### Add a collection of routes with a prefix:
```php
$this->group('user', function() {
    $this->get('profile', function() {
        echo 'Profile';
    });
    $this->post('user/store', 'Controller@method');
});
```  
### Passing data via URL:
in routes file :
```php
$this->get('profile/{$name}/{$email}', 'Controller@method');
```
in Controller : 
```php
public function method($name, $email)
{
    echo $name;
    echo $email;
}
```

### passing data via Post request:
in routes file :
```php
 $this->post('user/store', 'UserController@store');
```
in UserController.php :
```php
...
use App\Http\Request as Request;
...
public function store(Request $request)
{
  $name = $request->name;
  // equivalent to $_POST['name'];
}
```
## Middlewares:
to use middlewares you need to add middleware() method to your route call
example: 
```php
$this->get('profile/user', 'controller@show')->middleware('MiddlewereTest');
```
All middlewares are defined in Middlewares folder.

Once a middleware is called the application will excute start method in the middleware.

A middleware must contain a static method 'start':
```php
namespace Middleware;

class Middlewaretest
{
    public static function start()
    {
        echo 'test middleware';
    }
}
```

#### Middleware collections & short names:

To add a collection of middlewares or a short-name to a route you must define the collection in App/MiddlewaresProviders.php:
```php
private $middlewaresProvider = [
        'auth' => 'authenticateUsers',
        'collection' => [
            'myMiddleware',
            'TestMiddleware',
            'OtherMiddleware',
        ];
    ];
```
To use collections and short names:
```php
// 'auth' short name example:
$this->get('user', 'controller@method')->middleware('auth');

// 'collection' example:
$this->get('link', 'controller@method')->middleware('collection');
```

## Mutual Templating Engine (Blade & Pug):

#### Important Notes:
- All view must be inside Views folder.

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
to use it:
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

### Service Provider:
service provider is a trait with ```App``` wich contain class short-names to make di-container easier to use:

```php
trait ServiceProvider
{
    private $serviceProviders = [
        'Router'     => \Router\Router::class,
        'Kernel'     => \Kernel\Kernel::class,
        'Launcher'   => \Kernel\Launcher::class,
        'Middleware' => \App\Middleware\Middleware::class,
        'Dotenv'     => \Dotenv\Dotenv::class,
        'Blade'      => \Jenssegers\Blade\Blade::class,
        'Pug'        => \Pug\Pug::class,
    ];
}
```

### The global $container:
the ```$container ```variable is global in the framework (can be used every where, it contains all the objects created by the container, 
this way you will be able to create an object once and use it many times

```php
global $container;
$container->build('someclass');
$container->get('someClass')->someMethod();
```

## Uxie Model:
how to use it:
```php
use Model/Model;
```
Insert data:
```php
Model\table::insert(['column1', 'column2'], [value1, value2])->save();
```
Retrieve data:  
```php
$data = Model\table::select()->where('name', '=', 'user')->limit(10)->get();
```
Retrieve single row:
```php
$user = Model\table::find('name', 'MyName');
```
And plenty of other methods such as limit, orderBy, groupBy, count, update and delete.
simple example:
```php
Model\table::select()->where('name', '=', 'user')->or('name', '=', 'other-user')->orderBy('date')->get();
```

## Visitors Statistics:
It's a built-in middleware that record each user hits and data and store them in a database table;
Data such as ip, browser, os, PreviousUrl, CurrentUrl, date.

## Request handler & validator:
It's a built-in handler a validator for `POST` inputs:

```php
// you must add 'csrf_field()' to the HTML form to protect against CSRF
public function store(Request $request)
{
  echo $request->name;  
}
```

### Validation:
Available validation methods : required(), length($min, $max), email(), isip(), isint(), isfloat(), url().
To validate POST inputs:
```php
public function store(Request $request)
{
  $errors[] = $request->validate($request->name, 'Name Field')->required()->length(10, 30)->getErrors();
  $errors[] = $request->validate($request->email, 'Your Email')->required()->length(5, 40)->email()->getErrors();
}
```
the above example will return error messages in this form:
```php
[
    [
        'Name Field Length must be bettwen 10 and 30',
        'Name Field is Required',
    ]
    [
        'Your Email is not a valid email',
        'Your Email Length must be bettwen 5 and 40',
    ]
]
```
All Error messages teamplates are defined in 'App\Validation Errors.php' to make theme so easy to modify.

## Exception handler:
`Uxie` comes with a built-in exceptions automatic handler that will handle thrown exceptions / errors automatically.  

## Errors logger:
All errors/exceptions thrown during runtime will be logged in `log/All_errors.log` with information about error such as file, line, code and error-Message.  

## Helpers:
Helpers are functions available to use everywhere inside the framework such as `view()`, `session()`, `redirect()`, `route()`, `url()`.  
All function are listed in `App/helpers`.

examples: 
```php
url('profile/user'); 
// returns http(s)://domain.com/profile/user

route('profile/user');
// redirect to http(s)://domain.com/profile/user

redirect('https://google.com');
// redirects to url entred (google.com)

view('my-view', ['variable' => $variable, 'name' => 'amine']);
// show a view with passed variables

session('id');
// returns $_SESSION['id']

session('id', '87669');
// set new session ( $_SESSION['id'] = '87669'

unsetSession('id');
// delete session

cookie('name', 'amine', time()+3600);
// set new cookie

cookie('name', 'amine');
//set new cookie without-time

cookie('name');
// returns cookie $_COOKIE['name'];

csrf_field();
// echo something like this <input type='hidden' name='_token' value='l2465431sd534sd'>

container();
// returns the global IOC container
```
