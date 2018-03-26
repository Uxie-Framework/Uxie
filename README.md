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
#### - Multi langauge support

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
inside the form you must put:
```<input type='hidden' name='_method' value="PUT'>```
csrf_method('PUT') will echo this automatically.

#### Basic routes examples:
```php
$this->get('', function() {
  view('index');
});
// passing variables
$this->get('user/{$name}', function($name) {
  view('welcom', ['name' => $name]);
});

$this->put('update', Controller@update);

$this->patch('update', Controller@update);

$this->delete('delete', Controller@delete');
```
#### Execute methods from a controller:
```php
$this->post('test', 'Controller@method');
```

#### Resource method which contains: (index, create, store, show, edit, update and delete) same as [Laravel](https://github.com/laravel/framework/blob/5.5/src/Illuminate/Routing/Router.php#L294).  
```php
$this->resource('user', 'UserController');
```
#### Add a collection of routes with a prefix:
```php
$this->group('user', function() {
    $this->get('profile', function() {
        echo 'Profile';
    });
    $this->post('store', 'Controller@method');
});
```  
#### Passing data via URL:
in routes file :
```php
$this->get('profile/{$name}/update', 'Controller@update');
```
in Controller :
```php
public function update($name)
{
    echo $name;
}
```

#### How to use $_POST values (this can apply to PUT PATCH DELETE methods also):
in routes file :
```php
 $this->post('user/store', 'UserController@store');
```
in UserController.php :
```php
...
use Request\Request as Request;
...
public function store(Request $request)
{
  $name = $request->name;
  // equivalent to $_POST['name'];
}
```
## Authentication:
Authentication will validate your users login automatically
#### Login:
```php
  use Authenticator\Auth;

  if (Auth::attempt(['table', 'name' => $inputName, 'password' => $inputPassword)) {
    echo 'success';
  }

  // in case of second field required to validate for example e-mail & user-name:

  if (Auth::attempt(['table', 'name' => $inputName, 'password' => $inputPassword, 'email' => $inputEmail])) {
    echo 'success';
  }
```
#### Check if user loged in:
```php
  if (Auth::check())
  {
    echo 'success';
  }
  // in case you want to check a user value from database row:

  if (Auth::check(['name' => 'someone'])
  {
    echo " i'm someone";
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
$this->get('profile/user', 'controller@show')->middleware('MiddlewereTest');
```
you can add a late middleware just add true argument to middleware() method:
```php
  $this->get('profile', 'controller@index')->middleware('MiddlewareTest, true);
```
All middlewares are defined in './Middlewares' folder.



A middleware must contain a construct method:
```php
namespace Middleware;

class Middlewaretest
{
    public function __construct()
    {
        echo 'test middleware';
    }
}
```

#### Middleware collections & short names:

To add a collection of middlewares or a short-name to a route you must define the collection in 'App/ServiceProviders/MiddlewaresProviders.php':
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
## Security ( against SQL injection, XSS, CSRF):

#### SQL injection:
Uxie is secured against both first and second order sql injection attacks.

#### XSS:
Both Uxie templating engine escape html+js when printing data.

#### CSRF:
Uxie comes with built in feature that protect against CSRF when using ('POST','PATCH','PUT','DELETE') methods,
So every form should contain: csrf_field()

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

the ```container()```function is global in the framework (can be used every where, it contains all the objects created by the IOC container),



```php

container()->build('someclass');
container()->get('someClass')->someMethod();

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
And plenty of other methods such as limit(), orderBy(), groupBy(), count(), update and delete.
simple example:
```php
Model\table::select()->where('name', '=', 'user')->or('name', '=', 'other-user')->orderBy('date')->get();
```

## Visitors Statistics:
It's a built-in middleware that record each user data and store it in a database table,
Data such as ip, browser, os, PreviousUrl, CurrentUrl, date, and memory usage

## Request handler & validator:
It's a built-in Request handler :

```php
// you must add 'csrf_field()' to the HTML form to protect against CSRF
public function store(Request $request)
{
  echo $request->name;  
}
```

#### Validation:
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
All Error messages teamplates are defined in multiple 'resources/languages/validation.php' to make theme so easy to modify.

## Exception handler:
`Uxie` comes with a built-in exceptions handler that will handle thrown exceptions / errors automatically.  

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

You can find all languages files in 'resources/languages'
#### How to modify and add languages :
for example to edit validation messages you need to modify 'resources/languages/validations.php' :
```php
'default' => [
        'length'   => '$$ Length must be bettwen $$ and $$',
        'required' => '$$ Is Required',
        'email'    => '$$ Must be a valide Email',
        'url'      => '$$ Must be a valide URL',
        'isint'    => '$$ Must be of type integer',
        'isfloat'  => '$$ Must be of type float',
        'isip'     => '$$ Must be a valide IP',
    ],

    'french' => [
        'length'   => '$$ Doit etre entre $$ et $$',
        'required' => '$$ Est un Champ obligatoire',
        'email'    => '$$ Doit etre un e-mail',
        'url'      => '$$ Doit etre un URL valide',
        'isint'    => '$$ Doit etre de type entier',
        'isfloat'  => '$$ Doit etre de type float',
        'isip'     => '$$ Doit etre un IP valide',
    ],
```
#### How to set a language to be used :
To set a language use 'setLanguage(string $langauge)' function
If you don't set a language 'default' will be used
