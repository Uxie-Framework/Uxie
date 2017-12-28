# What is Uxie:  
Uxie is a PHP MVC Framework.  

# Features:
#### - Perfect MVC environment.
#### - Routing.
#### - Blade templating engine.
#### - Middlewares.
#### - Built-in model.
#### - Built-in visitors analyser.
#### - Request handler.
#### - Exception handler.
#### - Errors logger.
#### - Helper functions.  

# Documentation:  

## Routing:
`web/Routes.php`

Basic route `get`:
```php
$this->get('', function() {
  view('index');
});
```
Execute methods from a controller:
```php
$this->post('test', 'Controller@method');
```

Resource method which contains: (index, create, store, show, edit, update and delete) same as [Laravel](https://github.com/laravel/framework/blob/5.5/src/Illuminate/Routing/Router.php#L294).  
```php
$this->resource('user', 'UserController');
```
Add a collection of routes with a prefix:
```php
$this->group('user', function() {
    $this->get('profile', function() {
        echo 'Profile';
    });
});
```  

## Blade Templating Engine:
Use helper function view():  
```php
view('YourView', ['data' => $data])
```  

## Middlewares:
All middlewares are defined in web/middlewares.php.  
Documentation with examples is available in the same file.  

## Built-in model:
Insert data:  
```php
Model\table::insert(['column1', 'column2'], [value1, value2])->save();
```
Retrieve data:  
```php
Model\table::select()->where('name', '=', 'user')->limit(10)->get();
```
And plenty of other methods such as limit, orderBy, groupBy, count, update and delete.  

## Built-in visitors analyzer (Not fully developed):
It's built in a middleware that record each user hits and data and store them in a database table;
Data such as ip, browser, source, date.   

## Request handler:
It's a built-in handler for `POST` requests (similar to the one in [Laravel](https://github.com/laravel/framework/blob/5.5/src/Illuminate/Http/Request.php)).  

```php
public function store(Request $request)  
{  
  echo $request->name;  
}
```

## Exception handler:
`Uxie` comes with a built in exception handler that will handle thrown exceptions automatically.  

## Errors logger:
All errors/exceptions thrown during runtime will be logged in `log/All_errors.log`.  

## Helpers:
Helpers are functions available to use everywhere inside the framework such as `view()`, `session()`, `redirect()`, `route()`, `url()`.  
All function are listed in `App/helpers`.
