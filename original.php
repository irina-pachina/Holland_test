<html>
 <head>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Holland Code (RIASEC) Test
  </title>
  <style type="text/css">
   .ans_button
{
	border:2px solid #DEB887;
	background-color:#FFF8DC;
	max-width:500px;
	display:block;
	padding:5px;
	
	
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently */
}

.ans_button:hover
{
	background-color:#EFE8CC;
}

.redo_button
{
	border:2px solid #556B2F;
	background-color:#F0FFF0;
	max-width:500px;
	padding:2px;
	
	
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently */
}

.redo_button
{
	border:2px solid #556B2F;
	background-color:#F0FFF0;
	max-width:500px;
	padding:2px;
	cursor:pointer;
}

.redo_button:hover
{
	background-color:#E0EFE0;
}

.noselect
{
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently */
}
  </style>
  <script type="text/javascript">
   function shuffle(array) {
  var i = array.length;
  var t, r;

  while (0 !== i) {
    r = Math.floor(Math.random() * i);
    i -= 1;
    t = array[i];
    array[i] = array[r];
    array[r] = t;
  }

  return array;
}


var basetime = new Date();

var itemorder = ['R1', 'R2', 'R3', 'R4', 'R5', 'R6', 'R7', 'R8', 'I1', 'I2', 'I3', 'I4', 'I5', 'I6', 'I7', 'I8', 'A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'S7', 'S8', 'E1', 'E2', 'E3', 'E4', 'E5', 'E6', 'E7', 'E8', 'C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7', 'C8'];

var itemtext = 
{

"R1" : "Test the quality of parts before shipment",
"R2" : "Lay brick or tile",
"R3" : "Work on an offshore oil-drilling rig",
"R4" : "Assemble electronic parts",
"R5" : "Operate a grinding machine in a factory",
"R6" : "Fix a broken faucet",
"R7" : "Assemble products in a factory",
"R8" : "Install flooring in houses",
"I1" : "Study the structure of the human body",
"I2" : "Study animal behavior",
"I3" : "Do research on plants or animals",
"I4" : "Develop a new medical treatment or procedure",
"I5" : "Conduct biological research",
"I6" : "Study whales and other types of marine life",
"I7" : "Work in a biology lab",
"I8" : "Make a map of the bottom of an ocean",
"A1" : "Conduct a musical choir",
"A2" : "Direct a play",
"A3" : "Design artwork for magazines",
"A4" : "Write a song",
"A5" : "Write books or plays",
"A6" : "Play a musical instrument",
"A7" : "Perform stunts for a movie or television show",
"A8" : "Design sets for plays",
"S1" : "Give career guidance to people",
"S2" : "Do volunteer work at a non-profit organization",
"S3" : "Help people who have problems with drugs or alcohol",
"S4" : "Teach an individual an exercise routine",
"S5" : "Help people with family-related problems",
"S6" : "Supervise the activities of children at a camp",
"S7" : "Teach children how to read",
"S8" : "Help elderly people with their daily activities",
"E1" : "Sell restaurant franchises to individuals",
"E2" : "Sell merchandise at a department store",
"E3" : "Manage the operations of a hotel",
"E4" : "Operate a beauty salon or barber shop",
"E5" : "Manage a department within a large company",
"E6" : "Manage a clothing store",
"E7" : "Sell houses",
"E8" : "Run a toy store",
"C1" : "Generate the monthly payroll checks for an office",
"C2" : "Inventory supplies using a hand-held computer",
"C3" : "Use a computer program to generate customer bills",
"C4" : "Maintain employee records",
"C5" : "Compute and record statistical and other numerical data",
"C6" : "Operate a calculator",
"C7" : "Handle customers' bank transactions",
"C8" : "Keep shipping and receiving records"

};

var testdata = {};

var curindex = 0;
var curitem = "";

function setNextItem()
{
	curitem = itemorder[curindex];
	var itext = itemtext[curitem];

	document.getElementById("itext").innerHTML = itext;
	document.getElementById("countersign").innerHTML = (1+curindex);
	
	basetime = new Date();
	
	if(curindex > 0)
	{
		document.getElementById("undobutton").style.display = "inline";
	}
	else
	{
		document.getElementById("undobutton").style.display = "none";
	}

}

var waiting = false;

function ans_select(ans)
{
	if(!waiting)
	{
		waiting = true;
		setTimeout(function()
		{
			document.getElementById("A"+ans).checked = false;
			testdata[curitem+"A"] = ans;
			testdata[curitem+"I"] = (1+curindex);
			testdata[curitem+"E"] = new Date() - basetime;
			
			if(curindex < itemorder.length - 1)
			{
				curindex++;			
				setNextItem();
				waiting = false;
			}
			else
			{
				document.getElementById("test").style.display = "none";
				document.getElementById("testdata").value = JSON.stringify(testdata);
				document.getElementById("formdata").submit();
			}
			
		},
		175);
	}
}

function undo()
{
	if(!waiting)
	{
		waiting = true;
		setTimeout(function()
		{
			curindex--;			
			setNextItem();
			waiting = false;
		},
		75);
	}
}

function setup()
{
	shuffle(itemorder);
	setNextItem();
}

window.onload = setup;
  </script>
 </head>
 <body style="margin:0; padding:1em;background-color:#F5F5F5;">
  <table id="test" style="max-width:500px; width:100%;margin:0 auto;">
   <tr>
    <td width="20px">
    </td>
    <td style="width:100%;max-width:500px;">
     <div id="itext" style="height: 3em;">
     </div>
    </td>
   </tr>
   <tr>
    <td colspan="2">
     <label class="ans_button" onclick="ans_select(1);">
      <input id="A1" name="Q" type="radio"/>
      Dislike
     </label>
    </td>
   </tr>
   <tr>
    <td colspan="2">
     <label class="ans_button" onclick="ans_select(2);">
      <input id="A2" name="Q" type="radio"/>
      Slightly dislike
     </label>
    </td>
   </tr>
   <tr>
    <td colspan="2">
     <label class="ans_button" onclick="ans_select(3);">
      <input id="A3" name="Q" type="radio"/>
      Neutral
     </label>
    </td>
   </tr>
   <tr>
    <td colspan="2">
     <label class="ans_button" onclick="ans_select(4);">
      <input id="A4" name="Q" type="radio"/>
      Slightly enjoy
     </label>
    </td>
   </tr>
   <tr>
    <td colspan="2">
     <label class="ans_button" onclick="ans_select(5);">
      <input id="A5" name="Q" type="radio"/>
      Enjoy
     </label>
    </td>
   </tr>
   <tr>
    <td align="right" class="noselect" colspan="2">
     <br/>
     <span class="redo_button" id="undobutton" onclick="undo();" style="display:none;">
      ↻ redo last question
     </span>
     <span id="countersign">
     </span>
     / 48
    </td>
   </tr>
  </table>
  <form action="2.php" id="formdata" method="POST">
   <input id="testdata" name="testdata" type="hidden" value="">
    <input name="unqid" type="hidden" value="">
     <input name="seconds" type="hidden" value="0">
     </input>
    </input>
   </input>
  </form>
 </body>
</html>
