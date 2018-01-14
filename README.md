# What is Uxie:  
Uxie is a PHP MVC Framework.  

# Features:
#### - Perfect MVC environment.
#### - Routing.
#### - Blade templating engine.
#### - Middlewares.
#### - Model.
#### - visitors statistics.
#### - Http Request handler.
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
### Passing data via http url
in routes file :
```php
$this->get('profile/@{name}/@{email}', 'Controller@method');
```
in Controller : 
```php
public function method($name, $email)
{
    echo $name;
    echo $email;
}
```

### passing data via Post request
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
## Blade Templating Engine (same as Laravel):
Use helper function view(string $view, array $variables):  
```php
view('YourView', ['data' => $data, 'Amine' => $name]);
```  

## Middlewares:
there are 3 types of middlewares : prior-middlewares,late-middlewares and global-middlewares
All middlewares are defined in web/middlewares.php.
example: 
```php
// 'route' => 'middleware',
'profile' => 'auth',
```
All Middlewares files should be created in Middlewares folder
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
$user = Model/table::find('name', 'MyName');
```
And plenty of other methods such as limit, orderBy, groupBy, count, update and delete.
simple example:
```php
Model\table::select()->where('name', '=', 'user')->or('name', '=', 'other-user')->orderBy('date')->get();
```

## Visitors Statistics:
It's a built-in middleware that record each user hits and data and store them in a database table;
Data such as ip, browser, os, PreviousUrl, CurrentUrl, date.

## Http Request handler:
It's a built-in handler for `POST` requests

```php
public function store(Request $request)  
{
  echo $request->name;  
}
```

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
```
