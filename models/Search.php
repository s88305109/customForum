<?php
class Search {

    static public function getSearchTopics($searchstr, $page = 1, $per = 10)
    {
        global $db;

        if ($page <= 0)
            $page = 1;

        $pageStart = ($page - 1) * $per;

        $sql = "SELECT SQL_CALC_FOUND_ROWS `nsf_topic`.*,
            `c`.`nick_name` AS `nickName`,
            `c2`.`nick_name` AS `lastUpdateNickName`
            FROM `nsf_topic` 
            INNER JOIN `nsf_board` ON `nsf_board`.`boardID` = `nsf_topic`.`boardID`
            INNER JOIN `nsf_category` ON `nsf_category`.`categoryID` = `nsf_board`.`categoryID`
            INNER JOIN `nsf_member` ON `nsf_member`.`memberID` = `nsf_topic`.`memberID`
            INNER JOIN `".CUSTTABLE."` AS `c` ON `c`.`cust_id` = `nsf_member`.`originalCustID`
            INNER JOIN `nsf_member` AS `nsf_member2` ON `nsf_member2`.`memberID` = `nsf_topic`.`lastUpdateMemberID`
            INNER JOIN `".CUSTTABLE."` AS `c2` ON `c2`.`cust_id` = `nsf_member2`.`originalCustID`
            WHERE `nsf_board`.`status` = 1
            AND `nsf_category`.`status` = 1
            AND `nsf_topic`.`del` = 0
            AND `nsf_topic`.`reply` = 0
            AND 
                (
                    `nsf_topic`.`title` LIKE :likeTitle
                    OR
                    MATCH (`nsf_topic`.`searchTitle`, `nsf_topic`.`searchContent`) AGAINST (:searchstr)
                )
            ORDER BY `nsf_topic`.`lastUpdateTime` DESC, `nsf_topic`.`topicID` DESC 
            LIMIT {$pageStart}, {$per}";

        $query = $db->prepare($sql);
        $query->execute(array(
            'likeTitle' => '%'.$searchstr.'%',
            'searchstr' => $searchstr
        ));

        $result['list'] = $query->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT FOUND_ROWS() AS C";
        $rsCount           = $db->query($sql);
        $rowCount          = $rsCount->fetch(PDO::FETCH_ASSOC);
        $result['records'] = $rowCount['C'];
        $result['page']    = $page;
        $result['per']     = $per;

        self::searchHistory($searchstr);

        return $result;
    }

    static public function searchHistory($searchstr)
    {
        global $db;

        $searchHistory = (isset($_SESSION['searchHistory'])) ? $_SESSION['searchHistory'] : array();

        if (isset($searchHistory[$searchstr])) {
            return FALSE;
        } else {
            $searchHistory[$searchstr] = $searchstr;
            $_SESSION['searchHistory'] = $searchHistory;
        }

        $sql = "SELECT * FROM `nsf_search` WHERE `searchstr` = :searchstr";
        $query = $db->prepare($sql);
        $query->execute(array('searchstr' => $searchstr));

        if ($query->rowCount() == 0) {
            $sql = "INSERT INTO `nsf_search` (`searchstr`, `count`, `lastSearchTime`) VALUES (:searchstr, 1, NOW())";
            $query = $db->prepare($sql);
            $query->execute(array('searchstr' => $searchstr));
        } else {
            $sql = "UPDATE `nsf_search` SET `count` = `count` + 1, `lastSearchTime` = NOW() WHERE `searchstr` = :searchstr";
            $query = $db->prepare($sql);
            $query->execute(array('searchstr' => $searchstr));
        }

        return TRUE;
    }

}