function formCheck()
{
	var f=document.forms[0], errorStr = "<ul>Неверно заполнены:", errorCounter=0, er=document.getElementById('error_msg');
	var m=new Array(); 
	// 
	
	/**************************************************/
	

	// проверяем ФИО
	m =f.elements[0].value.match(/[a-zа-я_\-.,]{2,59}/i);
	if(!m) {
		errorStr += "<li>Ф.И.О.";
		f.elements[0].className="text2 e3";
		errorCounter++;
	}
	else f.elements[0].className="text2";
	
	
	// проверяем ГОРАД
	m =f.elements[4].value.match(/[a-zа-я_\-]{2,59}/i);
	if(!m) {
		errorStr += "<li>Город";
		f.elements[4].className="text2 e3";
		errorCounter++;
	}
	else f.elements[4].className="text2";
	
	
	// проверяем КОД
	m =f.elements[5].value.match(/[0-9\(\)\s\-]{1,9}/i);
	if(!m) {
		errorStr += "<li>Телефонный код";
		f.elements[5].className="text e3";
		errorCounter++;
	}
	else f.elements[5].className="text";
	
	// проверяем ТЕЛ. НОМЕР
	m =f.elements[6].value.match(/[0-9\(\)\s\-]{3,9}/i);
	if(!m) {
		errorStr += "<li>Номер телефона";
		f.elements[6].className="text e3";
		errorCounter++;
	}
	else f.elements[6].className="text";

	// КОЛВО дней
	m=f.elements[8].value.match(/^[0-9]{1,3}$/);
	if(!m) {
		errorStr += "<li>Количество дней";
		f.elements[8].className="text e3";
		errorCounter++;
	}
	else f.elements[8].className="text";
	
	// КОЛВО ЧЕЛ
	m=f.elements[13].value.match(/^[0-9]{1,3}$/);
	if(!m) {
		errorStr += "<li>Количество человек";
		f.elements[13].className="text2 e3";
		errorCounter++;
	}
	else f.elements[13].className="text2";

	

	// проверяем email
	/*
	m =f.elements[7].value.match(/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,5}$/i);
	if(f.elements[7].value!="" && m==false) 
	{
		errorStr += "<li>Пожалуйста укажите <strong>e-mail</strong> в формате email@example.com";
		f.elements[7].className="text2 e3";
		errorCounter++;
	}
	else f.elements[7].className="text2";
	*/

	
	// проверяем проверочный код
	m=f.elements[16].value.match(/^[0-9]{4}$/);
	if(!m) {
		errorStr += "<li><strong>Проверочное число</strong>";
		f.elements[16].className="text e3";
		errorCounter++;
	}
	else f.elements[16].className="text";
	/**************************************************/
	
	if(errorCounter)
	{
		er.innerHTML = errorStr;
		er.innerHTML += "</ul>";
		er.style.display="block";
		
		top.location.href = "/armoring/#errorAnchor";
		//f.elements[errorCounter].focus();
		return false;
	}
	else {
		er.style.display="none";
		return true;
	}
}