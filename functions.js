function Get(loc, content){
	document.getElementById(loc).innerHTML=content;
}
function GetName(charnum){
	switch (charnum){
		case 0:
			return "Chel";
			break;
		case 1:
			return "Crow";
			break;
		case 2:
			return "Dauntless";
			break;
		case 3:
			return "Edge";
			break;
		case 4:
			return "Talos";
			break;
		case 5:
			return "Vlad";
			break;
		default:
			return "Error: bad input into GetName()";
	}
}
function Populate (){
	html="<table>";
	for (rows=0; rows<7; rows++){
		html=html+"<tr>";
		for (columns=0; columns<7; columns++){
			if (columns==0 && rows==0){
				html=html+"<td id=emptyvs>VS>></td>"
			}
			else if (columns==0){
				html=html+"<td id=tname"+rows+columns+" class=tname>"+GetName(rows-1)+"</td>";
			}
			else if (rows==0){
				html=html+"<td id=tname"+rows+columns+" class=tname2>"+GetName(columns-1).substr(0, 3)+"</td>";
			}
			else if (rows==columns){
				html=html+"<td id=tmatch"+rows+columns+" class=tmatchd>5.00</td>";
			}
			else{
				html=html+"<td id=tmatch"+rows+columns+" class=tmatch>5.00</td>";
			}
		}
		html=html+"</tr>";
	}
	html=html+"</table>";
	Get("curs", html);
	html="<table>";
	for (rows=0; rows<6; rows++){
		html=html+"<tr class=tierrow id=tierrow"+rows+"><td class=tiplace id=tipl"+rows+">"+(rows+1)+"</td><td class=tiname id=tin"+rows+">"+GetName(rows)+"</td><td class=tipoints id=tipo"+rows+">30.00 Points</td></tr>";
	}
	html=html+"</table>";
	Get("curt", html);
	html="<table><tr>";
	for (rows=0; rows<6; rows++){
		html=html+"<td class=pycchar onclick=PickChar("+rows+")>"+GetName(rows)+"</td>";
	}
	html=html+"</tr></table>";
	Get("pyc", html);
	html="<table>";
	for (rows=0; rows<6; rows++){
		html=html+"<tr id=rymycr"+rows+"><td id=rymyc"+rows+" class=rymyc>Your Character</td><td><img src=decr.png class=decr id=decr"+rows+" onclick=Decrement("+rows+")></img><span id=yadv"+rows+">5</span><img src=incr.png class=incr id=incr"+rows+" onclick=Increment("+rows+")></img><span id=oadv"+rows+">5</span></td><td class=ochar>"+GetName(rows)+"</td></tr>";
	}
	html=html+"</table>";
	Get("rym", html);
}
function UpdateInfo(){
	var xmlhttp = new XMLHttpRequest();
	var matchuptable;
	xmlhttp.onreadystatechange = function(){
		matchuptable=JSON.parse(xmlhttp.responseText);
	}
	xmlhttp.open("GET", "update.php", false);
	xmlhttp.send();
	for (rows=1; rows<7; rows++){
		for (columns=1; columns<7; columns++){
			Get("tmatch"+rows+columns, matchuptable[""+(rows-1)+(columns-1)]);
		}
	}
	var tierlist=[];
	var points=1.2;
	for (rows=0; rows<6; rows++){
		tierlist[rows]=["name", 0];
		tierlist[rows][0]=GetName(rows);
		for (columns=0; columns<6; columns++){
			points=parseFloat(tierlist[rows][1])+parseFloat(matchuptable[""+rows+columns]);
			tierlist[rows][1]=points.toFixed(2);
		}
	}
	tierlist.sort(function (a, b){
		return b[1]-a[1];
	});
	for (rows=0; rows<6; rows++){
		Get("tin"+rows, tierlist[rows][0]);
		Get("tipo"+rows, tierlist[rows][1]+" Points");
	}
}
function HideInput(input){
	Populate();
	input=document.getElementById("input").innerHTML;
	Get("input", "");
	return input;
}
function ShowInput(){
	Get("input", hold);
	Get("output", "");
	hold=document.getElementById("input2").innerHTML;
	Get("input2", "");
	
	
}
function PickChar(charnum){
	yourchar=charnum;
	Get("input2", hold);
	Get("pyc", "");
	Get("pych", GetName(charnum));
	for (rows=0; rows<6; rows++){
		Get("rymyc"+rows, GetName(charnum));
		if (yourchar==rows){
			Get("rymycr"+rows, "");
		}
	}
}
function Submit(){
	input=[0,[0, 0, 0, 0, 0]];
	input[0]=yourchar;
	for (rows=0; rows<6; rows++){
		if (rows==yourchar){
			input[1][rows]=5;
		}
		else{
			input[1][rows]=document.getElementById("yadv"+rows).innerHTML;
		}
	}
	window.location.href = "updatedb.php?input="+JSON.stringify(input);
}
function Increment(row){
	var mtchup=document.getElementById("yadv"+row).innerHTML;
	mtchup=parseInt(mtchup);
	if (mtchup<9){
		mtchup=mtchup+1;
		Get("yadv"+row, mtchup);
		mtchup=document.getElementById("oadv"+row).innerHTML;
		mtchup=parseInt(mtchup)-1;
		Get("oadv"+row, mtchup);
	}
}
function Decrement(row){
	var mtchup=document.getElementById("yadv"+row).innerHTML;
	mtchup=parseInt(mtchup);
	if (mtchup>1){
		mtchup=mtchup-1;
		Get("yadv"+row, mtchup);
		mtchup=document.getElementById("oadv"+row).innerHTML;
		mtchup=parseInt(mtchup)+1;
		Get("oadv"+row, mtchup);
	}
	
}
function PrintVotes(){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		document.getElementById("numov").innerHTML=xmlhttp.responseText;
	}
	xmlhttp.open("GET", "test.php", false);
	xmlhttp.send();
}
