<?php


use Illuminate\Database\Eloquent\Model;
use Amalikov\Taggy\TaggableTrait;

class LessonStub extends Model
{
    use TaggableTrait;

    protected $connection = 'testbench';

    public $table = 'lessons';
 
}
