<?php
class Topic {
 
    static public function getTopicData($topicID)
    {
        global $db;

        $sql = "SELECT `nsf_topic`.*,
            `nsf_board`.`title` AS `boardTitle`,
            `nsf_board`.`description` AS `boardDesc`,
            `nsf_category`.`categoryID`,
            `nsf_category`.`title` AS `categoryTitle`,
            `nsf_category`.`description` AS `categoryDesc`,
            `c`.`nick_name` AS `nickName`,
            `nsf_member`.`avatar`,
            `nsf_member`.`posts` AS `memberPosts`,
            `nsf_member`.`replies` AS `memberReplies`,
            `nsf_member`.`points` AS `memberPoints`,
            `c2`.`nick_name` AS `lastUpdateMemberNickName`
            FROM `nsf_topic` 
            INNER JOIN `nsf_board` ON `nsf_board`.`boardID` = `nsf_topic`.`boardID`
            INNER JOIN `nsf_category` ON `nsf_category`.`categoryID` = `nsf_board`.`categoryID`
            INNER JOIN `nsf_member` ON `nsf_member`.`memberID` = `nsf_topic`.`memberID`
            INNER JOIN `".CUSTTABLE."` AS `c` ON `c`.`cust_id` = `nsf_member`.`originalCustID`
            LEFT JOIN `nsf_member` AS `lastUpdateMember` ON `lastUpdateMember`.`memberID` = `nsf_topic`.`lastUpdateMemberID`
            LEFT JOIN `".CUSTTABLE."` AS `c2` ON `c2`.`cust_id` = `lastUpdateMember`.`originalCustID`
            WHERE `nsf_topic`.`topicID` = :topicID
            AND `nsf_topic`.`reply` = 0
            AND `nsf_topic`.`del` = 0";

        $query = $db->prepare($sql);
        $query->execute(array('topicID' => $topicID));

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    static public function getReplyData($topicID)
    {
        global $db;

        $sql = "SELECT `nsf_topic`.*,
            CONCAT('RE:', `subject`.`title`) AS `title`,
            `nsf_board`.`title` AS `boardTitle`,
            `nsf_board`.`description` AS `boardDesc`,
            `nsf_category`.`categoryID`,
            `nsf_category`.`title` AS `categoryTitle`,
            `nsf_category`.`description` AS `categoryDesc`,
            `c`.`nick_name` AS `nickName`,
            `nsf_member`.`avatar`,
            `nsf_member`.`posts` AS `memberPosts`,
            `nsf_member`.`replies` AS `memberReplies`,
            `nsf_member`.`points` AS `memberPoints`,
            `c2`.`nick_name` AS `lastUpdateMemberNickName`
            FROM `nsf_topic` 
            INNER JOIN `nsf_topic` AS `subject` ON `subject`.`topicID` = `nsf_topic`.`subjectID`
            INNER JOIN `nsf_board` ON `nsf_board`.`boardID` = `subject`.`boardID`
            INNER JOIN `nsf_category` ON `nsf_category`.`categoryID` = `nsf_board`.`categoryID`
            INNER JOIN `nsf_member` ON `nsf_member`.`memberID` = `nsf_topic`.`memberID`
            INNER JOIN `".CUSTTABLE."` AS `c` ON `c`.`cust_id` = `nsf_member`.`originalCustID`
            LEFT JOIN `nsf_member` AS `lastUpdateMember` ON `lastUpdateMember`.`memberID` = `nsf_topic`.`lastUpdateMemberID`
            LEFT JOIN `".CUSTTABLE."` AS `c2` ON `c2`.`cust_id` = `lastUpdateMember`.`originalCustID`
            WHERE `nsf_topic`.`topicID` = :topicID
            AND `nsf_topic`.`reply` = 1
            AND `nsf_topic`.`del` = 0";

        $query = $db->prepare($sql);
        $query->execute(array('topicID' => $topicID));

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    static public function topicView($topicID)
    {
        global $db;

        $viewHistory = (isset($_SESSION['viewHistory'])) ? $_SESSION['viewHistory'] : array();

        if (in_array($topicID, $viewHistory)) {
            return FALSE;
        } else {
            $viewHistory[] = $topicID;
            $_SESSION['viewHistory'] = $viewHistory;
        }

        $sql = "UPDATE `nsf_topic` SET `views` = `views` + 1 WHERE `topicID` = :topicID";
        $query = $db->prepare($sql);
        $query->execute(array('topicID' => $topicID));

        if (isset($_SESSION['nsf_member']['memberID'])) {
            $sql = "SELECT * FROM `nsf_history` WHERE `topicID` = :topicID AND `memberID` = :memberID";
            $query = $db->prepare($sql);
            $query->execute(array(
                'topicID'  => $topicID,
                'memberID' => $_SESSION['nsf_member']['memberID']
            ));

            if ($query->rowCount() == 0) {
                $sql = "INSERT INTO `nsf_history` (`topicID`, `memberID`, `browseTime`) VALUES (:topicID, :memberID, NOW())";
                $query = $db->prepare($sql);
                $query->execute(array(
                    'topicID'  => $topicID,
                    'memberID' => $_SESSION['nsf_member']['memberID']
                ));
            }
        }

        return TRUE;
    }

    static public function browseHistory($topicID)
    {
        global $db;

        if (isset($_SESSION['nsf_member']['memberID'])) {
            $sql = "SELECT * FROM `nsf_history` WHERE `topicID` = :topicID AND `memberID` = :memberID";
            $query = $db->prepare($sql);
            $query->execute(array(
                'topicID'  => $topicID,
                'memberID' => $_SESSION['nsf_member']['memberID']
            ));

            if ($query->rowCount() > 0) {
                return TRUE;
            }
        }

        return FALSE;
    }

    static public function getReplies($topicID, $page = 1, $per = 10)
    {
        global $db;

        if ($page <= 0)
            $page = 1;

        $pageStart = ($page - 1) * $per;

        $sql = "SELECT SQL_CALC_FOUND_ROWS `nsf_topic`.*,
            `".CUSTTABLE."`.`nick_name` AS `nickName`,
            `nsf_member`.`avatar`,
            `nsf_member`.`posts` AS `memberPosts`,
            `nsf_member`.`replies` AS `memberReplies`,
            `nsf_member`.`points` AS `memberPoints`,
            `c2`.`nick_name` AS `lastUpdateMemberNickName`
            FROM `nsf_topic` 
            INNER JOIN `nsf_member` ON `nsf_member`.`memberID` = `nsf_topic`.`memberID`
            INNER JOIN `".CUSTTABLE."` ON `".CUSTTABLE."`.`cust_id` = `nsf_member`.`originalCustID`
            LEFT JOIN `nsf_member` AS `lastUpdateMember` ON `lastUpdateMember`.`memberID` = `nsf_topic`.`lastUpdateMemberID`
            LEFT JOIN `".CUSTTABLE."` AS `c2` ON `c2`.`cust_id` = `lastUpdateMember`.`originalCustID`
            WHERE `nsf_topic`.`reply` = 1
            AND `nsf_topic`.`del` = 0 
            AND `nsf_topic`.`subjectID` = :topicID
            ORDER BY `nsf_topic`.`topicID` LIMIT {$pageStart}, {$per}";

        $query = $db->prepare($sql);
        $query->execute(array('topicID' => $topicID));

        $result['list'] = $query->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT FOUND_ROWS() AS C";
        $rsCount           = $db->query($sql);
        $rowCount          = $rsCount->fetch(PDO::FETCH_ASSOC);
        $result['records'] = $rowCount['C'];
        $result['page']    = $page;
        $result['per']     = $per;

        return $result;
    }

    static public function getRepliesTotalPages($topicID, $per = 10)
    {
        global $db;

        $sql = "SELECT COUNT(*) AS `count`
            FROM `nsf_topic` 
            WHERE `nsf_topic`.`reply` = 1
            AND `nsf_topic`.`del` = 0 
            AND `nsf_topic`.`subjectID` = :topicID";

        $query = $db->prepare($sql);
        $query->execute(array('topicID' => $topicID));

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $count = (empty($row)) ? 0 : $row['count'];

        $totalPages = ceil($count / $per);

        if ($totalPages == 0)
            $totalPages = 1;

        return $totalPages;
    }

    static public function topicReview($topicID, $review)
    {
        global $db;

        if (isset($_SESSION['nsf_member']['memberID'])) {
            $sql = "SELECT * FROM `nsf_review` WHERE `topicID` = :topicID AND `memberID` = :memberID";
            $query = $db->prepare($sql);
            $query->execute(array(
                'topicID'  => $topicID,
                'memberID' => $_SESSION['nsf_member']['memberID']
            ));

            if ($query->rowCount() > 0) {
                $row = $query->fetch(PDO::FETCH_ASSOC);

                if ($row['review'] == 1) {
                    $sql = "UPDATE `nsf_topic` SET `awesome` = `awesome` - 1 WHERE `topicID` = :topicID";
                    $query = $db->prepare($sql);
                    $query->execute(array('topicID' => $topicID));
                } else {
                    $sql = "UPDATE `nsf_topic` SET `trample` = `trample` - 1 WHERE `topicID` = :topicID";
                    $query = $db->prepare($sql);
                    $query->execute(array('topicID' => $topicID));
                }
                
                $sql = "UPDATE `nsf_review` SET `review` = :review, `reviewTime` = NOW() WHERE `topicID` = :topicID AND `memberID` = :memberID";
                $query = $db->prepare($sql);
                $query->execute(array(
                    'review'   => $review,
                    'topicID'  => $topicID,
                    'memberID' => $_SESSION['nsf_member']['memberID']
                ));
            } else {
                $sql = "INSERT INTO `nsf_review` (`topicID`, `memberID`, `review`, `reviewTime`) VALUES (:topicID, :memberID, :review, NOW())";
                $query = $db->prepare($sql);
                $query->execute(array(
                    'review'   => $review,
                    'topicID'  => $topicID,
                    'memberID' => $_SESSION['nsf_member']['memberID']
                ));
            }

            if ($review == 1) {
                $sql = "UPDATE `nsf_topic` SET `awesome` = `awesome` + 1 WHERE `topicID` = :topicID";
                $query = $db->prepare($sql);
                $query->execute(array('topicID' => $topicID));
            } else {
                $sql = "UPDATE `nsf_topic` SET `trample` = `trample` + 1 WHERE `topicID` = :topicID";
                $query = $db->prepare($sql);
                $query->execute(array('topicID' => $topicID));
            }
        }
    }

    static public function getReview($topicID)
    {
        global $db;

        if (isset($_SESSION['nsf_member']['memberID'])) {
            $sql = "SELECT * FROM `nsf_review` WHERE `topicID` = :topicID AND `memberID` = :memberID";
            $query = $db->prepare($sql);
            $query->execute(array(
                'topicID'  => $topicID,
                'memberID' => $_SESSION['nsf_member']['memberID']
            ));

            if ($query->rowCount() > 0) {
                $row = $query->fetch(PDO::FETCH_ASSOC);

                return $row['review'];
            }
        }

        return NULL;
    }

    static public function topicCollection($topicID)
    {
        global $db;

        if (isset($_SESSION['nsf_member']['memberID'])) {
            $sql = "SELECT * FROM `nsf_collection` WHERE `topicID` = :topicID AND `memberID` = :memberID";
            $query = $db->prepare($sql);
            $query->execute(array(
                'topicID'  => $topicID,
                'memberID' => $_SESSION['nsf_member']['memberID']
            ));

            if ($query->rowCount() == 0) {
                $sql = "INSERT INTO `nsf_collection` (`topicID`, `memberID`, `collectionTime`) VALUES (:topicID, :memberID, NOW())";
                $query = $db->prepare($sql);
                $query->execute(array(
                    'topicID'  => $topicID,
                    'memberID' => $_SESSION['nsf_member']['memberID']
                ));
            } else {
                $sql = "DELETE FROM `nsf_collection` WHERE `topicID` = :topicID AND `memberID` = :memberID";
                $query = $db->prepare($sql);
                $query->execute(array(
                    'topicID'  => $topicID,
                    'memberID' => $_SESSION['nsf_member']['memberID']
                ));
            }
        }
    }

    static public function getCollection($topicID)
    {
        global $db;

        if (isset($_SESSION['nsf_member']['memberID'])) {
            $sql = "SELECT * FROM `nsf_collection` WHERE `topicID` = :topicID AND `memberID` = :memberID";
            $query = $db->prepare($sql);
            $query->execute(array(
                'topicID'  => $topicID,
                'memberID' => $_SESSION['nsf_member']['memberID']
            ));

            if ($query->rowCount() > 0) {
                return 1;
            }
        }

        return NULL;
    }

    static public function getLottery($topicID)
    {
        global $db;

        $sql = "SELECT `nsf_lottery`.`lotteryID`,
            `nsf_lottery_award`.`memberID`,
            `nsf_lottery_award`.`points`,
            `nsf_lottery_award`.`coin`,
            `nsf_lottery_award`.`item`,
            `c`.`nick_name` AS `nickName`
            FROM `nsf_lottery` 
            INNER JOIN `nsf_lottery_award` ON `nsf_lottery_award`.`lotteryID` = `nsf_lottery`.`lotteryID`
            INNER JOIN `nsf_member` ON `nsf_member`.`memberID` = `nsf_lottery_award`.`memberID`
            INNER JOIN `".CUSTTABLE."` AS `c` ON `c`.`cust_id` = `nsf_member`.`originalCustID`
            WHERE `topicID` = :topicID
            ORDER BY `nsf_lottery_award`.`lotteryAwardID` ASC";
        $query = $db->prepare($sql);
        $query->execute(array('topicID' => $topicID));

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function topicDelete($topicID)
    {
        global $db;

        if (isset($_SESSION['nsf_member']['memberID'])) {
            $sql = "UPDATE `nsf_topic` SET `del` = 1, `lastUpdateTime` = NOW(), `lastUpdateMemberID` = :memberID WHERE `topicID` = :topicID AND `memberID` = :memberID";
            $query = $db->prepare($sql);
            $query->execute(array(
                'topicID'  => $topicID,
                'memberID' => $_SESSION['nsf_member']['memberID']
            ));
        }
    }

}