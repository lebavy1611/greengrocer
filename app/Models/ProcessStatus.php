<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessStatus extends Model
{
    use SoftDeletes;

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
