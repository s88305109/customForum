<?php
ini_set('memory_limit', '1024M');

use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\Finalseg;

class Post {
 
    static public function topicPost($boardID, $title, $content, $topicID)
    {
        global $db;

        require_once "./libraries/jieba-php/src/vendor/multi-array/MultiArray.php";
        require_once "./libraries/jieba-php/src/vendor/multi-array/Factory/MultiArrayFactory.php";
        require_once "./libraries/jieba-php/src/class/Jieba.php";
        require_once "./libraries/jieba-php/src/class/Finalseg.php";

        Jieba::init();
        Finalseg::init();

        $segList = Jieba::cut($title);
        $searchTitle = implode(' ', $segList);

        $handleStr = self::stripBBCode($content);
        $handleStr = str_replace(array('，', '。', '！', '？', "\r\n", "\n"), array('', '', '', '', '', ''), $handleStr);
        $segList = Jieba::cut($handleStr);
        $searchContent = implode(' ', $segList);

        $content = strip_tags($content);
        $memberID = $_SESSION['nsf_member']['memberID'];
        $firstPost = 0;

        $sql = "SELECT `posts` FROM `nsf_member` WHERE `memberID` = :memberID";
        $query = $db->prepare($sql);
        $query->execute(array('memberID' => $memberID));
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($row['posts'] == 0) {
            $firstPost = 1;
        }

        if (empty($topicID)) {
            $sql = "INSERT INTO `nsf_topic`
                (
                    `boardID`, 
                    `title`, 
                    `content`, 
                    `memberID`, 
                    `firstPost`,
                    `searchTitle`,
                    `searchContent`, 
                    `postTime`, 
                    `lastUpdateTime`,
                    `lastUpdateMemberID`
                ) 
                VALUES 
                (
                    :boardID,
                    :title,
                    :content,
                    :memberID,
                    :firstPost,
                    :searchTitle,
                    :searchContent,
                    :postTime,
                    :lastUpdateTime,
                    :lastUpdateMemberID
                )";

            $query = $db->prepare($sql);
            $query->execute(array(
                'boardID'            => $boardID,
                'title'              => $title,
                'content'            => $content,
                'memberID'           => $memberID,
                'firstPost'          => $firstPost,
                'searchTitle'        => $searchTitle,
                'searchContent'      => $searchContent,
                'postTime'           => date('Y-m-d H:i:s'),
                'lastUpdateTime'     => date('Y-m-d H:i:s'),
                'lastUpdateMemberID' => $memberID
            ));

            $sql = "UPDATE `nsf_board` SET `posts` = `posts` + 1, `lastUpdateTime` = NOW(), `lastUpdateMemberID` = :lastUpdateMemberID WHERE `boardID` = :boardID";
            $query = $db->prepare($sql);
            $query->execute(array(
                'boardID'            => $boardID,
                'lastUpdateMemberID' => $memberID
            ));

            $sql = "UPDATE `nsf_member` SET `posts` = `posts` + 1 WHERE `memberID` = :memberID";
            $query = $db->prepare($sql);
            $query->execute(array('memberID' => $memberID));

            Member::memberPointChange($memberID, 'post');
        } else {
            $sql = "UPDATE `nsf_topic` SET 
                `title` = :title, 
                `content` = :content, 
                `searchTitle` = :searchTitle, 
                `searchContent` = :searchContent, 
                `lastEditTime` = NOW() 
                WHERE `topicID` = :topicID";

            $query = $db->prepare($sql);
            $query->execute(array(
                'title'         => $title,
                'content'       => $content,
                'searchTitle'   => $searchTitle,
                'searchContent' => $searchContent,
                'topicID'       => $topicID
            ));
        }

        self::clearDraft($boardID, NULL);
    }

