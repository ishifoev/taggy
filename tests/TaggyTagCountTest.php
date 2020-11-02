<?php

use Illuminate\Support\Str;

class TaggyTagCountTest extends TestCase
{
    protected $lesson;

    public function setUp() : void
    {
        parent::setUp();


        $this->lesson = \LessonStub::create([
            'title' => 'A lesson title'
        ]);
    }

    /** @test */
    public function tag_count_is_incremented_when_tagged()
    {
        $tag = \TagStub::create([
           'name' => 'Laravel',
           'slug' => Str::slug('Laravel'),
           'count' => 0
        ]);

        $this->lesson->tag(['laravel']);

        $tag = $tag->fresh();

        $this->assertEquals(1, $tag->count);
    }

     /** @test */
     public function tag_count_is_decremented_when_untagged()
     {
         $tag = \TagStub::create([
            'name' => 'Laravel',
            'slug' => Str::slug('Laravel'),
            'count' => 70
         ]);
 
         $this->lesson->tag(['laravel']);
         $this->lesson->untag(['laravel']);
 
         $tag = $tag->fresh();
 
         $this->assertEquals(70, $tag->count);
     }

     /** @test */
     public function tag_count_does_not_dip_below_zero()
     {
        $tag = \TagStub::create([
            'name' => 'Laravel',
            'slug' => Str::slug('Laravel'),
            'count' => 0
         ]);

         $this->lesson->untag(['laravel']);

         $tag = $tag->fresh();

         $this->assertEquals(0, $tag->count);
     }

     /** @test */
     public function tag_count_does_not_increment_if_already_exists()
     {
        $tag = \TagStub::create([
            'name' => 'Laravel',
            'slug' => Str::slug('Laravel'),
            'count' => 0
         ]);

         $this->lesson->tag(['laravel']);
         $this->lesson->retag(['laravel']);
         $this->lesson->tag(['laravel']);
         $this->lesson->tag(['laravel']);


         $tag = $tag->fresh();

         $this->assertEquals(1, $tag->count);
     }
}