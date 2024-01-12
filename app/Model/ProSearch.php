<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProSearch extends Model
{
  use HasFactory;
  protected $table = 'searches';
  protected $guarded = ['id'];
}
