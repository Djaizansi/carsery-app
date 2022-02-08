module.exports = function(date,format="fr"){
    if(date instanceof Date){
        let newData;
        const dd = String(date.getDate()).padStart(2, '0');
        const mm = String(date.getMonth() + 1).padStart(2, '0'); //Janvier est 0!
        const yyyy = date.getFullYear();
        if(format === "en"){
            newData = yyyy+'-'+mm+'-'+dd;
        }else{
            newData = + '/' + mm + '/' + yyyy;
        }
        return newData;
    }else {
        return {error:"La date n'est pas renseigné ou le format est mauvais"};
    }
}
