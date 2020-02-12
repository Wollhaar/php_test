<?php

class Article {
    
    private $dsn = 'host:localhost;port:3306;socket:mysql;';
    private $username = 'DB_user';
    private $passwd = 'DB_password';
    
    private $_instance;

    public function __construct() {
        
        try {
            $DB_connection = new PDO($this->dsn, $this->username, $this->passwd);
        } catch (Exception $ex) {
            die($ex);
        }
        return $DB_connection;
    }

    public function getDBConnection() {
        return self::$_instance = new self();
    }
    
    /**
     * store an new product in database
     * function requires an array filled with data of the product.
     *
     * @param array $product
     * @return mixed
     */
    public function store(array $product) {
        
        $pdo = $this->getDBConnection();
        
        $pdo->prepare('INSERT INTO article '
                . '(h_id, '
                . 'k_id, '
                . 'name, '
                . 'beschreibung, '
                . 'zolltarif_nr, '
                . 'isbn, '
                . 'ean, '
                . 'mpn) '
                . 'VALUES(:h_id, '
                . ':k_id, '
                . ':name, '
                . ':description, '
                . ':number_zoll, '
                . ':number_isbn, '
                . ':number_ean, '
                . ':number_mpn);'
                
                . 'INSERT INTO diff_prices '
                . '(art_nr, '
                . 'kg_id, '
                . 'price) '
                . 'VALUES (LAST_INSERT_ID, :kg_id, :price)');

        $pdo->bindParam(':h_id', $product['number_hersteller'], PDO::PARAM_INT);
        $pdo->bindParam(':k_id', $product['number_kategorie'], PDO::PARAM_INT);
        $pdo->bindParam(':name', $product['name'], PDO::PARAM_STR);
        $pdo->bindParam(':description', $product['description'], PDO::PARAM_STR);
        $pdo->bindParam(':number_zoll', $product['number_zoll'], PDO::PARAM_STR);
        $pdo->bindParam(':number_isbn', $product['number_isbn'], PDO::PARAM_STR);
        $pdo->bindParam(':number_ean', $product['number ean'], PDO::PARAM_STR);
        $pdo->bindParam(':number_mpn', $product['number_mpn'], PDO::PARAM_STR);
        $pdo->bindParam(':kg_id', $product['number_kundengr'], PDO::PARAM_INT);
        $pdo->bindParam(':price', $product['price'], PDO::PARAM_STR);
        
        $stmt = $pdo->execute();
        $result = $stmt->fetch();
        
        unset($pdo);
        return $result;
    }
    
    /**
     * get all information of an product
     * function requires the ID from the article.
     *
     * @param int $id
     * @return type
     */
    public function show(int $id) {
       
       $pdo = $this->getDBConnection();
       
       $pdo->prepare('SELECT art.art_nr, '
               . 'art.h_id, '
               . 'art.k_id, '
               . 'art.name, '
               . 'art.beschreibung, '
               . 'art.zollatarif_nr, '
               . 'art.isbn, '
               . 'art.ean, '
               . 'art.mpn, '
               . 'h.name, '
               . 'kg.gruppe, '
               . 'dp.price '
               . 'FROM article as art'
               
               . 'LEFT JOIN diff_prices as dp'
               . 'ON art.art_nr = dp.art_nr'
           
               . 'LEFT JOIN hersteller as h'
               . 'ON art.h_id = h.h_id'
               
               . 'LEFT JOIN kategorie as k'
               . 'ON art.k_id = k.k_id'
               
               . 'LEFT JOIN kundengruppe as kg'
               . 'ON (SELECT kg_id FROM diff_prices '
               . 'WHERE art_nr = art.art_nr) = kg.kg_id'
               
               .'WHERE art_nr = :art_nr;');
       
       $pdo->bindParam(':art_nr', $id, PDO::PARAM_INT);
       
       $stmt = $pdo->execute();
       $query = $stmt->fetchAll();
       
       unset($pdo);
       return $query;
    }

    /**
     * updating single articles.
     * function requires an array filled with data of the product.
     *
     * @param array $product
     * @return mixed
     */
    public function update(array $product) {
        
        $pdo = $this->getDBConnection();
        
        $pdo->prepare('UPDATE article SET '
                . 'h_id = :h_id, '
                . 'k_id = :k_id, '
                . '`name` = :`name`, '
                . 'description = :description, '
                . 'zolltarif_nr = :zolltarif, '
                . 'isbn = :isbn, '
                . 'ean = :ean, '
                . 'mpn = :mpn'
                . 'WHERE art_nr = :art_nr;');
        
        $pdo->bindParam(':art_nr', $product['article_nr'], PDO::PARAM_INT);
        $pdo->bindParam(':h_id', $product['hersteller_id'], PDO::PARAM_INT);
        $pdo->bindParam(':k_id', $product['kategorie_id'], PDO::PARAM_INT);
        $pdo->bindParam(':name', $product['name'], PDO::PARAM_STR);
        $pdo->bindParam(':description', $product['description'], PDO::PARAM_STR);
        $pdo->bindParam(':zolltarif_nr', $product['zolltarif_nr'], PDO::PARAM_STR);
        $pdo->bindParam(':isbn', $product['isbn_nr'], PDO::PARAM_STR);
        $pdo->bindParam(':ean', $product['ean_nr'], PDO::PARAM_STR);
        $pdo->bindParam(':mpn', $product['mpn_nr'], PDO::PARAM_STR);
        
        $stmt = $pdo->execute();
        $result = $stmt->fetch();
        
        unset($pdo);
        return $result;
    }

    /**
     * deleting single articles.
     * function requires the ID from the article.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        
        $pdo = $this->getDBConnection();
        
        $pdo->prepare('DELETE FROM article WHERE art_nr = :art_nr;'
                . 'DELETE FROM diff_prices WHERE art_nr = :art_nr;');
        
        $pdo->bindParam(':art_nr', $id, PDO::PARAM_STR);
        $stmt = $pdo->execute();
        $result = $stmt->fetch();
        
        unset($pdo);
        return $result;
    }
}
