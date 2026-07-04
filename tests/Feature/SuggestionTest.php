<?php

use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('stores an anonymous suggestion from the public form', function () {
    $response = $this->post(route('layanan-masyarakat.saran.store'), [
        'comment' => 'Pelayanan sangat baik dan cepat.',
    ]);

    $response->assertRedirect(route('layanan-masyarakat'));
    $this->assertDatabaseHas('suggestions', [
        'comment' => 'Pelayanan sangat baik dan cepat.',
    ]);
});

it('shows anonymous suggestions in the admin panel', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    Suggestion::create(['comment' => 'Mohon tambah jam layanan.']);

    $response = $this->actingAs($admin)->get(route('admin.saran.index'));

    $response->assertOk();
    $response->assertSee('Mohon tambah jam layanan.');
});
