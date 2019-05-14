<?php

namespace Eideos\Framework\Lib;

use Maatwebsite\Excel\Concerns\ToModel;

abstract class Import implements ToModel
{
    public function model(array $row)
    { }
}
