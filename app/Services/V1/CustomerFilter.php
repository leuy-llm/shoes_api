<?php

namespace App\Services\V1;
use Illuminate\Http\Request;
class CustomerFilter
{
    protected $request;
    protected $query;

    // Allowed fields for filtering
    protected $filters = ['city', 'type', 'email', 'name'];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($query)
    {
        $this->query = $query;

        foreach ($this->filters as $filter) {
            if ($this->request->filled($filter)) {
                $method = 'filter' . ucfirst($filter);
                
                if (method_exists($this, $method)) {
                    $this->$method($this->request->get($filter));
                } else {
                    $this->query->where($filter, 'like', "%{$this->request->get($filter)}%");
                }
            }
        }

        return $this->query;
    }

    // Example of custom filter
    protected function filterType($value)
    {
        $this->query->where('type', $value);
    }
}
