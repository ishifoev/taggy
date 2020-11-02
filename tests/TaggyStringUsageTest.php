<?php

use Illuminate\Support\Str;

class TaggyStringUsageTest extends TestCase
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

    /** @test */
    public function can_tag_a_lesson()
    {
        $this->lesson->tag(['php', 'laravel']);

        $this->assertCount(2, $this->lesson->tags);

        foreach(['Laravel', 'PHP'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }
    }
    
    /** @test */
    public function can_untag_a_lesson()
    {
        $this->lesson->tag(['php', 'laravel', 'testing']);
        $this->lesson->untag(['laravel']);

        $this->assertCount(2, $this->lesson->tags);

        foreach(['PHP', 'Testing'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }
    }

    /** @test */
    public function can_untag_all_lesson_tags()
    {
        $this->lesson->tag(['php', 'laravel', 'testing']);
        $this->lesson->untag();

        $this->lesson->load('tags');

        $this->assertCount(0, $this->lesson->tags);
        $this->assertEquals(0, $this->lesson->tags->count());
    }

    /** @test */
    public function can_retag_lesson_tags()
    {
        $this->lesson->tag(['php', 'laravel', 'testing']);
        $this->lesson->retag(['laravel', 'postgres', 'redis']);

        $this->lesson->load('tags');

        $this->assertCount(3, $this->lesson->tags);

        foreach(['Laravel', 'Postgres', 'Redis'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }
    }

    /** @test */
    public function non_existing_tags_are_ignored_on_tagging()
    {
        $this->lesson->tag(['laravel', 'c++', 'redis']);

        $this->assertCount(2, $this->lesson->tags);

        foreach(['Laravel', 'Redis'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }
    }

    /** @test */
    public function inconsistent_tag_cases_normalised()
    {
        $this->lesson->tag(['Laravel', 'REdis', 'TeSting', 'fun-stuff']);

        $this->assertCount(4, $this->lesson->tags);

        foreach(['Laravel', 'Redis', 'Testing', 'Fun stuff'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }
    }

}