    static public function replyPost($topicID, $content)
    {
        global $db;

        require_once "./libraries/jieba-php/src/vendor/multi-array/MultiArray.php";
        require_once "./libraries/jieba-php/src/vendor/multi-array/Factory/MultiArrayFactory.php";
        require_once "./libraries/jieba-php/src/class/Jieba.php";
        require_once "./libraries/jieba-php/src/class/Finalseg.php";

        Jieba::init();
        Finalseg::init();

        $handleStr = self::stripBBCode($content);
        $handleStr = str_replace(array('，', '。', '！', '？', "\r\n", "\n"), array('', '', '', '', '', ''), $handleStr);
        $segList = Jieba::cut($handleStr);
        $searchContent = implode(' ', $segList);

        $content = strip_tags($content);
        $memberID = $_SESSION['nsf_member']['memberID'];

        $sql = "INSERT INTO `nsf_topic`
            (
                `reply`,
                `subjectID`,
                `title`, 
                `content`, 
                `memberID`, 
                `searchContent`, 
                `postTime`, 
                `lastUpdateTime`,
                `lastUpdateMemberID`
            ) 
            VALUES 
            (
                1,
                :subjectID,
                '',
                :content,
                :memberID,
                :searchContent,
                :postTime,
                :lastUpdateTime,
                :lastUpdateMemberID
            )";

        $query = $db->prepare($sql);
        $query->execute(array(
            'subjectID'        => $topicID,
            'content'          => $content,
            'memberID'         => $memberID,
            'searchContent'    => $searchContent,
            'postTime'         => date('Y-m-d H:i:s'),
            'lastUpdateTime'   => date('Y-m-d H:i:s'),
            'lastUpdateMemberID' => $memberID
        ));

        $sql = "UPDATE `nsf_topic` SET `replies` = `replies` + 1, `lastUpdateTime` = NOW(), `lastUpdateMemberID` = :lastUpdateMemberID WHERE `topicID` = :topicID";
        $query = $db->prepare($sql);
        $query->execute(array(
            'topicID'            => $topicID,
            'lastUpdateMemberID' => $memberID
        ));

        $sql = "SELECT `boardID` FROM `nsf_topic` WHERE `topicID` = :topicID";
        $query = $db->prepare($sql);
        $query->execute(array('topicID' => $topicID));

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $sql = "UPDATE `nsf_board` SET `responses` = `responses` + 1, `lastUpdateTime` = NOW(), `lastUpdateMemberID` = :lastUpdateMemberID WHERE `boardID` = :boardID";
        $query = $db->prepare($sql);
        $query->execute(array(
            'boardID'            => $row['boardID'],
            'lastUpdateMemberID' => $memberID
        ));

        $sql = "UPDATE `nsf_member` SET `replies` = `replies` + 1 WHERE `memberID` = :memberID";
        $query = $db->prepare($sql);
        $query->execute(array('memberID' => $memberID));

        Member::memberPointChange($memberID, 'reply');

        self::clearDraft(NULL, $topicID);
    }

    static public function stripBBCode($text_to_search) {
        $pattern = '|[[\/\!]*?[^\[\]]*?]|si';
        $replace = '';

        return preg_replace($pattern, $replace, $text_to_search);
    }

    static public function postIntervalCheck($memberID)
    {
        global $db;

        $sql = "SELECT `postTime` FROM `nsf_topic` WHERE `memberID` = :memberID ORDER BY `topicID` DESC LIMIT 1";
        $query = $db->prepare($sql);
        $query->execute(array('memberID' => $memberID));

        if ($query->rowCount() == 0) {
            return TRUE;
        }

        $row = $query->fetch(PDO::FETCH_ASSOC);

        if (time() - strtotime($row['postTime']) <= 60) {
            return FALSE;
        }

        return TRUE;
    }

