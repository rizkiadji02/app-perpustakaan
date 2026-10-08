<?php

namespace Tests\Feature;

use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_be_created_and_success_flash_is_shown(): void
    {
        $response = $this->post(route('members.store'), $this->validMemberData());

        $response->assertRedirect(route('members.index'))
            ->assertSessionHas('success', 'Anggota "Siti Aminah" berhasil ditambahkan.');

        $this->assertDatabaseHas('members', [
            'nim' => '2310501001',
            'email' => 'siti@example.com',
        ]);

        $this->get(route('members.index'))
            ->assertOk()
            ->assertSee('alert-success')
            ->assertSee('Anggota "Siti Aminah" berhasil ditambahkan.');
    }

    public function test_member_fields_are_required_and_unique_values_are_enforced(): void
    {
        $this->from(route('members.create'))
            ->post(route('members.store'), [])
            ->assertSessionHasErrors(['nama', 'nim', 'email', 'nomor_telepon', 'alamat', 'status']);

        Member::create($this->validMemberData());

        $this->from(route('members.create'))
            ->post(route('members.store'), $this->validMemberData(['nama' => 'Anggota Duplikat']))
            ->assertSessionHasErrors(['nim', 'email']);
    }

    public function test_member_details_and_edit_form_are_available(): void
    {
        $member = Member::create($this->validMemberData());

        $this->get(route('members.show', $member->id))
            ->assertOk()
            ->assertSee('Detail Anggota')
            ->assertSee('Siti Aminah')
            ->assertSee('2310501001');

        $this->get(route('members.edit', $member->id))
            ->assertOk()
            ->assertSee('Edit Anggota')
            ->assertSee('value="Siti Aminah"', false)
            ->assertSee('value="2310501001"', false);
    }

    public function test_member_can_be_updated_without_changing_unique_values(): void
    {
        $member = Member::create($this->validMemberData());
        $updatedData = $this->validMemberData(['nama' => 'Siti Aminah Putri']);

        $response = $this->put(route('members.update', $member->id), $updatedData);

        $response->assertRedirect(route('members.index'))
            ->assertSessionHas('success', 'Anggota "Siti Aminah Putri" berhasil diperbarui.');

        $this->assertDatabaseHas('members', [
            'id' => $member->id,
            'nama' => 'Siti Aminah Putri',
            'nim' => '2310501001',
            'email' => 'siti@example.com',
        ]);
    }

    public function test_member_can_be_deleted(): void
    {
        $member = Member::create($this->validMemberData());

        $this->delete(route('members.destroy', $member->id))
            ->assertRedirect(route('members.index'))
            ->assertSessionHas('success', 'Anggota berhasil dihapus.');

        $this->assertDatabaseMissing('members', ['id' => $member->id]);
    }

    public function test_search_filters_names_and_is_preserved_in_pagination_links(): void
    {
        foreach (range(1, 12) as $number) {
            Member::create($this->validMemberData([
                'nama' => "Anggota Uji {$number}",
                'nim' => sprintf('NIM%010d', $number),
                'email' => "anggota{$number}@example.com",
            ]));
        }

        Member::create($this->validMemberData([
            'nama' => 'Nama Tidak Cocok',
            'nim' => 'NIM9999999999',
            'email' => 'lain@example.com',
        ]));

        $this->get(route('members.index', ['search' => 'Anggota Uji']))
            ->assertOk()
            ->assertSee('Anggota Uji 1')
            ->assertDontSee('Nama Tidak Cocok')
            ->assertSee('search=Anggota%20Uji', false)
            ->assertSee('page=2', false);
    }

    private function validMemberData(array $overrides = []): array
    {
        return array_merge([
            'nama' => 'Siti Aminah',
            'nim' => '2310501001',
            'email' => 'siti@example.com',
            'nomor_telepon' => '081234567890',
            'alamat' => 'Surabaya',
            'status' => 'aktif',
        ], $overrides);
    }
}