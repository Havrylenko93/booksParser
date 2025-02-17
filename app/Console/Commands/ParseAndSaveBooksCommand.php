<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class ParseAndSaveBooksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse-and-save-books-command {url=https://raw.githubusercontent.com/bvaughn/infinite-list-reflow-examples/refs/heads/master/books.json}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //TODO: change to use JsonParser (generators)

        try {
            $response = Http::get($this->argument('url'));
        } catch (\Throwable $exception) {
            $this->info('Error: ' . $exception->getMessage());
            return;
        }
        $responseBody = collect(json_decode($response->body()));
        $this->seedAuthors($responseBody);
        $this->seedCategories($responseBody);

        $responseBody->each(function ($item) {
            $authorsIds = Author::whereIn('full_name', $item->authors)->pluck('id');
            $categoriesIds = Category::whereIn('name', $item->categories)->pluck('id');

            $book = Book::updateOrCreate([
                'title' => $item->title,
                'isbn' => $item->isbn ?? null,
                'count_of_pages' => $item->pageCount,
                'published_date' => isset($item->publishedDate) ?
                    Carbon::createFromTimeString(get_object_vars($item->publishedDate)['$date']) :
                    null,
                'thumbnail_url' => $item->thumbnailUrl ?? null,
                'short_description' => $item->shortDescription ?? null,
                'long_description' => $item->longDescription ?? null,
                'status' => $item->status,
            ]);

            $book->authors()->sync($authorsIds);
            $book->categories()->sync($categoriesIds);
        });
    }

    /**
     * @param $responseBody
     * @return void
     */
    private function seedCategories($responseBody): void
    {
        $categories = $responseBody->pluck('categories');

        $categories->each(function ($categoriesList)  {
            foreach ($categoriesList as $category) {
                if ($category) {
                    Category::updateOrCreate(['name' => $category]);
                }
            }
        });
    }

    /**
     * @param $responseBody
     * @return void
     */
    private function seedAuthors($responseBody): void
    {
        $authors = $responseBody->pluck('authors');
        $authors->each(function ($authorsList)  {
            foreach ($authorsList as $author) {
                if ($author) {
                    Author::updateOrCreate(['full_name' => $author]);
                }
            }
        });
    }
}
