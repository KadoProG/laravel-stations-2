<?php

namespace Tests\Feature\LaravelStations\Station5;

use App\Models\Practice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;

class PracticeTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group('station5')]
    public function testGetPracticeが全てのPracticeを返しているか(): void
    {
        for ($i = 0; $i < 11; $i++) {
            Practice::insert([
                'title' => 'タイトル' . $i,
            ]);
        }
        $response = $this->get('/getPractice');
        $practices = Practice::all();
        foreach ($practices as $practice) {
            $response->assertSeeText($practice->title);
        }
    }
}
