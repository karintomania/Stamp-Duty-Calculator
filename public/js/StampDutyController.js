const submitForm = () => {
	const property_value = document.getElementById("value").value.toString().trim();
	console.log(property_value);
	if(property_value){
		document.stampDutyForm.submit();
	}
};
