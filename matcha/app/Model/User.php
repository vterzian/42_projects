<?php

namespace App\Model;

use Slim\Http\UploadedFile;
use Geocoder\Query\ReverseQuery;

class User
{
    public static function create (
        $first_name,
        $last_name,
        $username,
        $email,
        $password,
        $token
    ) {
        $pdo = Pdo::getInstance();
        $date = new \DateTime();

        $created_at = $date->format('Y-m-d H:i:s');
        $token_date = $date->add(new \DateInterval('PT15M'));
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = $pdo->getDb()
            ->insert([
                'first_name',
                'last_name',
                'username',
                'email',
                'password',
                'token',
                'token_date',
                'active',
                'register',
                'created_at',
                'updated_at',
            ])
            ->into('user')
            ->values([
                strtolower($first_name),
                strtolower($last_name),
                strtolower($username),
                $email,
                $password,
                $token,
                $token_date->format('Y-m-d H:i:s'),
                0,
                0,
                $created_at,
                $created_at,
            ]);
        User::updatePopularity($username);

        return ($sql->execute()) ? true : false ;
    }

    public static function checkPwd ($username, $pwd)
    {
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()
            ->select()
            ->from('user')
            ->where('username', '=', $username);
        $stmt = $sql->execute();
        $data = $stmt->fetch();
        return (password_verify($pwd, $data['password']));
    }

    public static function checkactivation ($username, $token)
    {
        $date = new \DateTime('now');
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()->select()->from('user')->where('username', '=', $username);
        $stmt = $sql->execute();
        if (empty($data = $stmt->fetch()) || $data['token'] !== $token
            || $data['token_date'] <= $date->format('Y-m-d H:i:s')) {
            return false;
        }

        return true;
    }

    public static function activate ($username)
    {
        $date = new \DateTime();
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()
            ->update(['active' => 1, 'updated_at' => $date->format('Y-m-d H:i:s')])
            ->table('user')
            ->where('username', '=', $username);

        return $sql->execute();
    }

    public static function checkFile ($file)
    {
        $name = $file->file;
        if (!file_exists($name) || getimagesize($name) === false) {
            return false;
        }
        return true;
    }

