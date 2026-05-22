<?php

namespace Tests\Feature;

use App\Models\Cottage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CottageArchiveTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed database roles
        \App\Models\Role::firstOrCreate(['id' => 1], ['name' => 'admin']);
        \App\Models\Role::firstOrCreate(['id' => 2], ['name' => 'staff']);
        
        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_soft_delete_cottage(): void
    {
        $cottage = Cottage::create([
            'name' => 'Sunset Suite',
            'slug' => 'sunset-suite',
            'description' => 'Ocean view suite',
            'capacity' => 2,
            'price' => 3500,
            'status' => 'available',
        ]);

        $response = $this
            ->actingAs($this->admin)
            ->delete(route('admin.cottages.destroy', $cottage->id));

        $response->assertRedirect(route('admin.cottages.index'));
        $response->assertSessionHas('success', 'Cottage deleted successfully.');

        // Verify soft-deleted
        $this->assertSoftDeleted('cottages', [
            'id' => $cottage->id,
        ]);

        // Standard queries shouldn't return it
        $this->assertCount(0, Cottage::all());

        // Trashed queries should return it
        $this->assertCount(1, Cottage::withTrashed()->get());
    }

    public function test_admin_can_view_archived_cottages(): void
    {
        $cottage = Cottage::create([
            'name' => 'Garden Villa',
            'slug' => 'garden-villa',
            'description' => 'Lush garden view',
            'capacity' => 4,
            'price' => 4500,
            'status' => 'available',
        ]);

        $cottage->delete();

        // View active list (should be empty)
        $response = $this
            ->actingAs($this->admin)
            ->get(route('admin.cottages.index'));
        
        $response->assertOk();
        $response->assertViewHas('cottages', function ($cottages) {
            return $cottages->count() === 0;
        });

        // View archived list
        $response = $this
            ->actingAs($this->admin)
            ->get(route('admin.cottages.index', ['status' => 'archived']));
        
        $response->assertOk();
        $response->assertViewHas('cottages', function ($cottages) use ($cottage) {
            return $cottages->count() === 1 && $cottages->first()->id === $cottage->id;
        });
    }

    public function test_admin_can_restore_cottage(): void
    {
        $cottage = Cottage::create([
            'name' => 'Beachside Loft',
            'slug' => 'beachside-loft',
            'description' => 'Right on the sand',
            'capacity' => 3,
            'price' => 5000,
            'status' => 'available',
        ]);

        $cottage->delete();

        $response = $this
            ->actingAs($this->admin)
            ->post(route('admin.cottages.restore', $cottage->id));

        $response->assertRedirect(route('admin.cottages.index'));
        $response->assertSessionHas('success', 'Cottage restored successfully.');

        // Verify restored
        $this->assertDatabaseHas('cottages', [
            'id' => $cottage->id,
            'deleted_at' => null,
        ]);
    }

    public function test_admin_can_purge_cottage(): void
    {
        $cottage = Cottage::create([
            'name' => 'Peak Villa',
            'slug' => 'peak-villa',
            'description' => 'Top of the hill view',
            'capacity' => 6,
            'price' => 7500,
            'status' => 'available',
        ]);

        $cottage->delete();

        $response = $this
            ->actingAs($this->admin)
            ->delete(route('admin.cottages.purge', $cottage->id));

        $response->assertRedirect(route('admin.cottages.index'));
        $response->assertSessionHas('success', 'Cottage permanently deleted.');

        // Verify permanently deleted from database
        $this->assertDatabaseMissing('cottages', [
            'id' => $cottage->id,
        ]);
    }
}
