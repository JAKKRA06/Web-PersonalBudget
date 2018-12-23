function getCurrentDate() {
	
	var getMYDate = new Date();
	
	var year = getMYDate.getFullYear();
	
	var month = getMYDate.getMonth()+1;
	if(month<10) month = "0" + month;
	
	var day = getMYDate.getDate();
	if(day<10) day = "0" + day;
	
	var dateString = year + "-" + month + "-" + day;
	document.getElementById('currentDateEx').value = dateString;

}
	var elementDateExpense = document.getElementById('currentDateEx');
	elementDateExpense.addEventListener('load', getCurrentDate(), false); 