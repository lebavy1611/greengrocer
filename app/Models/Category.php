<?php

namespace App\Models;

use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Interfaces\StatisticInterface;

class Category extends Model implements StatisticInterface
{
    use SoftDeletes, FilterTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "categories";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'parent_id', 'position', 'image'
    ];


    /**
     * Relationship hasMany with Like
     *
     * @return array
     */
    public function parentsProducts()
    {
        return $this->hasManyThrough(Product::class, self::class, 'parent_id', 'category_id', 'id');
    }

    /**
     * Relationship hasMany with Like
     *
     * @return array
     */
    public function childrenProducts()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Count sub categories
     *
     * @param int $id Integer
     *
     * @return int
     */
    public static function countChild($id)
    {
        return Category::where('parent_id', $id)->count();
    }

    /**
     * Count parent categories
     *
     * @return int Integer
     */
    public static function countParents()
    {
        return Category::where('parent_id', 0)->count();
    }

    /**
     * Get the products for the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->orderBy('position','ASC');
    }

    /**
     * Get the products for the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function count($conditions = []) 
    {
        if ($conditions) {
            return Category::where($conditions)->count();
        }
        return Category::all()->count();
    }
}
