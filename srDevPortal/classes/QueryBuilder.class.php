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

        // build WHERE conditions
        foreach ($this->filterMap as $key => $column) {
            if (!empty($filters[$key])) {
                $placeholders = implode(',', array_fill(0, count($filters[$key]), '?'));
                $where[] = "$column IN ($placeholders)";
                $params = array_merge($params, $filters[$key]);
            }
        }

        $sql = "
            SELECT 
                s.id AS student_id,
                q.question AS question,
                sa.answer AS answer
            FROM student_answers AS sa
            JOIN students AS s ON sa.student_id = s.id
            JOIN questions AS q ON sa.question_id = q.id
        ";

        // add filters
        if ($where) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
