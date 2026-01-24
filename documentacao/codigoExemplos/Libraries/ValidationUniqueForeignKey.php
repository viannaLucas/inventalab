<?php

namespace App\Libraries;
use Config\Database;

class ValidationUniqueForeignKey {
    
    /**
     * 
     * Check if combination coluns and values not exists in table.
     * 
     * Example: 
     *  Table OrderProduct contain two foreign keys Order_id and Product_id
     *  and you dont want two register of same product in one order
     *  the validation can be writen: 
     * 
     *  "uniqueFK[OrderProduct.Order_id,OrderProduct.Product_id]"
     */
    public function uniqueFK(?string $str, string $field, array $data): bool {
        $cols = [];
        foreach (explode(',', $field) as $ci) {
            sscanf($ci, '%[^.].%[^.]', $table, $ct);
            $cols[$ct] = is_array($data) ? $data[$ct] : $data->$ct;
        }
        return Database::connect($data['DBGroup'] ?? null)
                ->table($table)
                ->where($cols)
                ->select('1')
                ->limit(1)
                ->get()
                ->getRow() === null;
    }

}