    private static function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }


    public static function register ($username, $d, $files)
    {
        $pdo = Pdo::getInstance();
        $date = new \DateTime();
        $updated_at = $date->format('Y-m-d H:i:s');
        $date->setDate($d['year'], $d['month'], $d['day']);
        $f = [];
        $i = 1;
        foreach  ($files as $file) {
            if ($file->getError() === UPLOAD_ERR_OK) {
                $f['file_'.$i] = self::moveUploadedFile(__DIR__.'/../../public/img/user', $file);
            }
            $i++;
        }
        $geoloc = self::getGeoloc($d);
        $sql = $pdo->getDb()
            ->update([
                'register' => 1,
                'gender' => $d['gender'],
                'orientation' => $d['orientation'],
                'bio' => $d['bio'],
                'file_1' => $f['file_1'],
                'file_2' => $f['file_2'],
                'file_3' => $f['file_3'],
                'file_4' => $f['file_4'],
                'file_5' => $f['file_5'],
                'country' => $geoloc['country'],
                'state' => $geoloc['state'],
                'city' => $geoloc['city'],
                'zip' => $geoloc['zip'],
                'birthdate' => $date->format('Y-m-d'),
                'updated_at' => $updated_at,
            ])
            ->table('user')
            ->where('username', '=', $username);

        Tag::saveTags($d['tag']);
        User::updatePopularity($username);

        return $sql->execute();
    }

    public static function getGeoloc ($params) {
        $geoloc = [];
        if (isset($params['lat']) && !empty($params['lat']) && isset($params['lon']) && !empty($params['lon'])) {
            $httpClient = new \Http\Adapter\Guzzle6\Client();
            $provider = new \Geocoder\Provider\GoogleMaps\GoogleMaps($httpClient);
            $apiKey = 'AIzaSyDki460XK-pPNE8aYkKlHCbUFveSLPjFZw';
            $geocoder = new \Geocoder\StatefulGeocoder($provider, 'fr', $apiKey);
            $result = $geocoder->reverseQuery(ReverseQuery::fromCoordinates($params['lat'],$params['lon']));
            $geoloc['country'] = strtolower($result->get(0)->getCountry());
            $geoloc['state'] = strtolower($result->get(0)->getAdminLevels()->get(1)->getName());
            $geoloc['city'] = strtolower($result->get(0)->getLocality());
            $geoloc['zip'] = strtolower($result->get(0)->getPostalCode());

        } else {
            $ip = file_get_contents('https://api.ipify.org');
            $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
            if($query && $query['status'] == 'success')
            {
                $geoloc['country'] = strtolower($query['country']);
                $geoloc['state'] = strtolower($query['regionName']);
                $geoloc['city'] = strtolower($query['city']);
                $geoloc['zip'] = strtolower($query['zip']);
            }
        }

        return $geoloc;
    }

    public static function updateProfile ($username, $files)
    {
        $pdo = Pdo::getInstance();
        $date = new \DateTime();
        $f = '';
        foreach ($files as $file) {
            if ($file->getError() === UPLOAD_ERR_OK) {
                $f = self::moveUploadedFile(__DIR__ . '/../../public/img/user', $file);
            }
        }
        $sql = $pdo->getDb()
            ->update(['file_1' => $f, 'updated_at' => $date->format('Y-m-d H:i:s')])
            ->table('user')
            ->where('username', '=', $username);
        User::updatePopularity($username);

        return $sql->execute();
    }

    public static function updateInfo ($username, $args)
    {
        $pdo = Pdo::getInstance();
        $date = new \DateTime();
        $updated_at = $date->format('Y-m-d H:i:s');
        $date->setDate($args['year'], $args['month'], $args['day']);

        $sql = $pdo->getDb()->update([
            'first_name' => strtolower($args['first_name']),
            'last_name' => strtolower($args['last_name']),
            'username' => strtolower($args['username']),
            'email' => $args['email'],
            'birthdate' => $date->format('Y-m-d'),
            'gender' => $args['gender'],
            'orientation' => $args['orient'],
            'country' => strtolower($args['country']),
            'state' => strtolower($args['state']),
            'city' => strtolower($args['city']),
            'zip' => $args['zip'],
            'updated_at' => $updated_at,
        ])->table('user')->where('username', '=', $username);

        $_SESSION['username'] = $args['username'];
        User::updatePopularity($username);

        return $sql->execute();
    }

    public static function updateBio ($username, $bio)
    {
        $pdo = Pdo::getInstance();
        $date = new \DateTime();
        $sql = $pdo->getDb()
            ->update(['bio' => $bio, 'updated_at' => $date->format('Y-m-d H:i:s')])
            ->table('user')
            ->where('username', '=', $username);
        User::updatePopularity($username);

        return $sql->execute();
    }

    public static function updateImg ($username, $files, $i)
    {
        $pdo = Pdo::getInstance();
        $date = new \DateTime();
        foreach ($files as $file) {
            if ($file->getError() === UPLOAD_ERR_OK) {
                $f = self::moveUploadedFile(__DIR__ . '/../../public/img/user', $file);
            }
        }
        $sql = $pdo->getDb()
            ->update(['file_'.$i => $f, 'updated_at' => $date->format('Y-m-d H:i:s')])
            ->table('user')
            ->where('username', '=', $username);
        User::updatePopularity($username);

        return $sql->execute();
    }

    public static function updateScoring ($username, $score)
    {
        $date = new \DateTime();
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()
            ->update(['score' => $score, 'updated_at' => $date->format('Y-m-d H:i:s')])
            ->table('user')
            ->where('username', '=', $username);

        return $sql->execute();
    }

    /**
     * The static method updatePopularity updates popularity based on how many
     * times the user profile was liked, viewed, how many tags the user filled,
     * and how many pictures the user uploaded.
     *
     * @param string $username Username
     *
     * @return bool True on success, false otherwise
     */
    public static function updatePopularity (string $username): bool
    {
        $user = User::whereOne('username', '=', $username);

        $likes = Like::countLike($user['id']);
        $views = View::countView($user['id']);
        $tags = Tag::countTag($user['id']);
        $files = User::countFile($username);
        $score = self::getUserScore($likes, $views, $tags, $files);

        return User::updateScoring($username, $score);
    }

    /**
     * The static method getUserScore computes user score based on how many
     * times the user profile has been viewed, liked, how many tags the user
     * filled and how many files the user uploaded.
     *
     * @param int $likes How many times the user profile has been liked.
     * @param int $views How many times the user profile has been viewed.
     * @param int $tags  How many tags the user filled.
     * @param int $files How many files the user uploaded.
     *
     * @return int Score computed on data given as parameter.
     */
    private static function getUserScore(
        int $likes,
        int $views,
        int $tags,
        int $files
    ): int {
        $score = 0;

        if ($views !== 0) {
            $score = $likes * 75 / $views;
        }

        if ($tags >= 4) {
            $score += 10;
        }

        if ($files > 4) {
            $score += 15;
        }

        return $score;
    }

    public static function block ($blocker, $blocked)
    {
        $pdo = Pdo::getInstance();
        $date = new \DateTime();
        $sql = $pdo->getDb()
            ->insert(['blocker_id', 'blocked_id', 'block_date'])
            ->into('block')
            ->values([$blocker, $blocked, $date->format('Y-m-d H:i:s')]);

        return $sql->execute();
    }

    public static function unblock ($blocker, $blocked)
    {
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()
            ->delete()
            ->from('block')
            ->where('blocker_id', '=', $blocker)
            ->where('blocked_id', '=', $blocked);

        return $sql->execute();
    }

    public static function countBlock ($blockerName, $blockedName)
    {
        $blocker = self::whereOne('username', '=', $blockerName);
        $blocked = self::whereOne('username', '=', $blockedName);

        $pdo = Pdo::getInstance();

        $sql = $pdo->getDb()
            ->select()
            ->from('block')
            ->where('blocker_id', '=', $blocker['id'])
            ->where('blocked_id', '=', $blocked['id']);
        $exec = $sql->execute();

        return $exec->rowCount();
    }

    public static function matchOrient ($user, $field)
    {
        $pdo = Pdo::getInstance();

        $sql = "SELECT * FROM user WHERE username != '". $user['username'] . "' AND active = 1 AND register = 1 AND file_1 IS NOT NULL";

        if ($user['orientation'] === 1) {
            if ($user['gender'] === 1) {
                $sql = $sql . " AND (gender = 2 AND orientation IN (1, 3))";
            } elseif ($user['gender'] == 2) {
                $sql = $sql . " AND (gender = 1 AND orientation IN (1, 3))";
            }
        } elseif ($user['orientation'] === 2) {
            if ($user['gender'] === 1) {
                $sql = $sql . " AND (gender = 1 AND orientation IN (2, 3))";
            } elseif ($user['gender'] == 2) {
                $sql = $sql . " AND (gender = 2 AND orientation IN (2, 3))";
            }
        } elseif ($user['orientation'] === 3) {
            if ($user['gender'] === 1) {
                $sql = $sql . " AND ((gender = 1 AND orientation IN (2, 3)) OR (gender = 2 AND orientation IN (1, 3)))";
            } elseif ($user['gender'] === 2) {
                $sql = $sql . " AND ((gender = 1 AND orientation IN (1, 3)) OR (gender = 2 AND orientation IN (2, 3)))";
            }
        }
        $sql = (empty($field)) ? $sql : $sql . " AND " . $field . " = '" . $user[$field] . "'";
        $sql = $sql . " ORDER BY score DESC";

        $stmt = $pdo->getDb()->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetchAll();

        $i = 0;
        while ($data[$i]) {
            $data[$i]['commonTags'] = self::commonTags($_SESSION['username'], $data[$i]['username']);
            if ($i > 0 && $data[$i - 1]['score'] === $data[$i]['score'] && $data[$i - 1]['commonTags'] < $data[$i]['commonTags']) {
                $tmp = $data[$i];
                $data[$i] = $data[$i - 1];
                $data[$i - 1] = $tmp;
                $i = -1;
            }
            $i++;
        }

        return $data;
    }

    public static function commonTags ($curUser, $othUser) {
        $curUser = self::whereOne('username', '=', $curUser);
        $othUser = self::WhereOne('username', '=', $othUser);

        $curUser = Tag::uWhere('user_id', '=', $curUser['id']);
        $othUser = Tag::uWhere('user_id', '=', $othUser['id']);

        $userTag1 = [];
        $userTag2 = [];
        foreach ($curUser as $key => $value) {
            $userTag1[$key] = $value['tag_id'];
        }
        foreach ($othUser as $key => $value) {
            $userTag2[$key] = $value['tag_id'];
        }

        return count(array_intersect($userTag1, $userTag2));
    }

    public static function match ($username)
    {
        $user = self::whereOne('username', '=', $username);

        $data1 = self::matchOrient($user, 'zip');
        $data2 = self::matchOrient($user, 'state');
        $data3 = self::matchOrient($user, 'country');
        $data4 = self::matchOrient($user, NULL);

        $ret = array_map("unserialize", array_unique(array_map("serialize",array_merge($data1, $data2, $data3, $data4))));

        return $ret;
    }

    public static function search ($param)
    {
        $pdo = Pdo::getInstance();

        $sql = "SELECT * FROM user WHERE username != '" . $_SESSION['username'] ."'";

        if ((isset($param['minAge']) && !empty($param['minAge'])) || (isset($param['maxAge']) && !empty($param['maxAge']))){
            $fromDate = new \DateTime('today');
            $toDate = new \DateTime('today');

            if ((isset($param['minAge']) && !empty($param['minAge'])) && (!isset($param['maxAge']) || empty($param['maxAge']))) {
                $fromDate->sub(new \DateInterval('P'.$param['minAge'].'Y'));
                $toDate->sub(new \DateInterval('P90Y'));
            } elseif ((isset($param['maxAge']) && !empty($param['maxAge'])) && (!isset($param['minAge']) || empty($param['minAge']))) {
                $fromDate->sub(new \DateInterval('P18Y'));
                $toDate->sub(new \DateInterval('P'.$param['maxAge'].'Y'));
            } elseif ((isset($param['minAge']) && !empty($param['minAge'])) && (isset($param['maxAge']) && !empty($param['maxAge']))) {
                $fromDate->sub(new \DateInterval('P'.$param['minAge'].'Y'));
                $toDate->sub(new \DateInterval('P'.$param['maxAge'].'Y'));
            }

            $sql = $sql . " AND birthdate BETWEEN'" . $toDate->format('Y-m-d H:i:s') . "' AND '" . $fromDate->format('Y-m-d H:i:s') . "'";
        }

        if ((isset($param['minScore']) && !empty($param['minScore'])) || (isset($param['maxScore']) && !empty($param['maxScore']))) {
            $minScore = 0;
            $maxScore = 100;
            if ((isset($param['minScore']) && !empty($param['minScore'])) && (!isset($param['maxScore']) || empty($param['maxScore']))) {
                $minScore = $param['minScore'];
            } elseif ((isset($param['maxScore']) && !empty($param['maxScore'])) && (!isset($param['minScore']) || empty($param['minScore']))) {
                $maxScore = $param['maxScore'];
            } elseif ((isset($param['minScore']) && !empty($param['minScore'])) && (isset($param['maxScore']) && !empty($param['maxScore']))) {
                $minScore = $param['minScore'];
                $maxScore = $param['maxScore'];
            }
            $sql = $sql . ' AND score BETWEEN ' . $minScore . ' AND ' . $maxScore;
        }

        if (isset($param['location']) && !empty($param['location'])) {
            $sql = $sql . " AND (zip LIKE '%" . $param['location'] . "%' OR city LIKE '%" . $param['location'] . "%' OR state LIKE '%" . $param['location'] . "%' OR country LIKE '%" . $param['location'] . "%')";
        }

        if (isset($param['tags']) && !empty($param['tags'])) {
            $tags = Tag::uWhereIn('tag_id', $param['tags']);
            $usertag = '';
            foreach ($tags as $t) {
                $usertag = $usertag . $t['user_id'] . ", ";
            }
            if (!empty($usertag)) {
                $sql = $sql . " AND id IN (" . substr($usertag, 0,-2) . ")";
            } else {
                $sql = $sql . " AND id IN (0)";
            }
        }
        $exec = $pdo->getDb()->prepare($sql);
        $exec->execute();

        $ret = $exec->fetchAll();

        $i = 0;
        while ($ret[$i]) {
            $ret[$i]['commonTags'] = self::commonTags($_SESSION['username'], $ret[$i]['username']);
            $i++;
        }
        return $ret;
    }

    public static function legalAge ($params, $c) {
        $birth = new \DateTime($params['year'] . '-' . $params['month'] . '-' . $params['day']);
        if (self::birthdateToAge($birth->format("Y-m-d H:i:s")) < 18) {
            $c->flash->addMessage('birthdate', 'Must be at leat 18');

            return false;
        }

        return true;
    }

    public static function getBaseUrl()
    {
        $hostName = $_SERVER['HTTP_HOST'];
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';

        return $protocol . $hostName . "/";
    }

    public static function delBlockedUser ($match, $userId)
    {
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()
            ->select(['blocked_id'])
            ->from('block')
            ->where('blocker_id', '=', $userId);
        $exec = $sql->execute();
        $block = $exec->fetchAll();
        $blocked = [];
        foreach ($block as $key => $b)
        {
            $blocked[$key] = $b['blocked_id'];
        }

        foreach ($match as $key => $m)
        {
            if (in_array($m['id'], $blocked) || $m['active'] === 0 || $m['register'] === 0)
            {
                unset($match[$key]);
            }
        }

        return array_values($match);
    }

    public static function birthdateToAge ($date) {
        $ret = new \DateTime($date);
        $today = new \DateTime('today');

        return $ret->diff($today)->y;
    }

    public static function homeFilter ($match, $param) {

        if ((isset($param['maxAge']) && !empty($param['maxAge'])) || (isset($param['minAge']) && !empty($param['minAge']))) {
            $fromDate = new \DateTime('today');
            $toDate = new \DateTime('today');
            $minAge = 18;
            $maxAge = 90;
            if (isset($param['maxAge']) && !empty($param['maxAge']) && (!isset($param['minAge']) || empty($param['minAge']))) {
                $maxAge = $param['maxAge'];
            } elseif (isset($param['minAge']) && !empty($param['minAge']) && (!isset($param['maxAge']) || empty($param['maxAge']))) {
                $minAge = $param['minAge'];
            } elseif (isset($param['maxAge']) && !empty($param['maxAge']) && isset($param['minAge']) && !empty($param['minAge'])) {
                $minAge = $param['minAge'];
                $maxAge = $param['maxAge'];
            }
            $fromDate->sub(new \DateInterval('P'. $minAge .'Y'));
            $toDate->sub(new \DateInterval('P'. $maxAge .'Y'));
            foreach ($match as $key => $m) {
                if ($m['birthdate'] > $fromDate->format('Y-m-d H:i:s') || $m['birthdate'] < $toDate->format('Y-m-d H:i:s')) {
                    unset($match[$key]);
                }
            }
        }
        if ((isset($param['maxScore']) && !empty($param['maxScore'])) || (isset($param['minScore']) && !empty($param['minScore']))) {
            $minScore = 0;
            $maxScore = 100;
            if (isset($param['maxScore']) && !empty($param['maxScore']) && (!isset($param['minScore']) || empty($param['minScore']))) {
                $maxScore = $param['maxScore'];
            } elseif (isset($param['minScore']) && !empty($param['minScore']) && (!isset($param['maxScore']) || empty($param['maxScore']))) {
                $minScore = $param['minScore'];
            } elseif (isset($param['maxScore']) && !empty($param['maxScore']) && isset($param['minScore']) && !empty($param['minScore'])) {
                $minScore = $param['minScore'];
                $maxScore = $param['maxScore'];
            }
            foreach ($match as $key => $m) {
                if ($m['score'] < $minScore || $m['score'] > $maxScore) {
                    unset($match[$key]);
                }
            }
        }
        if (isset($param['location']) && !empty($param['location'])) {
            foreach ($match as $key => $m) {
                if (stripos($m['zip'], $param['location']) === FALSE
                    && stripos($m['city'], $param['location']) === FALSE
                    && stripos($m['state'], $param['location']) === FALSE
                    && stripos($m['country'], $param['location']) === FALSE) {
                    unset($match[$key]);
                }
            }
        }
        if (isset($param['tags']) && !empty($param['tags'])) {
            $tags = Tag::uWhereIn('tag_id', $param['tags']);
            $usertag = [];
            foreach ($tags as $t) {
                array_push($usertag, $t['user_id']);
            }
            foreach ($match as $key => $m) {
                if (!in_array($m['id'], $usertag)) {
                    unset($match[$key]);
                }
            }
        }

        return $match;
    }

    public static function getAll () {
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()->select()->from('user')->where('username', '!=', $_SESSION['username']);
        $data = $sql->execute();

        return $data->fetchAll();
    }

    public static function where ($col, $symb, $value)
    {
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()->select()->from('user')->where($col, $symb, $value);
        $data = $sql->execute();

        return $data->fetchAll();
    }

    public static function whereOne ($col, $symb, $value)
    {
        $pdo = Pdo::getInstance();
        $sql = $pdo->getDb()->select()->from('user')->where($col, $symb, $value);
        $data = $sql->execute();

        return $data->fetch();
    }

    public static function countFile ($username)
    {
        $nbr = 0;
        $user = User::whereOne('username', '=', $username);

        for ($i = 0; $i <= 5; $i++) {
            if (!empty($user['file_'.$i])) {
                $nbr++;
            }
        }

        return $nbr;
    }
}
