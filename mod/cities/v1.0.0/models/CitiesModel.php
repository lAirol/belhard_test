<?php

use Core2\Registry;

class Cities {

    private \Zend_Db_Adapter_Pdo_Mysql $db;

    public function __construct() {
        $reg = Registry::getInstance();
        $this->db = $reg->get("db|admin");
        //$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Получение списка городов
     * @throws Exception
     */
    public function getCities(): array {
        try {
            $query = "SELECT * FROM cities";
            return $this->db->query($query)->fetchAll();
        } catch (\Exception $e) {
            // Если таблица отсутствует, создаём её
            if ($e->getCode() === 42) {
                if ($this->createCitiesTable()) {
                    return [];
                } else {
                    throw new \Exception("Не удалось создать таблицу 'cities'.", 500, $e);
                }
            }
            // Пробрасываем другие ошибки дальше
            throw $e;
        }
    }

    /**
     * Создание таблицы "cities"
     * @return bool
     */
    public function createCitiesTable(): bool {
        $query = "
            CREATE TABLE IF NOT EXISTS cities (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                active TINYINT(1) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );
        ";

        try {
            $this->db->query($query);
            return true;
        } catch (\Exception $e) {
            error_log("Ошибка создания таблицы: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Обновление активности города
     * @param int $id
     * @param int $active
     * @return bool
     */
    public function updateActiveCity(int $id, int $active): bool {
        $query = "UPDATE cities SET active = :active WHERE id = :id";
        $smt = $this->db->prepare($query);
        $smt->bindValue(":active", $active, \PDO::PARAM_INT);
        $smt->bindValue(":id", $id, \PDO::PARAM_INT);

        return $smt->execute();
    }

    /**
     * Удаление города
     * @param int $id
     * @return bool
     */
    public function deleteCity(int $id): bool {
        $query = "DELETE FROM cities WHERE id = :id";
        $smt = $this->db->prepare($query);
        $smt->bindValue(":id", $id, \PDO::PARAM_INT);

        return $smt->execute();
    }

    /**
     * Добавление города
     * @param string $name
     * @param int $active
     * @return bool
     */
    public function addCity(string $name, int $active = 1): bool {
        $query = "INSERT INTO cities (name, active) VALUES (:name, :active)";
        $smt = $this->db->prepare($query);
        $smt->bindValue(":name", $name);
        $smt->bindValue(":active", $active, \PDO::PARAM_INT);

        return $smt->execute();
    }

    /**
     * Обновление города
     * @param string $name
     * @param int $active
     * @param int $id
     * @return bool
     */
    public function updateCity(string $name, int $active, int $id): bool {
        $query = "UPDATE cities SET name = :name, active = :active WHERE id = :id";
        $smt = $this->db->prepare($query);
        $smt->bindValue(":name", $name);
        $smt->bindValue(":active", $active, \PDO::PARAM_INT);
        $smt->bindValue(":id", $id, \PDO::PARAM_INT);

        return $smt->execute();
    }
}
