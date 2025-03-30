<?php

require_once __DIR__ . "/models/CitiesModel.php";

class ModCitiesController {
    private Cities $model;

    public function __construct() {
        $this->model = new Cities();
    }

    /**
     * Основной метод обработки запросов
     * @throws Exception
     */
    public function action_index() {
        $input = file_get_contents('php://input');

        if (!$input) {
            $cities = $this->model->getCities();
            require 'templates/list.php';
        } else {
            try{
                $data = json_decode($input, true);

                if (!is_array($data) || !isset($data['action']) || !isset($data['data'])) {
                    http_response_code(400);
                    echo json_encode([
                        "result" => false,
                        "message" => "Некорректные данные запроса."
                    ]);
                    return;
                }

                if (method_exists($this, $data['action'])) {
                    $func = $data['action'];
                    header("Content-Type: application/json; charset=utf-8");
                    echo json_encode($this->$func($data['data']));
                } else {
                    http_response_code(500);
                    echo json_encode([
                        "result" => false,
                        "message" => "Метод '{$data['action']}' не существует."
                    ]);
                }
            }catch (Exception $e){
                echo json_encode([
                    "result" => false,
                    "message" => $e->getMessage()
                ]);
            }

        }
    }

    /**
     * Удаление города
     * @param array $data
     * @return array
     */
    public function deleteCity(array $data): array {
        if (!isset($data['id'])) {
            http_response_code(400);
            return [
                "result" => false,
                "message" => "ID города не указан."
            ];
        }

        $success = $this->model->deleteCity((int)$data['id']);
        if ($success) {
            return [
                "result" => true,
                "message" => "Город успешно удалён."
            ];
        } else {
            return [
                "result" => false,
                "message" => "Ошибка удаления города."
            ];
        }
    }

    /**
     * Добавление или обновление города
     * @param array $data
     * @return array
     */
    public function addCity(array $data): array {
        if (empty($data['name'])) {
            http_response_code(400);
            return [
                "result" => false,
                "message" => "Название города не указано."
            ];
        }

        $active = isset($data['active']) ? (int)$data['active'] : 1;
        $name = mb_substr($data['name'], 0, 255);
        $isUpdate = !empty($data['id']);

        $success = $isUpdate
            ? $this->model->updateCity($name, $active, (int)$data['id'])
            : $this->model->addCity($name, $active);

        if ($success) {
            return [
                "result" => true,
                "message" => $isUpdate ? "Город успешно обновлён." : "Город успешно добавлен."
            ];
        } else {
            return [
                "result" => false,
                "message" => $isUpdate ? "Ошибка обновления города." : "Ошибка добавления города."
            ];
        }
    }

    /**
     * Обновление активности города
     * @param array $data
     * @return array
     */
    public function updateActiveCity(array $data): array {
        if (!isset($data['id'], $data['active'])) {
            http_response_code(400);
            return [
                "result" => false,
                "message" => "ID или состояние 'active' не указаны."
            ];
        }

        $success = $this->model->updateActiveCity((int)$data['id'], (int)$data['active']);

        if ($success) {
            return [
                "result" => true,
                "message" => "Активность города успешно обновлена."
            ];
        } else {
            return [
                "result" => false,
                "message" => "Ошибка обновления активности города."
            ];
        }
    }
}
