<?php
class ForumLayout {
    
    static public function getIndexBoards()
    {
        global $db;

        $sql = "SELECT `nsf_board`.`boardID`,
            `nsf_board`.`title`,
            `nsf_board`.`description`,
            `nsf_board`.`iconName`,
            `nsf_board`.`posts`,
            `nsf_board`.`responses`,
            `nsf_board`.`highlight`,
            `nsf_board`.`lastUpdateTime`,
            `nsf_board`.`lastUpdateMemberID`,
            `c`.`nick_name` AS `lastUpdateNickName`,
            `nsf_category`.`categoryID`,
            `nsf_category`.`title` AS `categoryTitle`,
            `nsf_category`.`description` AS `categoryDesc`
            FROM `nsf_board` 
            INNER JOIN `nsf_category` ON `nsf_category`.`categoryID` = `nsf_board`.`categoryID`
            LEFT JOIN `nsf_member` ON `nsf_member`.`memberID` = `nsf_board`.`lastUpdateMemberID`
            LEFT JOIN `".CUSTTABLE."` AS `c` ON `c`.`cust_id` = `nsf_member`.`originalCustID`
            WHERE `nsf_board`.`status` = 1
            AND `nsf_category`.`status` = 1
            AND `nsf_category`.`visible` = 1
            AND `nsf_board`.`visible` = 1
            ORDER BY `nsf_category`.`sort`, `nsf_category`.`categoryID`, `nsf_board`.`sort`, `nsf_board`.`boardID`";

        $query = $db->prepare($sql);
        $query->execute(NULL);

        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        $boards = array();

        foreach((array)$data as $row) {
            $boards[$row['categoryID']]['categoryTitle'] = $row['categoryTitle'];
            $boards[$row['categoryID']]['categoryDesc']  = $row['categoryDesc'];
            $boards[$row['categoryID']]['boards'][]      = array(
                'boardID'            => $row['boardID'],
                'title'              => $row['title'],
                'description'        => $row['description'],
                'iconName'           => $row['iconName'],
                'posts'              => $row['posts'],
                'responses'          => $row['responses'],
                'highlight'          => $row['highlight'],
                'lastUpdateTime'     => $row['lastUpdateTime'],
                'lastUpdateMemberID' => $row['lastUpdateMemberID'],
                'lastUpdateNickName' => $row['lastUpdateNickName']
            );
        }

        return $boards;
    }
    
    static public function getServiceBoard()
    {
        global $db;

        $sql = "SELECT `nsf_board`.`boardID`,
            `nsf_board`.`title`,
            `nsf_board`.`description`,
            `nsf_board`.`iconName`,
            `nsf_board`.`posts`,
            `nsf_board`.`responses`,
            `nsf_board`.`highlight`,
            `nsf_category`.`categoryID`,
            `nsf_category`.`title` AS `categoryTitle`,
            `nsf_category`.`description` AS `categoryDesc`
            FROM `nsf_board` 
            INNER JOIN `nsf_category` ON `nsf_category`.`categoryID` = `nsf_board`.`categoryID`
            WHERE `nsf_board`.`status` = 1
            AND `nsf_category`.`status` = 1
            AND `nsf_board`.`visible` = 1
            AND `nsf_category`.`categoryID` = 4
            ORDER BY `nsf_category`.`sort`, `nsf_category`.`categoryID`, `nsf_board`.`sort`, `nsf_board`.`boardID`";

        $query = $db->prepare($sql);
        $query->execute(NULL);

        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        $boards = array();

        foreach((array)$data as $row) {
            $boards[$row['categoryID']]['categoryTitle'] = $row['categoryTitle'];
            $boards[$row['categoryID']]['categoryDesc']  = $row['categoryDesc'];
            $boards[$row['categoryID']]['boards'][]      = array(
                'boardID'     => $row['boardID'],
                'title'       => $row['title'],
                'description' => $row['description'],
                'iconName'    => $row['iconName'],
                'posts'       => $row['posts'],
                'responses'   => $row['responses'],
                'highlight'   => $row['highlight']
            );
        }

        return $boards;
    }

