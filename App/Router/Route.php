<?php
namespace App\Router;

class Route
{
    public $method;
    public $route;
    protected $action;
    protected $trimmed;
    protected $data;

    public function __construct(string $method, string $route, $action)
    {
        $this->method = $method;
        $this->route = $route;
        $this->action = $action;
        $this->trimmed = $this->trimRoute(new RouteTrimmer($this->route));
        $this->data = $this->trimData(new DataTrimmer);
    }

    private function trimUrl(RouteTrimmerInterface $trimmer)
    {
        //
    }
}
