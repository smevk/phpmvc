<?php
namespace Php\Mvc\App\Traits;

use PDO;
use Php\Mvc\App\Core\UrlParser;

trait DbQueries {

    protected $pdo;
    protected $query;
    protected $params = [];
    protected $pageKey = 'page';
    public function basicQuery(){
        if(!empty($this->query)) return;
        $this->query = "Select * from $this->tableName";

    }

    protected function select(string $columns = '*')
    {
        $this->query = "SELECT $columns FROM {$this->tableName}";
        return $this;
    }

    protected function where(string $column, string $operator, $value)
    {
        $this->basicQuery();
        $this->query .= empty($this->params) ? " WHERE $column $operator ?" : " AND $column $operator ?";
        $this->params[] = $value;
        return $this;
    }

    protected function orWhere(string $column, string $operator, $value)
    {
        $this->basicQuery();

        $this->query .= " OR $column $operator ?";
        $this->params[] = $value;
        return $this;
    }

    protected function orderBy(string $column, string $direction = 'ASC')
    {
        $this->basicQuery();
        $this->query .= " ORDER BY $column $direction";
        return $this;
    }

    protected function limit(int $limit)
    {
        $this->basicQuery();
        $this->query .= " LIMIT $limit";
        return $this;
    }

    protected function offset(int $offset)
    {
        $this->basicQuery();
        $this->query .= " OFFSET $offset";
        return $this;
    }

    protected function get()
    {
        // If there are no parameters, return all records
        if (empty($this->params)) {
            return $this->all();
        }

        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute($this->params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    


    protected function paginate(int $perPage = 10)
    {
        $this->basicQuery();
    
        $count = $this->getTotalRecordCount();
    
        $totalPages = $this->calculateTotalPages($count, $perPage);
    
        $currentPage = $this->getCurrentPageNumber();
    
        $this->limit($perPage)->offset(($currentPage - 1) * $perPage);
    
        $records = $this->get();
    
        $links = $this->getPaginationLinks($currentPage, $totalPages);
    
        return [
            'data' => $records,
            'page' => $currentPage,
            'perPage' => $perPage,
            'totalPages' => $totalPages,
            'totalRecords' => $count,
            'links' => $links,
        ];
    }
    
    private function getTotalRecordCount()
    {
        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute($this->params);
    
        return $stmt->rowCount();
    }
    
    private function calculateTotalPages(int $count, int $perPage)
    {
        return ceil($count / $perPage);
    }
    
    private function getCurrentPageNumber()
    {
        $queryParams = UrlParser::$params;
        $pageKey = $this->pageKey;
    
        return isset($queryParams[$pageKey]) ? (int) $queryParams[$pageKey] : 1;
    }
    
    private function getPaginationLinks(int $currentPage, int $totalPages)
    {
        $baseUrl = UrlParser::$urlWithoutParam;
        $queryParams = UrlParser::$params;
        $pageKey = $this->pageKey;
    
        if (array_key_exists($pageKey, $queryParams)) {
            unset($queryParams[$pageKey]);
        }
    
        $links = [
            'first' => $baseUrl . '?' . http_build_query($queryParams + [$pageKey => 1]),
            'prev' => null,
            'next' => null,
            'last' => $baseUrl . '?' . http_build_query($queryParams + [$pageKey => $totalPages]),
            'current' => $baseUrl . '?' . http_build_query($queryParams + [$pageKey => $currentPage]),
        ];
    
        if ($currentPage > 1) {
            $links['prev'] = $baseUrl . '?' . http_build_query($queryParams + [$pageKey => $currentPage - 1]);
        }
    
        if ($currentPage < $totalPages) {
            $links['next'] = $baseUrl . '?' . http_build_query($queryParams + [$pageKey => $currentPage + 1]);
        }
    
        return $links;
    }

    protected function all()
    {
        $this->basicQuery();
        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    
    protected function find(int $id) {
        $this->basicQuery();
        $this->query .= " WHERE id = ?";
        $this->params[] = $id;
        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute($this->params);
         return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    protected function save(){
        $columns = array_keys($this->requestAttributes);
        $values = array_values($this->requestAttributes);
        $placeholders = implode(',', array_fill(0, count($values), '?'));
    
        if (isset($this->requestAttributes['id'])) {
            // Update the record if 'id' attribute is present
            $query = "UPDATE $this->tableName SET ";
            $setColumns = array_map(function ($column) {
                return "$column=?";
            }, $columns);
            $query .= implode(',', $setColumns);
            $query .= " WHERE id=?";
    
            $values[] = $this->requestAttributes['id'];
    
            $statement = $this->pdo->prepare($query);
            $result = $statement->execute($values);
        } else {
            // Insert a new record if 'id' attribute is not present
            $query = "INSERT INTO $this->tableName (" . implode(',', $columns) . ") VALUES ($placeholders)";
    
            $statement = $this->pdo->prepare($query);
            $result = $statement->execute($values);
        }

        if ($result) {
            // Return the object stored in the database
            $id = isset($this->requestAttributes['id']) ? $this->requestAttributes['id'] : $this->pdo->lastInsertId();
            
            $query = "SELECT * FROM $this->tableName WHERE id=?";
            $statement = $this->pdo->prepare($query);
            $statement->execute([$id]);
            $this->requestAttributes = $statement->fetch(PDO::FETCH_ASSOC);

            return $this->requestAttributes;
            
        } else {
            return $this;
        }

        return $this;
    }


  
}
