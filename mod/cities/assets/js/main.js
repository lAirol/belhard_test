function createAddCityForm() {
    const container = createDialogContainer();
    container.id = "dialog-container";
    const form = createForm();

    const nameField = createNameField();
    const activeField = createActiveField();
    const buttonGroup = createButtonGroup(container);

    form.append(nameField, activeField, buttonGroup);
    container.append(form);

    document.getElementById("city-dialog").appendChild(container);
}

function createEditCityForm(id,name,active) {
    const container = createDialogContainer();
    container.id = "dialog-container";
    const form = createForm();

    const nameField = createNameField(name);
    const activeField = createActiveField(active);
    const buttonGroup = createButtonGroup(container,id);

    form.append(nameField, activeField, buttonGroup);
    container.append(form);

    document.getElementById("city-dialog").appendChild(container);
}

function createDialogContainer() {
    const container = document.createElement('div');
    container.className = 'city-dialog-container';
    container.onclick = (e) => {
        (e.target === container)?container.remove(): null;
    };
    return container;
}

function createForm() {
    const form = document.createElement("div");
    form.id = "addCityForm";
    form.className = "addCityForm";
    return form;
}

function createNameField(name) {
    const nameDiv = document.createElement("div");
    nameDiv.className = "form-group";

    const nameLabel = document.createElement("label");
    nameLabel.className = "name-label";
    nameLabel.textContent = "Название города:";
    nameLabel.htmlFor = "nameInput";

    const nameInput = document.createElement("input");
    nameInput.className = "name-input";
    nameInput.type = "text";
    nameInput.id = "nameInput";
    nameInput.placeholder = "Введите название города";
    nameInput.maxLength = 225;
    nameInput.value = (name) ? name : "";

    nameDiv.append(nameLabel, nameInput);
    return nameDiv;
}

function createActiveField(active = null) {
    const activeDiv = document.createElement("div");
    activeDiv.className = "form-group-checkbox";

    const activeLabel = document.createElement("label");
    activeLabel.className = "active-label";
    activeLabel.textContent = "Активный:";
    activeLabel.htmlFor = "activeInput";

    const activeInput = document.createElement("input");
    activeInput.className = "active-input";
    activeInput.type = "checkbox";
    activeInput.id = "activeInput";
    console.log(active);
    activeInput.checked = (active != null) ? Boolean(active) :true;

    activeDiv.append(activeLabel, activeInput);
    return activeDiv;
}

function createButtonGroup(container,id= null) {
    const bntDiv = document.createElement("div");
    bntDiv.className = "button-group";

    const addButton = document.createElement("button");
    addButton.className = "addButton";
    addButton.textContent = (edit !== 0)? "Редактировать":"Добавить";
    addButton.onclick = ()=>{
        if(document.getElementById("nameInput").value !==""){
            createCity(document.getElementById("nameInput").value,document.getElementById("activeInput").checked,id);
        }else{
            document.getElementById("nameInput").focus();
        }
    };

    const cancelButton = document.createElement("button");
    cancelButton.className = "cancelButton";
    cancelButton.textContent = "Отменить";
    cancelButton.onclick = () => {
        container.remove();
    };

    bntDiv.append(addButton, cancelButton);
    return bntDiv;
}
