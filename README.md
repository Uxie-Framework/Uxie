# What is Uxie :

Uxie is a PHP MVC Framework.

# Features :
#### -Perfect MVC environment.
#### -Routing.
#### -Blade templating engine.
#### -Middlewares.
#### -built-in model.
#### -built-in visitors analyser.
#### -Request handler.
#### -Exception handler.
#### -Errors logger.
#### -Helper functions.

# Documentation:
## Routing :
Web/Routes.php  
```php
$this->get('', function() {  
  view('index');
});  
$this->post('test', 'Controller@method');  
$this->resource('user', 'UserController'); // same function as laravel
$this->group('user', function() {
    $this->get('profile', function() {
        echo 'Profile';
    });
});
```
## Blade Templating Engine :
use helper function view()  
`
view('YourView', ['data' => $data])
`
## Middlewares :
all middlewares are defined in Web/middlewares.php  
documentation with examples is available in the same file  
## Built-in model :
insert data:  
`
Model\Table::insert(['column1', 'column2'], [value1, value2])->save();
`  
retrieve data:  
`
Model\table::select()->where('name', '=', 'user')->limit(10)->get();
`  
and planty of other methods such as limit, orderBy, groupBy, count, update, delete  
## built-in visitors analyser (Not fully developed):
it's a built in middleware that record each user hits and data and store them in a table
such as ip, browser, source, date
## Request handler:
it's a built in handler for POST requests (simulaire to laravels one)  
```php
public function store(Request $request)  
{  
  echo $reqeust->name;  
}
```
## Exception handler:
Uxie comes with a built in exception handler that will handle thrown exceptions automatically.
## Errors logger:
All errors/exceptions thrown during execution will be logged in log/All_errors.log
## Helpers:
Helpers are functions available to use everywhere inside the framework such as view(),session(),redirect(),route(),url()
all function are available in App/helpers.
