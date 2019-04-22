<?php

namespace Eideos\Framework\Exports;

use Eideos\Framework\Lib\Export;

class RightExport extends Export {

    public function map($modelBuilder): array {
        return [
            $modelBuilder->id,
            $modelBuilder->name,
            $modelBuilder->description,
        ];
    }

    public function headings(): array {
        return [
            '#',
            'Nombre',
            'Descripción',
        ];
    }

}
