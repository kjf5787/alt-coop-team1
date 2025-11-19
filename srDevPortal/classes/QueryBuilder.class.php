<?php
class QueryBuilder {

    // map filter names to column names
    private $filterMap = [
        'Term' => 's.term',
        'Section' => 's.section',
        'Major' => 's.major',
        'Question' => 'q.question',
        'Student' => 's.id'
    ];

    public function getFilteredData(array $filters, PDO $pdo) {
        $where = [];
        $params = [];
        $orderBy = "s.id"; // default
    
        // filters
        foreach ($this->filterMap as $key => $column) {
            if (!empty($filters[$key])) {
                $placeholders = implode(',', array_fill(0, count($filters[$key]), '?'));
                $where[] = "$column IN ($placeholders)";
                $params = array_merge($params, $filters[$key]);
            }
        }
    
        // sort
        if (!empty($filters['Sort'])) {
            $sortKey = $filters['Sort'];
            if (isset($this->filterMap[$sortKey])) {
                $orderBy = $this->filterMap[$sortKey];
            }
        }
    
        $sql = "
            SELECT 
                s.id AS student_id,
                s.preferredName AS name,
                s.major,
                s.section,
                s.term,
                q.question AS Question,
                sa.answer AS Answer
            FROM student_answers AS sa
            JOIN students AS s ON sa.student_id = s.id
            JOIN questions AS q ON sa.question_id = q.id
        ";
    
        if ($where) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }
    
        $sql .= " ORDER BY $orderBy, s.id, q.id";
    
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
