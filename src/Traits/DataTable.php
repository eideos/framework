<?php 

namespace Eideos\Framework\Traits;

trait DataTable
{
    protected $datatableDefaultParams =[
        "dom"=> 'Bftip',
        "buttons"=> [
                "buttons"=> [
                        [
                                "extend" => 'copy',
                                "className" => 'btn btn-sm btn-secondary',
                                "exportOptions"=> [
                                        "columns"=> ':not(:last-child)',
                                ]
                        ],
                        [
                                "extend" => 'csv',
                                "className" => 'btn btn-sm btn-secondary',
                                "exportOptions"=> [
                                        "columns"=> ':not(:last-child)',
                                ]
                        ],
                        [
                                "extend" => 'excel',
                                "className" => 'btn btn-sm btn-secondary',
                                "exportOptions"=> [
                                        "columns"=> ':not(:last-child)',
                                ]
                        ],
                        [
                                "extend" => 'pdf',
                                "className" => 'btn btn-sm btn-secondary',
                                "exportOptions"=> [
                                        "columns"=> ':not(:last-child)',
                                ]
                        ]
                ],
        ],
        "language"=>[
                "sProcessing"=>     "Procesando...",
                "sLengthMenu"=>     "Mostrar _MENU_ registros",
                "sZeroRecords"=>    "No se encontraron resultados",
                "sEmptyTable"=>     "Ningún dato disponible",
                "sInfo"=>           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registro/s",
                "sInfoEmpty"=>      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered"=>   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix"=>    "",
                "sSearch"=>         "Buscar:",
                "sUrl"=>            "",
                "sInfoThousands"=>  ",",
                "sLoadingRecords"=> "Cargando...",
                "oPaginate"=> [
                "sFirst"=>    "Primero",
                "sLast"=>     "Último",
                "sNext"=>     "Siguiente",
                "sPrevious"=>   "Anterior"
                ],
                "oAria"=> [
                        "sSortAscending"=>  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending"=> ": Activar para ordenar la columna de manera descendente"
                ],
                "buttons"=> [
                        "copy"=> "Copiar",
                        "colvis"=> "Visibilidad"
                ]
        ]
];

}