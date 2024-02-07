<?php

namespace App\Model;

class Validator
{
    private $flash;
    private $p;
    private $inputName;
    private $error;

    public function __construct ($flash, $params) {
        $this->flash = $flash;
        $this->p = $params;
        $this->inputName = '';
        $this->error = [];
    }

    public function failed () {
        return !empty($this->error);
    }

    public function setInput ($input) {
        $this->inputName = $input;

        return $this;
    }

    public function noWhiteSpace () {
        if (strpos($this->p[$this->inputName], ' ') != FALSE
            || strpos($this->p[$this->inputName], '\t') != FALSE
            || strpos($this->p[$this->inputName], '\n') != FALSE) {
            $this->flash->addMessage($this->inputName, ucfirst(str_replace("_", " ", $this->inputName)) . " must not contain white space");
            $this->error[$this->inputName] = 1;
        }

        return $this;
    }

    public function notEmpty () {
        if (empty($this->p[$this->inputName])) {
            $this->flash->addMessage($this->inputName, ucfirst(str_replace("_", " ", $this->inputName)) . " must not be empty");
            $this->error[$this->inputName] = 1;
        }

        return $this;
    }

    public function alpha () {
        if (preg_match('/^[A-Za-zàâçéèêëîïôûùüÿñæœ .-]+$/', $this->p[$this->inputName]) === 0) {
            $this->flash->addMessage($this->inputName, ucfirst(str_replace("_", " ", $this->inputName)) . " must be alphabetic only");
            $this->error[$this->inputName] = 1;
        }

        return $this;
    }

    public function num () {
        if (preg_match('/^[0-9]*$/', $this->p[$this->inputName]) === 0) {
            $this->flash->addMessage($this->inputName, ucfirst(str_replace("_", " ", $this->inputName)) . " must be numeric only");
            $this->error[$this->inputName] = 1;
        }

        return $this;
    }

    public function password () {
        $uppercase = preg_match('@[A-Z]@', $this->p[$this->inputName]);
        $lowercase = preg_match('@[a-z]@', $this->p[$this->inputName]);
        $number    = preg_match('@[0-9]@', $this->p[$this->inputName]);

        $message = '';
        if(!$uppercase || !$lowercase || !$number || strlen($this->p[$this->inputName]) < 5) {
            if (!$uppercase) {
                $message = ucfirst(str_replace("_", " ", $this->inputName)) . " must contain at leat 1 uppercase";
            }
            if (!$lowercase) {
                $message = ucfirst(str_replace("_", " ", $this->inputName)) . " must contain at leat 1 lowercase";
            }
            if (!$number) {
                $message = ucfirst(str_replace("_", " ", $this->inputName)) . " must contain at leat 1 number";
            }
            if (strlen($this->p[$this->inputName]) < 5) {
                $message = ucfirst(str_replace("_", " ", $this->inputName)) . " must contain at leat 5 characters";
            }
            $this->flash->addMessage($this->inputName, $message);
            $this->error[$this->inputName] = 1;
        }

        return $this;
    }

    public function length ($min, $max) {
        if (strlen($this->p[$this->inputName]) < $min || strlen($this->p[$this->inputName]) > $max) {
            $this->flash->addMessage($this->inputName, ucfirst(str_replace("_", " ", $this->inputName)) . " length must be between " . $min . " and " . $max);
            $this->error[$this->inputName] = 1;
        }

        return $this;
    }

    public function equals ($str) {
        if ($this->p[$this->inputName] !== $str) {
            $this->flash->addMessage($this->inputName, ucfirst(str_replace("_", " ", $this->inputName)) . " must be equal to password");
            $this->error[$this->inputName] = 1;
        }

        return $this;
    }

    public function email () {
        if (preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $this->p[$this->inputName]) === 0) {
            $this->flash->addMessage($this->inputName, ucfirst(str_replace("_", " ", $this->inputName)) . " must have email format");
            $this->error[$this->inputName] = 1;
        }

        return $this;
    }

    public function usernameAvailable () {
        if (!empty(User::whereOne('username', '=', $this->p[$this->inputName]))) {
            $this->flash->addMessage($this->inputName, ucfirst(str_replace("_", " ", $this->inputName)) . " already exist");
            $this->error[$this->inputName] = 1;
        }

        return  $this;
    }

    public function emailAvailable () {
        if (!empty(User::whereOne('email', '=', $this->p[$this->inputName]))) {
            $this->flash->addMessage($this->inputName, ucfirst(str_replace("_", " ", $this->inputName)) . " already exist");
            $this->error[$this->inputName] = 1;
        }

        return $this;
    }

    public function userExist () {
        if (empty(User::whereOne('username', '=', $this->p[$this->inputName]))) {
            $this->flash->addMessage($this->inputName, ucfirst('wrong login'));
            $this->error[$this->inputName] = 1;
        }

        return $this;
    }
}