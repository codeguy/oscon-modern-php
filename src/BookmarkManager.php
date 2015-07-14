<?php
namespace App;

class BookmarkManager
{
    /**
     * PDO instance
     *
     * @var \PDO
     */
    protected $pdo;

    /**
     * Constructor
     *
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Add bookmark
     *
     * @param  \App\BookmarkInterface $bookmark A bookmarkable instance
     *
     * @return bool
     */
    public function addBookmark(\App\BookmarkInterface $bookmark)
    {
        // Build prepared statement
        $sql = 'INSERT INTO ' .
               'bookmarks (title, caption, image, url, created_at) ' .
               'VALUES (:title, :caption, :image, :url, NOW())';
        $stmt = $this->pdo->prepare($sql);

        // Bind values to prepared statement
        $stmt->bindValue(':title', $bookmark->getTitle());
        $stmt->bindValue(':caption', $bookmark->getCaption());
        $stmt->bindValue(':image', $bookmark->getImage());
        $stmt->bindValue(':url', $bookmark->getUrl());

        // Execute statement and return result
        return $stmt->execute();
    }

    /**
     * Get bookmarks
     *
     * @return array
     * @throws \RuntimeException If PDO query fails
     */
    public function getBookmarks()
    {
        // Execute SQL query against PDO connection
        $sql = 'SELECT title, caption, image, url ' .
               'FROM bookmarks ' .
               'ORDER BY created_at DESC';
        $stmt = $this->pdo->query($sql);
        if (!$stmt) {
            throw new \RuntimeException('PDO query failed');
        }

        // Return SQL result as associative array
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
