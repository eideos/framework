<?php

namespace Eideos\Framework\Exports;

use Eideos\Framework\Lib\Export;
use Eideos\Framework\Presentations\pst_active;

class ButtonExport extends Export {

    public function map($modelBuilder): array {
        $pst_active = new pst_active([]);
        return [
            $modelBuilder->id,
            $modelBuilder->name,
            $modelBuilder->order,
            $pst_active->getOptionValue($modelBuilder->active)
        ];
    }

    public function headings(): array {
        return [
            '#',
            'Nombre',
            'Orden',
            'Activo',
        ];
    }

}
