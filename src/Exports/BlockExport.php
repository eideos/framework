<?php

namespace Eideos\Framework\Exports;

use Eideos\Framework\Lib\Export;

class BlockExport extends Export {

    public function map($modelBuilder): array {
        return [
            $modelBuilder->id,
            $modelBuilder->user->email,
            $modelBuilder->session_id,
            $modelBuilder->model,
            $modelBuilder->model_id,
        ];
    }

    public function headings(): array {
        return [
            '#',
            'Usuario',
            'ID de Sesión',
            'Modelo',
            'ID del Modelo',
        ];
    }

}