    static public function saveDraft($boardID, $subjectID, $title, $content)
    {
        global $db;

        if (! isset($_SESSION['nsf_member']['memberID']))
            return FALSE;

        $title = strip_tags($title);
        $content = strip_tags($content);
        $memberID = isset($_SESSION['nsf_member']['memberID']) ? $_SESSION['nsf_member']['memberID'] : 0;

        if (empty($boardID)) 
            $boardID = NULL;

        if (empty($subjectID)) 
            $subjectID = NULL;

        $input = array();
        $input['memberID'] = $memberID;

        $sql = "SELECT * FROM `nsf_draft` WHERE `memberID` = :memberID ";

        if (! empty($boardID)) {
            $sql .= " AND `boardID` = :boardID ";
            $input['boardID'] = $boardID;
        } else
            $sql .= " AND `boardID` IS NULL ";

        if (! empty($subjectID)) {
            $sql .= " AND `subjectID` = :subjectID ";
            $input['subjectID'] = $subjectID;
        } else
            $sql .= " AND `subjectID` IS NULL ";

        $sql .= " ORDER BY `draftID` DESC LIMIT 1";

        $query = $db->prepare($sql);
        $query->execute($input);

        if ($query->rowCount() == 0) {
            $sql = "INSERT INTO `nsf_draft`
                (
                    `boardID`, 
                    `subjectID`,
                    `title`, 
                    `content`, 
                    `memberID`,
                    `saveTime`
                ) 
                VALUES 
                (
                    :boardID,
                    :subjectID,
                    :title,
                    :content,
                    :memberID,
                    :saveTime
                )";

            $query = $db->prepare($sql);
            $query->execute(array(
                'boardID'   => $boardID,
                'subjectID' => $subjectID,
                'title'     => $title,
                'content'   => $content,
                'memberID'  => $memberID,
                'saveTime'  => date('Y-m-d H:i:s')
            ));

            return TRUE;
        } else {
            $row = $query->fetch(PDO::FETCH_ASSOC);

            $sql = "UPDATE `nsf_draft` SET `title` = :title, `content` = :content, `saveTime` = :saveTime WHERE `draftID` = :draftID";
            $query = $db->prepare($sql);
            $query->execute(array(
                'title'    => $title,
                'content'  => $content,
                'saveTime' => date('Y-m-d H:i:s'),
                'draftID'  => $row['draftID']
            ));
        }
    }

    static public function clearDraft($boardID, $subjectID)
    {
        global $db;

        if (! isset($_SESSION['nsf_member']['memberID']))
            return FALSE;

        $input = array();
        $input['memberID'] = $_SESSION['nsf_member']['memberID'];

        $sql = "DELETE FROM `nsf_draft` WHERE `memberID` = :memberID ";

        if (! empty($boardID)) {
            $sql .= " AND `boardID` = :boardID ";
            $input['boardID'] = $boardID;
        } else
            $sql .= " AND `boardID` IS NULL ";

        if (! empty($subjectID)) {
            $sql .= " AND `subjectID` = :subjectID ";
            $input['subjectID'] = $subjectID;
        } else
            $sql .= " AND `subjectID` IS NULL ";

        $query = $db->prepare($sql);
        $query->execute($input);
    }

    static public function findDraft($boardID, $subjectID)
    {
        global $db;

        if (! isset($_SESSION['nsf_member']['memberID']))
            return FALSE;
        else if (empty($boardID) && empty($subjectID))
            return FALSE;

        $input = array();
        $input['memberID'] = $_SESSION['nsf_member']['memberID'];

        $sql = "SELECT * FROM `nsf_draft` WHERE `memberID` = :memberID ";

        if (! empty($boardID)) {
            $sql .= " AND `boardID` = :boardID ";
            $input['boardID'] = $boardID;
        } else
            $sql .= " AND `boardID` IS NULL ";

        if (! empty($subjectID)) {
            $sql .= " AND `subjectID` = :subjectID ";
            $input['subjectID'] = $subjectID;
        } else
            $sql .= " AND `subjectID` IS NULL ";

        $sql .= " ORDER BY `draftID` DESC LIMIT 1";

        $query = $db->prepare($sql);
        $query->execute($input);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

}