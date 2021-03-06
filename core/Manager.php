<?php
namespace projet4\core;

class Manager {

    /**
     * @return \PDO
     */
    public function dbConnect() {
        $db = Database::getInstance();
        $req = $db->getPDO();
        return $req;
    }

    /**
     * @param $SqlStatement
     * @param $class_name
     * @param bool $fetchOnlyOne
     * @return array|mixed
     * Simple query request.
     */
    public function query($SqlStatement) {
        $req = $this->dbConnect()->query($SqlStatement);
        return $req;
    }

    /**
     * @param $SqlStatement
     * @param $attributes
     * @param bool $fetch
     * @param bool $needOnlyOne
     * @return array|bool|mixed
     * Makes a prepared request depending on whether you want to fetch or not.
     */
    public function prepare($SqlStatement, $attributes, $fetch = true, $needOnlyOne = false) {
        $req = $this->dbConnect()->prepare($SqlStatement);
        $newContent = $req->execute($attributes);
        if ($fetch) {
            if ($needOnlyOne) {
                $data = $req->fetch();
            } else {
                $data = $req->fetchAll();
            }
            return $data;
        }
        return $newContent;
    }

    /**
     * @param $table
     * @param $id
     * @return array
     * This function is used to find if a comment, post, etc exist or not.
     * If $data is empty then the controller will make an alert message.
     */
    public function exist($table, $id) {
        $SqlStatement = 'SELECT * FROM ' . $table . ' WHERE id = ?';
        $req = $this->dbConnect()->prepare($SqlStatement);
        $req->execute(array($id));
        $data = $req->fetchAll();
        return $data;
    }

}