    static public function getIndexBanners()
    {
        global $db;

        $sql = "SELECT * FROM `nsf_banner` WHERE `position` = 'index' AND `status` = 1 ORDER BY `sort`, `bannerID`";

        $query = $db->prepare($sql);
        $query->execute(NULL);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function getLatestPost()
    {
        global $db;

        $sql = "SELECT SQL_CALC_FOUND_ROWS `nsf_topic`.`topicID`,
            `nsf_topic`.`title`
            FROM `nsf_topic` 
            INNER JOIN `nsf_board` ON `nsf_board`.`boardID` = `nsf_topic`.`boardID`
            INNER JOIN `nsf_category` ON `nsf_category`.`categoryID` = `nsf_board`.`categoryID`
            WHERE `nsf_board`.`status` = 1
            AND `nsf_category`.`status` = 1
            AND `nsf_category`.`visible` = 1
            AND `nsf_board`.`visible` = 1 
            AND `nsf_topic`.`del` = 0 
            AND `nsf_topic`.`reply` = 0
            ORDER BY `nsf_topic`.`postTime` DESC LIMIT 5";

        $query = $db->prepare($sql);
        $query->execute(NULL);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function getLatestReply()
    {
        global $db;

        $sql = "SELECT SQL_CALC_FOUND_ROWS `nsf_topic2`.`topicID`,
            `nsf_topic`.`content`
            FROM `nsf_topic` 
            INNER JOIN `nsf_topic` AS `nsf_topic2` ON `nsf_topic2`.`topicID` = `nsf_topic`.`subjectID`
            INNER JOIN `nsf_board` ON `nsf_board`.`boardID` = `nsf_topic2`.`boardID`
            INNER JOIN `nsf_category` ON `nsf_category`.`categoryID` = `nsf_board`.`categoryID`
            WHERE `nsf_board`.`status` = 1
            AND `nsf_category`.`status` = 1
            AND `nsf_category`.`visible` = 1
            AND `nsf_board`.`visible` = 1 
            AND `nsf_topic`.`del` = 0 
            AND `nsf_topic`.`reply` = 1
            ORDER BY `nsf_topic`.`postTime` DESC LIMIT 5";

        $query = $db->prepare($sql);
        $query->execute(NULL);

        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach((array)$data as $key => $row) {
            $data[$key]['totalPages'] = Topic::getRepliesTotalPages($row['topicID']);
        }

        return $data;
    }

    static public function getHotPost()
    {
        global $db;

        $sql = "SELECT SQL_CALC_FOUND_ROWS `nsf_topic`.`topicID`,
            `nsf_topic`.`title`
            FROM `nsf_topic` 
            INNER JOIN `nsf_board` ON `nsf_board`.`boardID` = `nsf_topic`.`boardID`
            INNER JOIN `nsf_category` ON `nsf_category`.`categoryID` = `nsf_board`.`categoryID`
            WHERE `nsf_board`.`status` = 1
            AND `nsf_category`.`status` = 1
            AND `nsf_category`.`visible` = 1
            AND `nsf_board`.`visible` = 1 
            AND `nsf_topic`.`del` = 0 
            AND `nsf_topic`.`reply` = 0
            AND `nsf_topic`.`postTime` >= :postTime
            ORDER BY `nsf_topic`.`views` DESC, `nsf_topic`.`postTime` DESC LIMIT 5";

        $query = $db->prepare($sql);
        $query->execute(array('postTime' => date('Y-m-d H:i:s', strtotime('-3 days'))));

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function getActiveAnnouncement()
    {
        global $db;

        $sql = "SELECT `title`, `link` FROM `nsf_announcement` WHERE `status` = 1 AND NOW() BETWEEN `startTime` AND `endTime`";

        $query = $db->prepare($sql);
        $query->execute(array('postTime' => date('Y-m-d H:i:s', strtotime('-3 days'))));

        return $query->fetchAll(PDO::FETCH_ASSOC);

    }

    static public function getModerators($categoryID)
    {
        global $db;

        $sql = "SELECT `nsf_member`.`memberID`,
            `c`.`nick_name` AS `nickName`, 
            `c`.`web_account` AS `email`
            FROM `nsf_moderator` 
            INNER JOIN `nsf_member` ON `nsf_member`.`memberID` = `nsf_moderator`.`memberID`
            INNER JOIN `".CUSTTABLE."` AS `c` ON `c`.`cust_id` = `nsf_member`.`originalCustID`
            WHERE `nsf_moderator`.`categoryID` = :categoryID 
            AND `nsf_moderator`.`boardID` = 0 ";

        $query = $db->prepare($sql);
        $query->execute(array('categoryID' => $categoryID));

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);

            $temp = array();

            foreach((array)$data as $row) {
                $temp[] = $row['nickName'];
            }

            return implode(', ', $temp);
        } else {
            return '管理員';
        }
    }

    static public function getHotSearch()
    {
        global $db;

        $sql = "SELECT `searchstr` FROM `nsf_search` WHERE `lastSearchTime` >= :lastSearchTime LIMIT 10";

        $query = $db->prepare($sql);
        $query->execute(array('lastSearchTime' => date('Y-m-d 00:00:00', strtotime('-30 days'))));

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

}