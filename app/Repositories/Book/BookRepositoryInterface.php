<?php

namespace App\Repositories\Book;

use App\Repositories\RepositoryInterface;

interface BookRepositoryInterface extends RepositoryInterface
{
    public function paginateBookAsList();

    public function paginateBookAsGrid();

    public function searchBook($data);

    public function getCategory();

    public function findCategory($id);

    public function getAllCategory();

    public function getCategorizeBook($category);

    public function getCategorizeName($category);

    public function getReadBook($userId);

    public function getReadingBook($userId);

    public function getFavoriteBook($userId);

    public function storeBook($title, $author, $description, $pages_number, $publish_date, $image, $categories);

    public function getLastestBook();

    public function getRandomBook();

    public function getReview($id);

    public function checkExists($book, $userId);

    public function getPivot($book, $userId);

    public function getReviewed($id, $userId);

    public function getSelectedCategories($book);

    public function updateBook($book, $title, $author, $description, $pages_number, $publish_date, $img_path, $categories);

    public function deleteBook($id);

    public function getHomePageBook();
}
