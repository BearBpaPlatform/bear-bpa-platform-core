<?php


namespace SidorkinAlex\BearERP\Core\CoreControllers;


use Swoole\Http\Request;

class URI
{
    protected string $module='';
    protected string $action='';
    protected string $record='';
    /**
     * @var array
     */
    protected array $uri_collection = [];

    /**
     * URI constructor.
     * @param array $uri_collection
     */
    public function __construct(Request $request)
    {
        $uri= explode('/',urldecode($request->server['request_uri']));
        if(is_array($uri)) {
            $func = fn($x) => urldecode($x);
            $uri = array_map($func, $uri);
        }
        $this->init_from_arr($uri);
    }

    protected function init_from_arr(array $uri)
    {
        $this->uri_collection = $uri;
        if($this->uri_collection[1] == "modules"){
            $this->initModuleProperties();
        }
    }

    protected function initModuleProperties()
    {
        if(!empty($this->uri_collection[2])){
            $this->module = $this->uri_collection[2];
        }
        if(!empty($this->uri_collection[3])){
            $this->action = $this->uri_collection[3];
        }
        if(!empty($this->uri_collection[4])){
            $this->module = $this->uri_collection[4];
        }
    }

    /**
     * @return string
     */
    public function getModule(): string
    {
        return $this->module;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getRecord(): string
    {
        return $this->record;
    }

    public function getUriCollectionProperties(int $number):string{
        if(count($this->uri_collection)<$number){
            return $this->uri_collection[$number];
        }
        return '';
    }

    public function getUriCollection(): array
    {
        return $this->uri_collection;
    }

}