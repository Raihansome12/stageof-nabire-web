<?php

use App\Models\InformasiPublik;
use App\Models\Publication;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows active informasi publik berita on the homepage', function () {
    $informasiPublik = InformasiPublik::create([
        'type' => 'berita',
        'title' => 'Berita terbaru dari informasi publik',
        'description' => 'Konten dari informasi publik',
        'published_at' => now()->subDay(),
        'is_active' => true,
    ]);

    $publication = Publication::create([
        'type' => 'berita',
        'title' => 'Berita dari publikasi',
        'description' => 'Konten dari publikasi',
        'published_at' => now()->subDay(),
        'is_active' => true,
    ]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee($informasiPublik->title);
    $response->assertDontSee($publication->title);
});
