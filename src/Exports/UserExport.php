<?php

namespace Eideos\Framework\Exports;

use Eideos\Framework\Lib\Export;
use \Eideos\Framework\Presentations\pst_active;

class UserExport extends Export {

    public function map($modelBuilder): array {
        $pst_active = new pst_active([]);
        return [
            $modelBuilder->id,
            $modelBuilder->firstname,
            $modelBuilder->lastname,
            $modelBuilder->email,
            $pst_active->getOptionValue($modelBuilder->active)
        ];
    }

    public function headings(): array {
        return [
            '#',
            'Nombre',
            'Apellido',
            'Email',
            'Activo',
        ];
    }

}
