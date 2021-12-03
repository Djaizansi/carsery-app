function resetObject(object) {
    Object.keys(object).forEach(key => object[key] = '');
}

module.exports = resetObject;
