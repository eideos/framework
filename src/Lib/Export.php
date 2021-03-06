<?php

namespace Eideos\Framework\Lib;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Builder;

class Export implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $modelBuilder;

    public function __construct(Builder $modelBuilder = null)
    {
        $this->modelBuilder = $modelBuilder;
    }

    public function query()
    {
        return $this->modelBuilder;
    }

    public function map($modelBuilder): array
    {
        return [];
    }

    public function headings(): array
    {
        return [];
    }
}
