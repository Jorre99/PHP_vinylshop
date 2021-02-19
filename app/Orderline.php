<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Orderline
 *
 * @property int $id
 * @property int $order_id
 * @property string $artist
 * @property string $title
 * @property string|null $cover
 * @property float $total_price
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Orderline newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Orderline newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Orderline query()
 * @method static \Illuminate\Database\Eloquent\Builder|Orderline whereArtist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orderline whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orderline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orderline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orderline whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orderline whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orderline whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orderline whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orderline whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Orderline extends Model
{
    public function order()
    {
        return $this->belongsTo('App\Order')->withDefault();   // an orderline belongs to an order
    }
}
