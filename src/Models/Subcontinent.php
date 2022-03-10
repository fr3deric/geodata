<?php

namespace Papposilene\Geodata\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Papposilene\Geodata\Exceptions\SubcontinentDoesNotExist;

class Subcontinent extends Model
{
    protected $visible = [
        'id',
        'code',
        'name',
        'slug',
        'region',
        'translations',
        'continent_id',
    ];

    public function getTable()
    {
        return 'geodata__subcontinents';
    }

    /**
     * A subcontinent belongs to one continent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsToContinent(): BelongsTo
    {
        return $this->belongsTo(
            Continent::class,
            'id',
            'continent_id'
        );
    }

    /**
     * A subcontinent has many countries.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasCountries(): HasMany
    {
        return $this->hasMany(
            Country::class,
            'continent_id',
            'id'
        );
    }

    /**
    * Find a subccontinent by its code.
    *
    * @param integer $code
    *
    * @throws \Papposilene\Geodata\Exceptions\SubcontinentDoesNotExist
    *
    * @return Subcontinent
    */
   public static function findByCode(int $code): Subcontinent
   {
       $subccontinent = static::where('code', $code)->first();

       if (!$subccontinent) {
           throw SubcontinentDoesNotExist::withCode($code);
       }

       return $subccontinent;
   }

   /**
    * Find a subccontinent by its id.
    *
    * @param integer $id
    *
    * @throws \Papposilene\Geodata\Exceptions\SubcontinentDoesNotExist
    *
    * @return Subcontinent
    */
   public static function findById(int $id): Subcontinent
   {
       $subccontinent = static::first($id);

       if (!$subccontinent) {
           throw SubcontinentDoesNotExist::withId($id);
       }

       return $subccontinent;
   }

   /**
    * Find a subccontinent by its name.
    *
    * @param string $name
    *
    * @throws \Papposilene\Geodata\Exceptions\SubcontinentDoesNotExist
    *
    * @return Subcontinent
    */
   public static function findByName(string $name): Subcontinent
   {
       $subccontinent = self::where('name', $name)->first();

       if (!$subccontinent) {
           throw SubcontinentDoesNotExist::named($name);
       }

       dd($subccontinent);

       return $subccontinent;
   }

   /**
    * Find a subccontinent by its slug.
    *
    * @param string $slug
    *
    * @throws \Papposilene\Geodata\Exceptions\SubcontinentDoesNotExist
    *
    * @return Subcontinent
    */
   public static function findBySlug(string $slug): Subcontinent
   {
       $subccontinent = self::where('slug', $slug)->first();

       if (!$subccontinent) {
           throw SubcontinentDoesNotExist::withSlug($slug);
       }

       dd($subccontinent);

       return $subccontinent;
   }
}
