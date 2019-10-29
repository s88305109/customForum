<?php
class Admin {
   
    static public function permissionValidation()
    {
        global $db;

        if (! isset($_SESSION['nsf_member']) || ! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID'])) {
            header('Location: /404');
            exit;
        }

        $sql = "SELECT `admin` FROM `nsf_member` WHERE `memberID` = :memberID";
        $query = $db->prepare($sql);
        $query->execute(array('memberID' => $_SESSION['nsf_member']['memberID']));

        $row = $query->fetch(PDO::FETCH_ASSOC);

        if (empty($row) || $row['admin'] != 1) {
            header('Location: /404');
            exit;
        }

    }

    static public function getCategoryData()
    {
        global $db;

        $sql = "SELECT * FROM `nsf_category` WHERE 1 ORDER BY `sort`, `categoryID`";

        $query = $db->prepare($sql);
        $query->execute(NULL);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    static public function getBoardData()
    {
        global $db;

        $sql = "SELECT `nsf_board`.*,
            `nsf_category`.`title` AS `categoryTitle`
            FROM `nsf_board` 
            LEFT JOIN `nsf_category` ON `nsf_category`.`categoryID` = `nsf_board`.`categoryID`
            WHERE 1
            ORDER BY `nsf_category`.`sort`, `nsf_category`.`categoryID`, `nsf_board`.`sort`, `nsf_board`.`boardID`";

        $query = $db->prepare($sql);
        $query->execute(NULL);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function getCategory($categoryID)
    {
        global $db;

        $sql = "SELECT * FROM `nsf_category` WHERE `categoryID` = :categoryID";

        $query = $db->prepare($sql);
        $query->execute(array('categoryID' => $categoryID));

        return $query->fetch(PDO::FETCH_ASSOC);
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

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function updateCategory($categoryID, $data)
    {
        global $db;

        if (empty($categoryID)) {
            $sql = "INSERT INTO `nsf_category` (`title`, `description`, `sort`, `visible`, `status`) VALUES (:title, :description, 0, :visible, :status)";

            $query = $db->prepare($sql);
            $query->execute(array(
                'title'       => $data['title'],
                'description' => $data['description'],
                'status'      => $data['status'],
                'visible'     => $data['visible']
            ));

            $categoryID = $db->lastInsertId();
        } else {
            $sql = "UPDATE `nsf_category` SET `title` = :title, `description` = :description, `visible` = :visible, `status` = :status WHERE `categoryID` = :categoryID";

            $query = $db->prepare($sql);
            $query->execute(array(
                'title'       => $data['title'],
                'description' => $data['description'],
                'visible'     => $data['visible'],
                'status'      => $data['status'],
                'categoryID'  => $categoryID
            ));
        }

        if (! isset($data['moderators']) || is_null($data['moderators']) || empty($data['moderators']) || count($data['moderators']) == 0) {
            $sql = "DELETE FROM `nsf_moderator` WHERE `categoryID` = :categoryID AND `boardID` = 0";
            $query = $db->prepare($sql);
            $query->execute(array('categoryID' => $categoryID));
        } else {
            foreach ((array) $data['moderators'] as $value) {
                $sql = "SELECT `moderatorID` FROM `nsf_moderator` WHERE `categoryID` = :categoryID AND `boardID` = 0 AND `memberID` = :memberID";
                $query = $db->prepare($sql);
                $query->execute(array(
                    'categoryID' => $categoryID,
                    'memberID'   => $value
                ));

                if ($query->rowCount() == 0) {
                    $sql = "INSERT INTO `nsf_moderator` (`categoryID`, `boardID`, `memberID`, `setTime`) VALUES (:categoryID, 0, :memberID, NOW())";
                    $query = $db->prepare($sql);
                    $query->execute(array(
                        'categoryID' => $categoryID,
                        'memberID'   => $value
                    ));
                }
            }

            $sql = "DELETE FROM `nsf_moderator` WHERE `categoryID` = :categoryID AND `boardID` = 0 AND `memberID` NOT IN (".implode(',', $data['moderators']).")";
            $query = $db->prepare($sql);
            $query->execute(array('categoryID' => $categoryID));
        }
    }

    static public function updateCategorySort($categoryID)
    {
        global $db;

        $i = 0;

        foreach((array)$categoryID as $id) {
            $sql = "UPDATE `nsf_category` SET `sort` = :sort WHERE `categoryID` = :categoryID";

            $query = $db->prepare($sql);
            $query->execute(array(
                'sort'       => $i,
                'categoryID' => $id
            ));

            $i++;
        }
    }

    static public function getBoard($boardID)
    {
        global $db;

        $sql = "SELECT * FROM `nsf_board` WHERE `boardID` = :boardID";

        $query = $db->prepare($sql);
        $query->execute(array('boardID' => $boardID));

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    static public function updateBoard($boardID, $data)
    {
        global $db;

        if (empty($boardID)) {
            $sql = "INSERT INTO `nsf_board` (`categoryID`, `title`, `description`, `sort`, `visible`, `highlight`, `status`) VALUES (:categoryID, :title, :description, 0, :visible, :highlight, :status)";

            $query = $db->prepare($sql);
            $query->execute(array(
                'categoryID'  => $data['categoryID'],
                'title'       => $data['title'],
                'description' => $data['description'],
                'status'      => $data['status'],
                'visible'     => $data['visible'],
                'highlight'   => $data['highlight']
            ));
        } else {
            $sql = "UPDATE `nsf_board` SET `categoryID` = :categoryID, `title` = :title, `description` = :description, `visible` = :visible, `highlight` = :highlight, `status` = :status WHERE `boardID` = :boardID";

            $query = $db->prepare($sql);
            $query->execute(array(
                'categoryID'  => $data['categoryID'],
                'title'       => $data['title'],
                'description' => $data['description'],
                'visible'     => $data['visible'],
                'highlight'   => $data['highlight'],
                'status'      => $data['status'],
                'boardID'     => $boardID
            ));
        }
    }

    static public function updateBoardSort($boardID)
    {
        global $db;

        $i = 0;

        foreach((array)$boardID as $id) {
            $sql = "UPDATE `nsf_board` SET `sort` = :sort WHERE `boardID` = :boardID";

            $query = $db->prepare($sql);
            $query->execute(array(
                'sort'       => $i,
                'boardID' => $id
            ));

            $i++;
        }
    }

    static public function getBannerData()
    {
        global $db;

        $sql = "SELECT * FROM `nsf_banner` WHERE 1 ORDER BY `sort`, `bannerID`";

        $query = $db->prepare($sql);
        $query->execute(NULL);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function getBanner($bannerID)
    {
        global $db;

        $sql = "SELECT * FROM `nsf_banner` WHERE `bannerID` = :bannerID";

        $query = $db->prepare($sql);
        $query->execute(array('bannerID' => $bannerID));

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    static public function updateBanner($bannerID, $data)
    {
        global $db;

        if (empty($bannerID)) {
            $sql = "INSERT INTO `nsf_banner` (`title`, `description`, `link`, `sort`, `status`, `position`) VALUES (:title, :description, :link, 0, :status, :position)";

            $query = $db->prepare($sql);
            $query->execute(array(
                'title'       => $data['title'],
                'description' => $data['description'],
                'link'        => $data['link'],
                'status'      => $data['status'],
                'position'    => $data['position']
            ));

            $id = $db->lastInsertId();
        } else {
            $sql = "UPDATE `nsf_banner` SET `title` = :title, `description` = :description, `link` = :link, `status` = :status, `position` = :position WHERE `bannerID` = :bannerID";

            $query = $db->prepare($sql);
            $query->execute(array(
                'title'       => $data['title'],
                'description' => $data['description'],
                'link'        => $data['link'],
                'status'      => $data['status'],
                'position'    => $data['position'],
                'bannerID'    => $bannerID
            ));

            $id = $bannerID;
        }

        if (isset($data['filename'])) {
            $sql = "UPDATE `nsf_banner` SET `filename` = :filename WHERE `bannerID` = :bannerID";

            $query = $db->prepare($sql);
            $query->execute(array(
                'filename' => $data['filename'],
                'bannerID' => $id
            ));
        }
    }

    static public function updateBannerSort($bannerID)
    {
        global $db;

        $i = 0;

        foreach((array)$bannerID as $id) {
            $sql = "UPDATE `nsf_banner` SET `sort` = :sort WHERE `bannerID` = :bannerID";

            $query = $db->prepare($sql);
            $query->execute(array(
                'sort'       => $i,
                'bannerID' => $id
            ));

            $i++;
        }
    }

    static public function deleteBanner($bannerID)
    {
        global $db;

        $sql = "SELECT * FROM `nsf_banner` WHERE `bannerID` = :bannerID";

        $query = $db->prepare($sql);
        $query->execute(array('bannerID' => $bannerID));

        $row = $query->fetch(PDO::FETCH_ASSOC);

        if (file_exists(dirname(__FILE__).'/../upload/banner/'.$row['filename'])) {
            unlink(dirname(__FILE__).'/../upload/banner/'.$row['filename']);
        }

        $sql = "DELETE FROM `nsf_banner` WHERE `bannerID` = :bannerID";

        $query = $db->prepare($sql);
        $query->execute(array('bannerID' => $bannerID));
    }

    static public function updateAnnouncement($announcementID, $data)
    {
        global $db;

        if (empty($announcementID)) {
            $sql = "INSERT INTO `nsf_announcement` (`title`, `link`, `startTime`, `endTime`, `status`) VALUES (:title, :link, :startTime, :endTime, :status)";

            $query = $db->prepare($sql);
            $query->execute(array(
                'title'     => $data['title'],
                'link'      => $data['link'],
                'startTime' => $data['startTime'],
                'endTime'   => $data['endTime'],
                'status'    => $data['status']
            ));

            $id = $db->lastInsertId();
        } else {
            $sql = "UPDATE `nsf_announcement` SET `title` = :title, `link` = :link, `startTime` = :startTime, `endTime` = :endTime, `status` = :status WHERE `announcementID` = :announcementID";

            $query = $db->prepare($sql);
            $query->execute(array(
                'title'          => $data['title'],
                'link'           => $data['link'],
                'startTime'      => $data['startTime'],
                'endTime'        => $data['endTime'],
                'status'         => $data['status'],
                'announcementID' => $announcementID
            ));

            $id = $announcementID;
        }
    }

    static public function getAnnouncementData()
    {
        global $db;

        $sql = "SELECT * FROM `nsf_announcement` WHERE 1 ORDER BY `announcementID`";

        $query = $db->prepare($sql);
        $query->execute(NULL);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function getAnnouncement($announcementID)
    {
        global $db;

        $sql = "SELECT * FROM `nsf_announcement` WHERE `announcementID` = :announcementID";

        $query = $db->prepare($sql);
        $query->execute(array('announcementID' => $announcementID));

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    static public function deleteAnnouncement($announcementID)
    {
        global $db;

        $sql = "DELETE FROM `nsf_announcement` WHERE `announcementID` = :announcementID";

        $query = $db->prepare($sql);
        $query->execute(array('announcementID' => $announcementID));
    }

    static public function memberSearch($email)
    {
        global $db;

        $result['msg'] = '';

        $sql = "SELECT `cust_id`, `nick_name`, `web_account` FROM `".CUSTTABLE."` WHERE `web_account` = :email";

        $query = $db->prepare($sql);
        $query->execute(array('email' => $email));

        if ($query->rowCount() == 0) {
            $result['msg'] = '此Email帳號查無會員資料';
        } else {
            $cust = $query->fetch(PDO::FETCH_ASSOC);

            $sql = "SELECT `memberID` FROM `nsf_member` WHERE `originalCustID` = :originalCustID";
            $query = $db->prepare($sql);
            $query->execute(array('originalCustID' => $cust['cust_id']));

            if ($query->rowCount() == 0) {
                $result['msg'] = '該網路會員尚未豋入過論壇 非論壇會員';
            } else {
                $member = $query->fetch(PDO::FETCH_ASSOC);

                $result['msg']      = 'OK';
                $result['memberID'] = $member['memberID'];
                $result['nickName'] = $cust['nick_name'];
                $result['email']    = $cust['web_account'];
            }
        }

        return $result;
    }

    static public function banMember($memberID)
    {
        global $db;

        $sql = "UPDATE `nsf_member` SET `status` = 0 WHERE `memberID` = :memberID AND `status` = 1 AND `admin` = 0";
        $query = $db->prepare($sql);
        $query->execute(array('memberID' => $memberID));
    }

    static public function unbanMember($memberID)
    {
        global $db;

        $sql = "UPDATE `nsf_member` SET `status` = 1 WHERE `memberID` = :memberID AND `status` = 0 AND `admin` = 0";
        $query = $db->prepare($sql);
        $query->execute(array('memberID' => $memberID));
    }

    static public function pointsAdjust($memberID, $points)
    {
        global $db;

        $sql = "SELECT * FROM `nsf_member` WHERE `memberID` = :memberID";
        $query = $db->prepare($sql);
        $query->execute(array('memberID' => $memberID));

        if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $originalPoints = $row['points'];
            $difference = $points - $originalPoints;

            $sql = "UPDATE `nsf_member` SET `points` = :points WHERE `memberID` = :memberID";
            $query = $db->prepare($sql);
            $query->execute(array(
                'memberID' => $memberID,
                'points'   => $points
            ));

            $sql = "INSERT INTO `nsf_point` (`memberID`, `action`, `point`, `changeTime`) VALUES (:memberID, :action, :point, NOW())";
            $query = $db->prepare($sql);
            $query->execute(array(
                'memberID' => $memberID,
                'action'   => 'adminAdjust',
                'point'    => $difference
            ));

            Member::memberLevelCheck($memberID);
        }
    }

    static public function coinAdjust($memberID, $coin)
    {
        global $db;

        $sql = "SELECT * FROM `nsf_member` WHERE `memberID` = :memberID";
        $query = $db->prepare($sql);
        $query->execute(array('memberID' => $memberID));

        if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $sql = "UPDATE `nsf_member` SET `coin` = :coin WHERE `memberID` = :memberID";
            $query = $db->prepare($sql);
            $query->execute(array(
                'memberID' => $memberID,
                'coin'     => $coin
            ));
        }
    }

    static public function getHotSearches()
    {
        global $db;

        $sql = "SELECT * FROM `nsf_search` WHERE `lastSearchTime` >= :lastSearchTime ORDER BY `count` DESC LIMIT 20";

        $query = $db->prepare($sql);
        $query->execute(array('lastSearchTime' => date('Y-m-d 00:00:00', strtotime('-30 days'))));

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function getSearch($searchID)
    {
        global $db;

        $sql = "SELECT * FROM `nsf_search` WHERE `searchID` = :searchID";

        $query = $db->prepare($sql);
        $query->execute(array('searchID' => $searchID));

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    static public function deleteSearch($searchID)
    {
        global $db;

        $sql = "DELETE FROM `nsf_search` WHERE `searchID` = :searchID";

        $query = $db->prepare($sql);
        $query->execute(array('searchID' => $searchID));
    }

    static public function updateSearch($data)
    {
        global $db;

        $sql = "SELECT * FROM `nsf_search` WHERE `searchstr` LIKE :searchstr";
        $query = $db->prepare($sql);
        $query->execute(array('searchstr' => $data['searchstr']));

        if ($query->rowCount() == 0) {
            $sql = "INSERT INTO `nsf_search` (`searchstr`, `count`, `lastSearchTime`) VALUES (:searchstr, :count, NOW())";

            $query = $db->prepare($sql);
            $query->execute(array(
                'searchstr' => trim($data['searchstr']),
                'count'     => $data['count']
            ));

            $id = $db->lastInsertId();
        } else {
            $sql = "UPDATE `nsf_search` SET `count` = :count, `lastSearchTime` = NOW() WHERE `searchstr` LIKE :searchstr";

            $query = $db->prepare($sql);
            $query->execute(array(
                'searchstr' => trim($data['searchstr']),
                'count'     => $data['count']
            ));
        }
    }

}