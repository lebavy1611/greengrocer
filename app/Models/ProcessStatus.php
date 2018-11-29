<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessStatus extends Model
{
    protected $table = "process_statuses";

    /**
     * Get OrderDetail for Order, the name's function isn't the Camel, because Kyslik\ColumnSortable\Sortable
     * doesn't allow the Camel when using withCount().
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'processing_status', 'id');
    }
}
