<?php

use Illuminate\Support\Str;

class TaggyStringUsageTest extends TestCase
{
    protected $lesson;

    public function setUp() : void
    {
        parent::setUp();

        foreach(['PHP', 'Laravel', 'Testing', 'Postgres', 'FunStaff'] as $tag) {
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

    /** @test */
    public function can_tag_lesson()
    {
        $this->lesson->tag(['php', 'laravel']);

        $this->assertCount(2, $this->lesson->tags);

        foreach(['Laravel', 'PHP'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }
    }
}