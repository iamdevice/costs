<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CostRepository extends EntityRepository
{
    public function getCurrentMonthReport()
    {
        $days_on_month = date("t");

        $categories = $this->getEntityManager()
            ->createQuery(
                'SELECT cat FROM AppBundle:CategoryEntity cat ORDER BY cat.name ASC'
            )
            ->getArrayResult();

        $costs = $this->getEntityManager()
            ->createQuery(
                'SELECT cat.category_id, cs.date_added, cs.money FROM AppBundle:CostEntity cs JOIN cs.category_id cat GROUP BY cs.category_id, cs.date_added ORDER BY cs.date_added'
            )
            ->getArrayResult();

        $head = array();

        // Заполняем заголовок сводной таблицы
        $head[0] = '';
        for ($col = 0; $col < count($categories); $col++) {
            $head[$col+1] = $categories[$col]['name'];
        }
        $head[count($categories)+1] = 'Итого';

        // Выводим строки с датами
        $body = array();
        for ($row = 1; $row <= $days_on_month; $row++) {
            $body[$row][0] = $row;
            for ($col = 0; $col < count($categories); $col++) {
                $money = '';
                foreach ($costs as $cost) {
                    if ($cost['category_id'] == $categories[$col]['category_id'] && (int)$cost['date_added']->format("d") == $row) {
                        $money = $cost['money'];
                    }
                }
                $body[$row][$col+1] = $money;
            }
            $col_total = array_sum($body[$row])-$row;
            $body[$row][count($categories)+1] = $col_total;
        }

        // Подвал с итоговыми данными
        $foot = array();
        $foot[0] = 'Итого';
        for ($col = 1; $col <= count($categories)+1; $col++) {
            $total = 0;
            for ($row = 1; $row <= $days_on_month; $row++) {
                $total += $body[$row][$col];
            }
            $foot[$col] = $total;
        }

        return array(
            'head' => $head,
            'body' => $body,
            'foot' => $foot
        );
    }
}

?>