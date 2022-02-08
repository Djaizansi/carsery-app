function createOption(value="",name,select=null, defaultOption = false){
    const createOption = document.createElement('option');
    if(value !== ""){
        createOption.value = value;
    }
    createOption.text = name;
    if(defaultOption){
        createOption.setAttribute("default","");
        createOption.setAttribute("selected","");
        createOption.setAttribute("disabled","");
    }
    if(select !== null){
        select.add(createOption);
    }else{
        return createOption;
    }
}

function resetSelect(select){
    for (let i = select.length - 1; i >= 0; i--) {
        select.remove(i);
    }
}

module.exports = {
    createOption: createOption,
    resetSelect: resetSelect,
}