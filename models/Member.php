<?php
class Member {

    static public function officialWebsiteLogin()
    {
        global $db;

        $sessionID = NULL;

        if (isset($_COOKIE['web_ci_session'])) {
            $web_ci_session = $_COOKIE['web_ci_session'];
            $web_ci_session = unserialize($web_ci_session);

            if (isset($web_ci_session['session_id']))
                $sessionID =  $web_ci_session['session_id'];
        }

        if (empty($sessionID)) {
            return FALSE;
        }

        $sql = "SELECT * FROM `web_ci_sessions` WHERE `session_id` = :sessionID";

        $query = $db->prepare($sql);
        $query->execute(array('sessionID' => $sessionID));

        if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $userdata = unserialize($row['user_data']);
            $custID = isset($userdata['Member']['cust_id']) ? $userdata['Member']['cust_id'] : NULL;

            // 建立新論壇會員資料
            if (! empty($custID)) {
                $characters = 32;
                $possible = '123456789abcdfghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

                do {
                    $uid = '';
                    $i = 0;

                    while ($i < $characters) {
                        $uid .= substr($possible, mt_rand(0, strlen($possible) - 1), 1);
                        $i++;
                    }

                    $sql = "SELECT * FROM `nsf_member` WHERE `uid` = :uid";
                    $query = $db->prepare($sql);
                    $query->execute(array('uid' => $uid));
                } while($query->rowCount() > 0);

                $verificationCode = '';
                $i = 0;

                while ($i < $characters) {
                    $verificationCode .= substr($possible, mt_rand(0, strlen($possible) - 1), 1);
                    $i++;
                }

                $sql = "SELECT `nsf_member`.`memberID`,
                    `nsf_member`.`admin`,
                    `nsf_member`.`status`,
                    `nsf_level`.`title`,
                    `c`.`nick_name`
                    FROM `nsf_member` 
                    INNER JOIN `".CUSTTABLE."` AS `c` ON `c`.`cust_id` = `nsf_member`.`originalCustID`
                    LEFT JOIN `nsf_level` ON `nsf_level`.`levelID` = `nsf_member`.`level`
                    WHERE `nsf_member`.`originalCustID` = :custID";
                $query = $db->prepare($sql);
                $query->execute(array('custID' => $custID));

                if ($query->rowCount() == 0) {
                    $sql = "INSERT INTO `nsf_member` 
                        (
                            `originalCustID`, 
                            `uid`, 
                            `verificationCode`,
                            `registerTime`, 
                            `lastLoginTime`
                        )
                        VALUES 
                        (
                            :custID,
                            :uid,
                            :verificationCode,
                            NOW(),
                            NOW()
                        )";
                    $query = $db->prepare($sql);
                    $query->execute(array(
                        'custID'           => $custID,
                        'uid'              => $uid,
                        'verificationCode' => $verificationCode
                    ));

                    $memberID = $db->lastInsertId();

                    $sql = "SELECT `nsf_member`.`memberID`,
                        `nsf_member`.`admin`,
                        `nsf_level`.`title`,
                        `c`.`nick_name`
                        FROM `nsf_member` 
                        INNER JOIN `".CUSTTABLE."` AS `c` ON `c`.`cust_id` = `nsf_member`.`originalCustID`
                        LEFT JOIN `nsf_level` ON `nsf_level`.`levelID` = `nsf_member`.`level`
                        WHERE `nsf_member`.`status` = 1
                        AND `nsf_member`.`memberID` = :memberID";
                    $query = $db->prepare($sql);
                    $query->execute(array('memberID' => $memberID));

                    if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        $_SESSION['nsf_member']['memberID'] = $row['memberID'];
                        $_SESSION['nsf_member']['nickName'] = $row['nick_name'];
                        $_SESSION['nsf_member']['title']    = $row['title'];
                        $_SESSION['nsf_member']['admin']    = $row['admin'];
                    }
                } else {
                    $row = $query->fetch(PDO::FETCH_ASSOC);

                    if ($row['status'] != 1)
                        return FALSE;

                    $_SESSION['nsf_member']['memberID'] = $row['memberID'];
                    $_SESSION['nsf_member']['nickName'] = $row['nick_name'];
                    $_SESSION['nsf_member']['title']    = $row['title'];
                    $_SESSION['nsf_member']['admin']    = $row['admin'];
                }
            }
        }

        return FALSE;
    }

    static public function manualLogin($email, $password)
    {
        global $db;

        $sql = "SELECT `c`.`cust_id`,
            `c`.`web_account`,
            `nsf_member`.`memberID`,
            `c`.`nick_name` AS `nickName`,
            `nsf_member`.`admin`,
            `nsf_member`.`status`,
            `nsf_level`.`title`
            FROM `".CUSTTABLE."` AS `c`
            LEFT JOIN `nsf_member` ON `nsf_member`.`originalCustID` = `c`.`cust_id`
            LEFT JOIN `nsf_level` ON `nsf_level`.`levelID` = `nsf_member`.`level`
            WHERE `c`.`web_member` = 1
            AND `c`.`web_account` = :email
            AND `c`.`web_password` = :password";

        $query = $db->prepare($sql);
        $query->execute(array(
            'email'    => $email,
            'password' => md5($password)
        ));

        if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            if (! empty($row['memberID'])) {
                if ($row['status'] != 1)
                    return FALSE;

                $_SESSION['nsf_member']['memberID'] = $row['memberID'];
                $_SESSION['nsf_member']['nickName'] = $row['nickName'];
                $_SESSION['nsf_member']['title']    = $row['title'];
                $_SESSION['nsf_member']['admin']    = $row['admin'];

                return TRUE;
            } else {
                $characters = 32;
                $possible = '123456789abcdfghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

                do {
                    $uid = '';
                    $i = 0;

                    while ($i < $characters) {
                        $uid .= substr($possible, mt_rand(0, strlen($possible) - 1), 1);
                        $i++;
                    }

                    $sql = "SELECT * FROM `nsf_member` WHERE `uid` = :uid";
                    $query = $db->prepare($sql);
                    $query->execute(array('uid' => $uid));
                } while($query->rowCount() > 0);

                $verificationCode = '';
                $i = 0;

                while ($i < $characters) {
                    $verificationCode .= substr($possible, mt_rand(0, strlen($possible) - 1), 1);
                    $i++;
                }

                $sql = "INSERT INTO `nsf_member` 
                    (
                        `originalCustID`, 
                        `uid`, 
                        `verificationCode`,
                        `registerTime`, 
                        `lastLoginTime`
                    )
                    VALUES 
                    (
                        :custID,
                        :uid,
                        :verificationCode,
                        NOW(),
                        NOW()
                    )";
                $query = $db->prepare($sql);
                $query->execute(array(
                    'custID'           => $row['cust_id'],
                    'uid'              => $uid,
                    'verificationCode' => $verificationCode
                ));

                $memberID = $db->lastInsertId();

                $sql = "SELECT `nsf_member`.`memberID`,
                    `nsf_member`.`admin`,
                    `nsf_level`.`title`,
                    `c`.`nick_name`
                    FROM `nsf_member` 
                    INNER JOIN `".CUSTTABLE."` AS `c` ON `c`.`cust_id` = `nsf_member`.`originalCustID`
                    LEFT JOIN `nsf_level` ON `nsf_level`.`levelID` = `nsf_member`.`level`
                    WHERE `nsf_member`.`status` = 1
                    AND `nsf_member`.`memberID` = :memberID";
                $query = $db->prepare($sql);
                $query->execute(array('memberID' => $memberID));

                if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    $_SESSION['nsf_member']['memberID'] = $row['memberID'];
                    $_SESSION['nsf_member']['nickName'] = $row['nick_name'];
                    $_SESSION['nsf_member']['title']    = $row['title'];
                    $_SESSION['nsf_member']['admin']    = $row['admin'];

                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    static public function getMemberInfo($memberID)
    {
        global $db;

        $sql = "SELECT `nsf_member`.`memberID`,
            `nsf_member`.`originalCustID`,
            `c`.`nick_name` AS `nickName`,
            `nsf_member`.`admin`,
            `nsf_member`.`avatar`,
            `nsf_member`.`level`,
            `nsf_member`.`replies`,
            `nsf_member`.`posts`,
            `nsf_member`.`registerTime`,
            `nsf_member`.`lastLoginTime`,
            `nsf_member`.`lastActivityTime`,
            `nsf_member`.`lastPostTime`,
            `nsf_member`.`points`,
            `nsf_member`.`coin`,
            `nsf_member`.`status`,
            `nsf_level`.`title`
            FROM `nsf_member`
            INNER JOIN `".CUSTTABLE."` AS `c` ON `c`.`cust_id` = `nsf_member`.`originalCustID`
            LEFT JOIN `nsf_level` ON `nsf_level`.`levelID` = `nsf_member`.`level`
            WHERE `nsf_member`.`memberID` = :memberID ";

        $query = $db->prepare($sql);
        $query->execute(array('memberID' => $memberID));

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    static public function getMemberRecentPosts($memberID)
    {
        global $db;

        $sql = "SELECT `nsf_topic`.*,
            `nsf_board`.`title` AS `boardTitle`,
            `nsf_board`.`description` AS `boardDesc`,
            `nsf_category`.`categoryID`,
            `nsf_category`.`title` AS `categoryTitle`,
            `nsf_category`.`description` AS `categoryDesc`,
            `c`.`nick_name` AS `nickName`
            FROM `nsf_topic` 
            INNER JOIN `nsf_board` ON `nsf_board`.`boardID` = `nsf_topic`.`boardID`
            INNER JOIN `nsf_category` ON `nsf_category`.`categoryID` = `nsf_board`.`categoryID`
            INNER JOIN `nsf_member` ON `nsf_member`.`memberID` = `nsf_topic`.`memberID`
            INNER JOIN `".CUSTTABLE."` AS `c` ON `c`.`cust_id` = `nsf_member`.`originalCustID`
            WHERE `nsf_topic`.`memberID` = :memberID
            AND `nsf_topic`.`reply` = 0
            AND `nsf_topic`.`del` = 0
            AND `nsf_board`.`status` = 1
            AND `nsf_category`.`status` = 1
            AND `nsf_category`.`visible` = 1
            AND `nsf_board`.`visible` = 1 
            ORDER BY `nsf_topic`.`topicID` DESC 
            LIMIT 0, 10";

        $query = $db->prepare($sql);
        $query->execute(array('memberID' => $memberID));

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function memberPointChange($memberID, $action)
    {
        global $db;

        switch ($action) {
            case 'post':
                $point = 1;
                $count = 10;
                $cycle = 'today';
                break;

            case 'reply':
                $point = 2;
                $count = 5;
                $cycle = 'today';
                break;

            case 'firstUpdateAvatar':
                $point = 15;
                $count = NULL;
                $cycle = NULL;
                break;

            case 'delPost':
                $point = -2;
                $count = NULL;
                $cycle = NULL;
                break;

            case 'delReply':
                $point = -1;
                $count = NULL;
                $cycle = NULL;
                break;

            case 'violation':
                $point = -10;
                $count = NULL;
                $cycle = NULL;
                break;

            default:
                $point = NULL;
                break;
        }

        if (! is_null($point)) {
            if (! is_null($count) && $cycle == 'today') {
                $sql = "SELECT * FROM `nsf_point` WHERE `memberID` = :memberID AND `action` = :action AND `changeTime` BETWEEN :changeTime1 AND :changeTime2";
                $query = $db->prepare($sql);
                $query->execute(array(
                    'memberID'    => $memberID,
                    'action'      => $action,
                    'changeTime1' => date('Y-m-d 00:00:00'),
                    'changeTime2' => date('Y-m-d 23:59:59')
                ));

                if ($query->rowCount() >= $count)
                    return FALSE;
            }

            $sql = "INSERT INTO `nsf_point` (`memberID`, `action`, `point`, `changeTime`) VALUES (:memberID, :action, :point, NOW())";
            $query = $db->prepare($sql);
            $query->execute(array(
                'memberID' => $memberID,
                'action'   => $action,
                'point'    => $point
            ));

            $sql = "UPDATE `nsf_member` SET `points` = `points` + :point, `coin` = `coin` + :point WHERE `memberID` = :memberID";
            $query = $db->prepare($sql);
            $query->execute(array(
                'memberID' => $memberID,
                'point'    => $point
            ));

            self::memberLevelCheck($memberID);
        }

    }

    static public function memberLevelCheck($memberID)
    {
        global $db;

        $i = 1;

        while($i != 0) {
            $sql = "SELECT * FROM `nsf_member` WHERE `memberID` = :memberID";
            $query = $db->prepare($sql);
            $query->execute(array('memberID' => $memberID));

            if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $level  = $row['level'];
                $points = $row['points'];

                $sql = "SELECT * FROM `nsf_level` WHERE `levelID` = :level + 1";
                $query = $db->prepare($sql);
                $query->execute(array('level' => $level));
                $row = $query->fetch(PDO::FETCH_ASSOC);

                if (! empty($row) && ! is_null($row['upgradePoint']) && $points >= $row['upgradePoint']) {
                    $sql = "UPDATE `nsf_member` SET `level` = `level` + 1 WHERE `memberID` = :memberID";
                    $query = $db->prepare($sql);
                    $query->execute(array('memberID' => $memberID));
                } else {
                    return FALSE;
                }
            }
        }
    }

    static public function sendVailMail()
    {
        global $db;

        if (! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID']))
            return FALSE;

        $sql = "SELECT `nsf_member`.`uid`,
            `nsf_member`.`verificationCode`,
            `c`.`web_account`
            FROM `nsf_member` 
            INNER JOIN `".CUSTTABLE."` AS `c` ON `c`.`cust_id` = `nsf_member`.`originalCustID`
            WHERE `nsf_member`.`memberID` = :memberID";
        $query = $db->prepare($sql);
        $query->execute(array('memberID' => $_SESSION['nsf_member']['memberID']));

        if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $url = ((empty($_SERVER['HTTPS']) OR strtolower($_SERVER['HTTPS']) === 'off') ? 'http' : 'https').'://'.$_SERVER['SERVER_NAME'].BASEPATH.'/member/verification/'.$row['uid'].'/'.$row['verificationCode'];
            $msg = '親愛的欣亞排排購會員您好：<br />請點擊或在瀏覽器中輸入以下連結來驗證您的信箱。<br /><a href="'.$url.'" target="_blank">'.$url.'</a>';

            require(dirname(__FILE__) . '/../libraries/PHPMailer/class.phpmailer.php');
            require(dirname(__FILE__) . '/../libraries/PHPMailer/class.smtp.php');

            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->CharSet  = 'UTF-8';
            $mail->Host     = '10.10.70.20';
            $mail->SMTPAuth = false;
            // $mail->Username = '';
            // $mail->Password = 's8$1p(nhs#=tvw90';
            $mail->Port     = 25;

            $mail->setFrom('system@sinya.com.tw', '欣亞排排購');
            $mail->addAddress($row['web_account']);
            $mail->isHTML(true);

            $mail->Subject  = '欣亞排排購論壇會員信箱驗證';
            $mail->Body     = $msg;

            if($mail->send())
                return TRUE;
            else
                return FALSE;            
        }

        return FALSE;

    }

    static public function verification($uid, $code)
    {
        global $db;

        $sql = "SELECT * FROM `nsf_member` WHERE `uid` = :uid";
        $query = $db->prepare($sql);
        $query->execute(array('uid' => $uid));

        if ($query->rowCount() == 0) {
            return '查無會員資料';
        }

        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($row['level'] != 1) {
            return '會員信箱已驗證';
        } else if ($code != $row['verificationCode']) {
            return '驗證資訊錯誤請重新發送驗證信';
        }

        $sql = "UPDATE `nsf_member` SET `level` = 2 WHERE `uid` = :uid AND `level` = 1";
        $query = $db->prepare($sql);
        $query->execute(array('uid' => $uid));

        return '會員信箱驗證成功';
    }

    static public function updateAvatar($avatarFilename)
    {
        global $db;

        if (! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID']))
            return FALSE;

        $sql = "SELECT `level` FROM `nsf_member` WHERE `memberID` = :memberID";
        $query = $db->prepare($sql);
        $query->execute(array('memberID' => $_SESSION['nsf_member']['memberID']));

        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($row['level'] == 1) {
            self::memberPointChange($_SESSION['nsf_member']['memberID'], 'firstUpdateAvatar');
            self::memberLevelCheck($_SESSION['nsf_member']['memberID']);
        }

        $sql = "UPDATE `nsf_member` SET `avatar` = :avatar WHERE `memberID` = :memberID";
        $query = $db->prepare($sql);
        $query->execute(array(
            'avatar'   => $avatarFilename,
            'memberID' => $_SESSION['nsf_member']['memberID']
        ));

        return TRUE;
    }

    static public function countSinyaCoupon($custID)
    {
        global $db;

        $sql = "SELECT IFNULL(SUM(`point_left`), 0) AS `totalPoint` 
            FROM `ec_sinya_coupon` 
            WHERE `state` = 1 
            AND CURDATE() >= `start_date` 
            AND CURDATE() <= `end_date` 
            AND `cust_id` = :custID";
        $query = $db->prepare($sql);
        $query->execute(array('custID' => $custID));

        return ($row = $query->fetch(PDO::FETCH_ASSOC)) ? $row['totalPoint'] : 0;
    }

    static public function exchangeSinyaCoupon($memberID, $money, $unit)
    {
        global $db;

        $memberInfo = self::getMemberInfo($memberID);

        $sql = "INSERT INTO `ec_sinya_coupon`
            (
                `category_id`, 
                `cust_id`, 
                `sell_id`, 
                `sell_order_id`, 
                `point`, 
                `point_left`, 
                `state`, 
                `start_date`, 
                `end_date`, 
                `limit_period`, 
                `stamp`, 
                `memo`
            ) 
            VALUES 
            (
                257,
                :custID,
                NULL,
                NULL,
                :money,
                :money,
                1,
                :startDate,
                :endDate,
                30,
                NOW(),
                NULL
            )";
        $query = $db->prepare($sql);
        $query->execute(array(
            'custID'    => $memberInfo['originalCustID'],
            'money'     => $money,
            'startDate' => date('Y-m-d'),
            'endDate'   => date('Y-m-d', strtotime('+30 days'))
        ));

        $sql = "UPDATE `nsf_member` SET `coin` = `coin` - :pay WHERE `memberID` = :memberID";
        $query = $db->prepare($sql);
        $query->execute(array(
            'pay'      => $money * $unit,
            'memberID' => $memberID
        ));
    }

    static public function memberVerification()
    {
        global $db;

        if (! isset($_SESSION['nsf_member']['memberID']))
            return FALSE;

        $sql = "SELECT `nsf_member`.`memberID`,
            `c`.`nick_name` AS `nickName`,
            `nsf_member`.`admin`,
            `nsf_member`.`status`,
            `nsf_level`.`title`
            FROM `nsf_member`
            INNER JOIN `".CUSTTABLE."` AS `c` ON `c`.`cust_id` = `nsf_member`.`originalCustID`
            LEFT JOIN `nsf_level` ON `nsf_level`.`levelID` = `nsf_member`.`level`
            WHERE `nsf_member`.`memberID` = :memberID";

        $query = $db->prepare($sql);
        $query->execute(array('memberID' => $_SESSION['nsf_member']['memberID']));
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if (! empty($row) && $row['status'] == 1) {
            $_SESSION['nsf_member']['memberID'] = $row['memberID'];
            $_SESSION['nsf_member']['nickName'] = $row['nickName'];
            $_SESSION['nsf_member']['title']    = $row['title'];
            $_SESSION['nsf_member']['admin']    = $row['admin'];
        } else {
            $_SESSION['nsf_member']['memberID'] = '';
            $_SESSION['nsf_member']['nickName'] = '';
            $_SESSION['nsf_member']['title']    = '';
            $_SESSION['nsf_member']['admin']    = '';

            unset($_SESSION['nsf_member']['memberID']);
            unset($_SESSION['nsf_member']['nickName']);
            unset($_SESSION['nsf_member']['title']);
            unset($_SESSION['nsf_member']['admin']);
        }

    }

}