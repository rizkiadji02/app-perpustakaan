<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateFormsTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_book_submission_shows_validation_errors(): void
    {
        $response = $this->from(route('books.create'))
            ->post(route('books.store'), []);

        $response->assertRedirect(route('books.create'))
            ->assertSessionHasErrors(['judul', 'penulis', 'penerbit', 'tahun_terbit', 'stok', 'category_id']);

        $this->get(route('books.create'))
            ->assertOk()
            ->assertSee('Judul buku wajib diisi.');
    }

    public function test_valid_book_submission_redirects_and_shows_success_flash(): void
    {
        $category = Category::create(['nama_kategori' => 'Fiksi']);

        $response = $this->post(route('books.store'), [
            'judul' => 'Buku Uji',
            'penulis' => 'Penulis Uji',
            'penerbit' => 'Penerbit Uji',
            'tahun_terbit' => date('Y'),
            'stok' => 2,
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('books.index'))
            ->assertSessionHas('success', 'Buku "Buku Uji" berhasil ditambahkan.');

        $this->get(route('books.index'))
            ->assertOk()
            ->assertSee('alert-success')
            ->assertSee('Buku "Buku Uji" berhasil ditambahkan.');
    }

    public function test_empty_category_submission_shows_validation_errors(): void
    {
        $response = $this->from(route('categories.create'))
            ->post(route('categories.store'), []);

        $response->assertRedirect(route('categories.create'))
            ->assertSessionHasErrors(['nama_kategori']);

        $this->get(route('categories.create'))
            ->assertOk()
            ->assertSee('Nama kategori wajib diisi.');
    }

    public function test_valid_category_submission_redirects_and_shows_success_flash(): void
    {
        $response = $this->post(route('categories.store'), [
            'nama_kategori' => 'Kategori Uji',
            'deskripsi' => 'Deskripsi uji',
        ]);

        $response->assertRedirect(route('categories.index'))
            ->assertSessionHas('success', 'Kategori "Kategori Uji" berhasil ditambahkan.');

        $this->get(route('categories.index'))
            ->assertOk()
            ->assertSee('alert-success')
            ->assertSee('Kategori "Kategori Uji" berhasil ditambahkan.');
    }
}