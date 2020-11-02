<?php

use Illuminate\Support\Str;

class TaggyModelUsageTest extends TestCase
{
    protected $lesson;

    public function setUp() : void
    {
        parent::setUp();

        foreach(['PHP', 'Laravel', 'Testing', 'Redis','Postgres', 'Fun stuff'] as $tag) {
            \TagStub::create([
               'name' => $tag,
               'slug' => Str::slug($tag),
               'count' => 0
            ]);
        }

        $this->lesson = \LessonStub::create([
            'title' => 'A lesson title'
        ]);
    }

}