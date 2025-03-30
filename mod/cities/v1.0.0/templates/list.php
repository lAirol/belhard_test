<link rel="stylesheet" href="/mod/cities/assets/css/main.css" type="text/css">
<link rel="stylesheet" href="/mod/cities/assets/css/dialog.css" type="text/css">
<div class="cities-table-container">
    <h2 class="cities-table-title">Список городов</h2>

    <div class="cities-add-button-container">
        <div onclick="createAddCityForm();" class="cities-add-button">Добавить город</div>
    </div>

    <table class="cities-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Состояние</th>
            <th style="width: 350px;">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cities as $city): ?>
            <tr>
                <td class="cities-table-cell"><?= htmlspecialchars($city['id']); ?></td>
                <td class="cities-table-cell name-cell"><?= htmlspecialchars($city['name']); ?></td>
                <td class="cities-table-cell">
                    <div style="font-size: 1.5rem;color: <?= htmlspecialchars($city['active'] ? 'green' : 'red', ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($city['active'] ? '✔' : '✘', ENT_QUOTES, 'UTF-8'); ?></div>
                </td>
                <td class="cities-table-cell" style="width: 350px;">
                    <div onclick="createEditCityForm(<?= htmlspecialchars($city["id"])?>,'<?= htmlspecialchars($city["name"])?>',<?= htmlspecialchars($city["active"])?>)"  class="cities-table-link">Редактировать</div>
                    <div onclick="updateActiveCity(<?= $city['id'];?>,<?= $city['active'];?>)" class="cities-table-link" style="color: <?= $city['active'] ? 'grey' : 'green'; ?>">
                        <?= $city['active'] ? 'Выкл' : 'Вкл'; ?>&#9212;
                    </div>
                    <div onclick="deleteCity(<?= htmlspecialchars($city["id"])?>)" class="cities-table-link" style="color: red">Удалить</div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="city-dialog"></div>

<script type="text/javascript" src="/mod/cities/assets/js/main.js"></script>
<script type="text/javascript" src="/mod/cities/assets/js/action.js"></script>
