module.exports = function(startDate,endDate){
    const date1 = new Date(startDate);
    const date2 = new Date(endDate);

    // To calculate the time difference of two dates
    const differenceInTime = date2.getTime() - date1.getTime();

    // To calculate the number of days between two dates
    return (differenceInTime / (1000 * 3600 * 24)) + 1;
}