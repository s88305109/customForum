<?php
class Manage {

    static public function getMemberIdentity($boardID)
    {
        global $db;

        if (! isset($_SESSION['nsf_member']) || ! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID'])) {
            return 0;
        }

        $sql = "SELECT `admin` FROM `nsf_member` WHERE `memberID` = :memberID";
        $query = $db->prepare($sql);
        $query->execute(array('memberID' => $_SESSION['nsf_member']['memberID']));
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if (! empty($row) && $row['admin'] == 1) {
            return 999;
        }

        $sql = "SELECT `categoryID` FROM `nsf_board` WHERE `boardID` = :boardID";
        $query = $db->prepare($sql);
        $query->execute(array('boardID' => $boardID));
        $board = $query->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM `nsf_moderator` WHERE `categoryID` = :categoryID AND `boardID` = 0 AND `memberID` = :memberID";
        $query = $db->prepare($sql);
        $query->execute(array(
            'categoryID' => $board['categoryID'],
            'memberID'   => $_SESSION['nsf_member']['memberID']
        ));

        if ($query->rowCount() > 0) {
            return 2;
        }

        return 0;
    }

    static public function getActiveCategory()
    {
        global $db;

        $sql = "SELECT `categoryID`, `title`, `description` FROM `nsf_category` WHERE `status` = 1 ORDER BY `sort`, `categoryID`";

        $query = $db->prepare($sql);
        $query->execute(NULL);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function getActiveBoard($categoryID)
    {
        global $db;

        $sql = "SELECT `boardID`, `title`, `description` FROM `nsf_board` WHERE `status` = 1 AND `categoryID` = :categoryID ORDER BY `sort`, `boardID`";

        $query = $db->prepare($sql);
        $query->execute(array('categoryID' => $categoryID));

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function manageBatchMoveTopics($boardID, $topicIDs, $selectBoard)
    {
        global $db;

        foreach((array) $topicIDs as $value) {
            $sql = "SELECT `topicID`, `boardID`, `del` FROM `nsf_topic` WHERE `topicID` = :topicID";
            $query = $db->prepare($sql);
            $query->execute(array('topicID' => $value));
            $row = $query->fetch(PDO::FETCH_ASSOC);

            if ($row && $row['boardID'] == $boardID) {
                $sql = "UPDATE `nsf_topic` SET `boardID` = :selectBoard WHERE `topicID` = :topicID";
                $query = $db->prepare($sql);
                $query->execute(array(
                    'topicID'     => $value,
                    'selectBoard' => $selectBoard
                ));
            }
        }
    }

    static public function manageBatchDelTopics($boardID, $topicIDs, $cause)
    {
        global $db;

        $pointAction = ($cause) ? 'violation' : 'delPost';

        foreach((array) $topicIDs as $value) {
            $sql = "SELECT `topicID`, `boardID`, `del`, `memberID` FROM `nsf_topic` WHERE `topicID` = :topicID AND `reply` = 0";
            $query = $db->prepare($sql);
            $query->execute(array('topicID' => $value));
            $row = $query->fetch(PDO::FETCH_ASSOC);

            if ($row && $row['boardID'] == $boardID && $row['del'] == 0) {
                $sql = "UPDATE `nsf_topic` SET `boardID` = 17, `del` = 1 WHERE `topicID` = :topicID";
                $query = $db->prepare($sql);
                $query->execute(array('topicID' => $value));

                Member::memberPointChange($row['memberID'], $pointAction);
            }
        }
    }

    static public function manageBatchDelReplies($subjectID, $replies)
    {
        global $db;

        foreach((array) $replies as $value) {
            $sql = "SELECT `topicID`, `del`, `memberID` FROM `nsf_topic` WHERE `topicID` = :topicID AND `subjectID` = :subjectID AND `reply` = 1";
            $query = $db->prepare($sql);
            $query->execute(array(
                'topicID'   => $value,
                'subjectID' => $subjectID
            ));
            $row = $query->fetch(PDO::FETCH_ASSOC);

            if ($row && $row['del'] == 0) {
                $sql = "UPDATE `nsf_topic` SET `del` = 1 WHERE `topicID` = :topicID";
                $query = $db->prepare($sql);
                $query->execute(array('topicID' => $value));

                Member::memberPointChange($row['memberID'], 'delReply');
            }
        }
    }

    static public function manageSetTopicTop($topicID, $top)
    {
        global $db;

        $sql = "SELECT `topicID`, `boardID`, `del` FROM `nsf_topic` WHERE `topicID` = :topicID";
        $query = $db->prepare($sql);
        $query->execute(array('topicID' => $topicID));
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $sql = "UPDATE `nsf_topic` SET `top` = :top WHERE `topicID` = :topicID";
            $query = $db->prepare($sql);
            $query->execute(array(
                'topicID' => $topicID,
                'top'     => $top
            ));
        }
    }

    static public function lottery($topicID, $number, $points, $coin, $item)
    {
        global $db;

        $sql = "INSERT INTO `nsf_lottery`(`topicID`, `setting`, `executionTime`, `memberID`) VALUES (:topicID, :setting, NOW(), :memberID)";
        $query = $db->prepare($sql);
        $query->execute(array(
            'topicID'  => $topicID,
            'setting'  => json_encode(array($number, $coin, $item), JSON_UNESCAPED_UNICODE),
            'memberID' => $_SESSION['nsf_member']['memberID']
        ));

        $lotteryID = $db->lastInsertId();
        $exist = array(0);

        foreach((array)$number as $key => $value) {
            if (! isset($points[$key]) || ! isset($coin[$key]) || ! isset($item[$key])) 
                continue;
        
            for($i = 1; $i <= $value; $i++) {
                $sql = "SELECT `nsf_member`.`memberID`
                    FROM `nsf_topic`
                    INNER JOIN `nsf_member` ON `nsf_member`.`memberID` = `nsf_topic`.`memberID`
                    WHERE `nsf_topic`.`reply` = 1 
                    AND `nsf_topic`.`subjectID` = :topicID
                    AND `nsf_member`.`memberID` NOT IN (".implode(',', $exist).")
                    GROUP BY `nsf_member`.`memberID`
                    ORDER BY RAND()
                    LIMIT 1";
                $query = $db->prepare($sql);
                $query->execute(array('topicID' => $topicID));

                if ($query->rowCount() == 0)
                    break;

                $row = $query->fetch(PDO::FETCH_ASSOC);
                $exist[] = $row['memberID'];

                $sql = "INSERT INTO `nsf_lottery_award`(`lotteryID`, `memberID`, `points`, `coin`, `item`) VALUES (:lotteryID, :memberID, :points, :coin, :item)";
                $query = $db->prepare($sql);
                $query->execute(array(
                    'lotteryID' => $lotteryID,
                    'memberID'  => $row['memberID'],
                    'points'    => $points[$key],
                    'coin'      => $coin[$key],
                    'item'      => $item[$key]
                ));

                if (isset($points[$key]) && $points[$key] > 0) {
                    $sql = "UPDATE `nsf_member` SET `points` = `points` + :points WHERE `memberID` = :memberID";
                    $query = $db->prepare($sql);
                    $query->execute(array(
                        'memberID' => $row['memberID'],
                        'points'   => $points[$key]
                    ));
                }

                if (isset($coin[$key]) && $coin[$key] > 0) {
                    $sql = "UPDATE `nsf_member` SET `coin` = `coin` + :coin WHERE `memberID` = :memberID";
                    $query = $db->prepare($sql);
                    $query->execute(array(
                        'memberID' => $row['memberID'],
                        'coin'     => $coin[$key]
                    ));
                }
            }
        }

    }

}