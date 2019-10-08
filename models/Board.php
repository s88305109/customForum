<?php
class Board {

    static public function getCategoryData($id)
    {
        global $db;

        $sql = "SELECT `nsf_category`.`categoryID`,
            `nsf_category`.`title` AS `categoryTitle`,
            `nsf_category`.`description` AS `categoryDesc`,
            `nsf_category`.`visible` AS `categoryVisible`
            FROM `nsf_category` 
            WHERE `nsf_category`.`status` = 1
            AND `nsf_category`.`categoryID` = :id";

        $query = $db->prepare($sql);
        $query->execute(array('id' => $id));

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    static public function getCategoryBoards($id)
    {
        global $db;

        $sql = "SELECT `nsf_board`.`boardID`,
            `nsf_board`.`title`,
            `nsf_board`.`posts`,
            `nsf_board`.`highlight`
            FROM `nsf_board` 
            INNER JOIN `nsf_category` ON `nsf_category`.`categoryID` = `nsf_board`.`categoryID`
            WHERE `nsf_board`.`status` = 1
            AND `nsf_category`.`status` = 1
            AND `nsf_category`.`visible` = 1
            AND `nsf_board`.`visible` = 1
            AND `nsf_category`.`categoryID` = :id
            ORDER BY `nsf_category`.`sort`, `nsf_category`.`categoryID`, `nsf_board`.`sort`, `nsf_board`.`boardID`";

        $query = $db->prepare($sql);
        $query->execute(array('id' => $id));

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function getBoardData($id)
    {
        global $db;

        $sql = "SELECT `nsf_board`.`boardID`,
            `nsf_board`.`title`,
            `nsf_board`.`description`,
            `nsf_board`.`iconName`,
            `nsf_board`.`posts`,
            `nsf_board`.`responses`,
            `nsf_board`.`highlight`,
            `nsf_board`.`visible`,
            `nsf_category`.`categoryID`,
            `nsf_category`.`title` AS `categoryTitle`,
            `nsf_category`.`description` AS `categoryDesc`
            FROM `nsf_board` 
            INNER JOIN `nsf_category` ON `nsf_category`.`categoryID` = `nsf_board`.`categoryID`
            WHERE `nsf_board`.`status` = 1
            AND `nsf_category`.`status` = 1
            AND `nsf_board`.`boardID` = :id";

        $query = $db->prepare($sql);
        $query->execute(array('id' => $id));

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    static public function getBoardTopics($categoryID, $boardID, $page = 1, $per = 10)
    {
        global $db;

        if ($page <= 0)
            $page = 1;

        $pageStart = ($page - 1) * $per;

        $inputs = array();

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
            AND `nsf_topic`.`reply` = 0";
        
        if (! empty($boardID)) {
            $sql .= " AND `nsf_topic`.`boardID` = :boardID ";
            $inputs['boardID'] = $boardID;
        } else {
            $sql .= " AND `nsf_category`.`categoryID` = :categoryID ";
            $inputs['categoryID'] = $categoryID;
        }

        $sql .= "ORDER BY `nsf_topic`.`top` DESC, `nsf_topic`.`lastUpdateTime` DESC, `nsf_topic`.`topicID` DESC LIMIT {$pageStart}, {$per}";

        $query = $db->prepare($sql);
        $query->execute($inputs);

        $result['list'] = $query->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT FOUND_ROWS() AS C";
        $rsCount           = $db->query($sql);
        $rowCount          = $rsCount->fetch(PDO::FETCH_ASSOC);
        $result['records'] = $rowCount['C'];
        $result['page']    = $page;
        $result['per']     = $per;

        return $result;
    }

}