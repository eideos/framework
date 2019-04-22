<?php

namespace Eideos\Framework;

use App\AppModel;

class Notification extends AppModel
{
    protected $fillable = [
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at',
    ];
    protected $appends = ['tmp_formatted_data'];

    public function getTmpFormattedDataAttribute() {
        $jdata = json_decode($this->data, true);
        $data = array_map(function($v, $k) {
            return '<strong>' . $k . ':</strong> ' . $v;
        }, $jdata, array_keys($jdata));
        return '<ul><li>' . implode($data, '</li><li>') . '</li></ul>';
    }
}
