<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
  protected $table = "box";
  protected $guarded = [];

  /**
   * @return BelongsTo
   */
  public function part()
  {
    return $this->BelongsTo(Part::class, "part_id");
  }

  public function castesGroupByMark()
  {
    return $this->hasMany(Cast::class, "box_id")->selectRaw('*, COUNT(id) as quantity_cast')->groupBy('mark')->groupBy('mark_replace');
  }
  public function castes()
  {
    return $this->hasMany(Cast::class, "box_id");
  }
  public function castes_pending()
  {
    return $this->hasMany(Cast::class, "box_id")->where("status", "pending");
  }
  public function castes_by_status($status)
  {
    return $this->hasMany(Cast::class, "box_id")->where("status",$status);
  }
  public function castes_conforme()
  {
    return $this->hasMany(Cast::class, "box_id")->where("status", "validated");
  }
  public function castes_no_conforme()
  {
    return $this->hasMany(Cast::class, "box_id")->wherein("status", ["rebust", "repair"]);
  }
  public function quantity()
  {
    return $this->castes()->count();
  }
  public function quantiy_conforme()
  {
    return $this->castes_conforme()->count();
  }
}
