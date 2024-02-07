<?php

namespace App\Controller;

use App\Model\Tag;
use App\Model\User;
use Slim\Http\Request;
use Slim\Http\Response;

class SearchController extends Controller
{
    public function searchView (Request $req, Response $res) {
        $flash = $this->flash->getMessages();
        $user = User::whereOne('username', '=', $_SESSION['username']);
        $tags = Tag::getAll();
        $search = User::getAll();
        foreach ($search as $key => $v) {
            $search[$key]['commonTags'] = User::commonTags($_SESSION['username'], $v['username']);
        }
        $search = User::delBlockedUser($search, $user['id']);

        return $this->view->render($res, 'search.html.twig', [
            'head_name' => $_SESSION['username'],
            'flash' => $flash,
            'tags' => $tags,
            'match' => array_values($search)
        ]);
    }

    public function searchFilter (Request $req, Response $res) {
        $user = User::whereOne('username', '=', $_SESSION['username']);
        $cat = ['popularity' => 'score', "localisation" => 'zip', 'age' => 'birthdate', 'common_tags' => 'commonTags'];
        $tags = Tag::getAll();
        $param = $req->getParams();
        $match = User::search($param);
        $match = User::delBlockedUser($match, $user['id']);

        $col = NULL;
        foreach ($cat as $key => $c) {
            if ($key === $param['orderBy'] ) {
                $col = $c;
            }
        }

        $i = 0;
        while ($match[$i]) {
            $match[$i]['age'] = User::birthdateToAge($match[$i]['birthdate']);
            if ($match[$i][$col] < $match[$i + 1][$col]) {
                $tmp = $match[$i];
                $match[$i] = $match[$i + 1];
                $match[$i + 1] =  $tmp;
                $i = -1;
            }
            ++$i;
        }


        return json_encode($match);
    }
}