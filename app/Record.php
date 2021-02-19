<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Record
 *
 * @property int $id
 * @property int $genre_id
 * @property string $artist
 * @property string $title
 * @property string|null $title_mbid
 * @property string|null $cover
 * @property float $price
 * @property int $stock
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Record newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Record newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Record query()
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereArtist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereGenreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereTitleMbid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Record extends Model
{
    public function genre()
    {
        return $this->belongsTo('App\Genre')->withDefault();   // a record belongs to a genre
    }

}
