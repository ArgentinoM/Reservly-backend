<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ServicesFilter
{
    protected $request;
    protected $query;

    protected $filters = [
        'category',
        'price_min',
        'price_max',
        'duration',
        'date',
        'name'
    ];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($query)
    {
        $this->query = $query;

        foreach ($this->filters as $filter) {
            $method = 'filter' . ucfirst($filter);

            if (method_exists($this, $method) && $this->request->has($filter)) {
                $this->$method($this->request->get($filter));
            }
        }

        return $this->query;
    }

    public function filterCategory($value)
    {
        $this->query->where('category_id', $value);
    }

    public function filterDuration($value)
    {
        switch ($value) {
            case '1-8':
                $this->query->whereBetween('duration', [1, 8]);
                break;

            case '9-12':
                $this->query->whereBetween('duration', [9, 12]);
                break;

            case '12+':
                $this->query->where('duration', '>', 12);
                break;
        }
    }

    protected function filterPrice_min($value)
    {
        $this->query->where('price', '>=', $value);
    }

    protected function filterPrice_max($value)
    {
        $this->query->where('price', '<=', $value);
    }


    public function filterName($value)
    {
        $this->query->where('name', 'like', "%$value%");
    }

    public function filterDate($value)
    {
        if ($value === 'recent') {
            $this->query->latest();
        } elseif ($value === 'oldest') {
            $this->query->orderBy('created_at', 'asc');
        }
    }
}
