/*====================================================
	- HTML Table Filter Generator v1.1
	- développé par Max Guglielmi
	- mguglielmi.free.fr/scripts/TableFilter/?l=fr
	- Prière de conserver ce message
=====================================================*/

var TblId, StartRow, SearchFlt;
TblId = new Array, StartRow = new Array;

var protocole;

function setProtocole(i)
{
    protocole = i;
}

function setFilterGrid(id)
/*====================================================
	- vérifie que l'id passé en param existe bien et
	que c'est bein une table
	- vérifie la présence d'autres paramètres
	- appel de la fonction qui ajoute les inputs et
	le bouton
=====================================================*/
{
	var tbl = document.getElementById(id);
	var ref_row, fObj;
	if(tbl != null && tbl.nodeName.toLowerCase() == "table")
	{
		TblId.push(id);
		if(arguments.length>1)
		{
			for(var i=0; i<arguments.length; i++)
			{
				var argtype = typeof arguments[i];
				
				switch(argtype.toLowerCase()){
					case "number":
						ref_row = arguments[i];
					break;
					case "object":
						fObj = arguments[i];
					break;
				}//switch			
			}//for
		}//if
		
		ref_row == undefined ? StartRow.push(2) : StartRow.push(ref_row+2);
		var ncells = getCellsNb(id,ref_row);
                
                AddRow(id,ncells,fObj)
	}
}

function AddRow(id,n,f)
/*====================================================
	- ajoute un filtre (input ou select) pour chaque 
	colonne
	- ajoute le bouton dans la dernière colonne
=====================================================*/
{
    switch(protocole)
    {
        case 1:
        {
            var t = document.getElementById(id);
            var fltrow = t.insertRow(0);
            var inpclass;

            for(var i=0; i<n; i++)
            {
                    var fltcell = fltrow.insertCell(i);
                    i==n-1 ? inpclass = "flt_s" : inpclass = "flt";

                    if(f==undefined || f["col_"+i]==undefined || f["col_"+i]=="none") 
                    {
                        var inp = document.createElement("input");		
                        inp.setAttribute("id","flt"+i+"_"+id);

                        if(f==undefined || f["col_"+i]==undefined) inp.setAttribute("type","text");
                        else inp.setAttribute("type","hidden");

                        //inp.setAttribute("class","flt"); //ne marche pas sur ie<=6

                        fltcell.appendChild(inp);
                        document.getElementById("flt"+i+"_"+id).className = inpclass;
                        document.getElementById("flt"+i+"_"+id).onkeyup = DetectKey;   

                        if(i == n - 2)
                            document.getElementById("flt"+i+"_"+id).style.display="none";
                    }
                    else if(f["col_"+i]=="select")
                    {
                            var slc = document.createElement("select");
                            slc.setAttribute("id","flt"+i+"_"+id);
                            fltcell.appendChild(slc);
                            PopulateOptions(id,i,n);
                            document.getElementById("flt"+i+"_"+id).className = inpclass;
                            document.getElementById("flt"+i+"_"+id).onchange = DetectKey;
                    }

                    if(i==n-1) // ajout du bouton
                    {
                            document.getElementById("flt"+i+"_"+id).style.display="none";
                            /*var btn = document.createElement("a");

                            btn.setAttribute("id","btn"+i+"_"+id);
                            btn.setAttribute("href","javascript:Filter('"+id+"');");
                            btn.setAttribute("class","go");
                            fltcell.appendChild(btn);
                            btn.appendChild(document.createTextNode("Go"));

                            document.getElementById("btn"+i+"_"+id).className = "btn";
                            */
                    }//if		

            }// for i
            break;
        }
        case 2:
        {
            var t = document.getElementById(id);
            var fltrow = t.insertRow(0);
            var inpclass;

            for(var i=0; i<n; i++)
            {
                    var fltcell = fltrow.insertCell(i);
                    i==n-1 ? inpclass = "flt_s" : inpclass = "flt";

                    if(f==undefined || f["col_"+i]==undefined || f["col_"+i]=="none") 
                    {
                        var inp = document.createElement("input");		
                        inp.setAttribute("id","flt"+i+"_"+id);

                        if(f==undefined || f["col_"+i]==undefined) inp.setAttribute("type","text");
                        else inp.setAttribute("type","hidden");

                        //inp.setAttribute("class","flt"); //ne marche pas sur ie<=6

                        fltcell.appendChild(inp);
                        document.getElementById("flt"+i+"_"+id).className = inpclass;
                        document.getElementById("flt"+i+"_"+id).onkeyup = DetectKey;   
                    }
                    else if(f["col_"+i]=="select")
                    {
                            var slc = document.createElement("select");
                            slc.setAttribute("id","flt"+i+"_"+id);
                            fltcell.appendChild(slc);
                            PopulateOptions(id,i,n);
                            document.getElementById("flt"+i+"_"+id).className = inpclass;
                            document.getElementById("flt"+i+"_"+id).onchange = DetectKey;
                    }

                    if(i==n-1) // ajout du bouton
                    {
                            document.getElementById("flt"+i+"_"+id).style.display="none";
                            /*var btn = document.createElement("a");

                            btn.setAttribute("id","btn"+i+"_"+id);
                            btn.setAttribute("href","javascript:Filter('"+id+"');");
                            btn.setAttribute("class","go");
                            fltcell.appendChild(btn);
                            btn.appendChild(document.createTextNode("Go"));

                            document.getElementById("btn"+i+"_"+id).className = "btn";
                            */
                    }//if		

            }// for i
            break;
        }
    }
}

function PopulateOptions(id,cellIndex,ncells)
/*====================================================
	- ajoute les option au select
	- ne rajoute qu'une seule instance d'une valeur
=====================================================*/
{
	var t = document.getElementById(id);
	var start_row = getStartRow(id);
	var row = t.getElementsByTagName("tr");
	var OptArray = new Array;
	var optIndex = 0; // option index
	
	for(var k=start_row; k<row.length; k++)
	{
		var cell = getChildElms(row[k]).childNodes;
		var nchilds = cell.length;
		
		if(nchilds == ncells){// checks if row has exact cell #
			
			for(var j=0; j<nchilds; j++)// this loop retrieves cell data
			{
				if(cellIndex==j)
				{
					var cell_data = getCellText(cell[j]);
					if(OptArray.toString().search(cell_data) == -1)
					// checks if celldata is already in array
					{
						optIndex++;
						OptArray.push(cell_data);
						var currOpt = new Option(cell_data,cell_data,false,false);
						document.getElementById("flt"+cellIndex+"_"+id).options[optIndex] = currOpt;
					}
				}//if cellIndex==j
			}//for j
			
		}//if
		
	}//for k
}

function Filter(id)
/*====================================================
	- récupère les chaines recherchés dans le array 
	SearchFlt
	- récupère le contenu des td de chaque tr et 
	le compare à la chaine recherché dans la colonne
	courante
	- le tr est caché si toutes les chaines ne sont 
	pas trouvé
=====================================================*/
{	      
	getFilters(id);
	var t = document.getElementById(id);
	var SearchArgs = new Array();
	var ncells = getCellsNb(id);
	
	for(i in SearchFlt) SearchArgs.push((document.getElementById(SearchFlt[i]).value).toLowerCase());
	
	var start_row = getStartRow(id);
	var row = t.getElementsByTagName("tr");
	
	for(var k=start_row; k<row.length; k++)
	{	
		/*** si la table a été déjà filtré certaines lignes ne sont pas visibles ***/
		if(row[k].style.display == "none") row[k].style.display = "";
		
		var cell = getChildElms(row[k]).childNodes;
		var nchilds = cell.length;

		if(nchilds == ncells){// vérife que la ligne a le nombre exact de cellules
			var cell_value = new Array();
			var occurence = new Array();
			var isRowValid = false;
				
			for(var j=0; j<nchilds; j++)// cette boucle récupère le contenu de la cellule
			{
				var cell_data = getCellText(cell[j]).toLowerCase();
				cell_value.push(cell_data);
				
				if(SearchArgs[j]!="")
				{                 
                                        var sTmp;
                                        
                                        //Split sur un espace si contient "nom prénom"
                                        var tabTmp = cell_data.split(" ");
                                        
                                        for(var l = 0; l < tabTmp.length; l++)
                                        {
                                            sTmp = tabTmp[l].substr(0, SearchArgs[j].length);

                                            if(sTmp == SearchArgs[j])
                                                isRowValid = true;
                                        }
                                        
                                        if(isRowValid==false) row[k].style.display = "none";
                                        else row[k].style.display = "";
				}
			}
                }		
	}// for k
}

function getCellsNb(id,nrow)
/*====================================================
	- renvoie le nombre de cellules d'une ligne
	- si nrow est passé en paramètre, renvoie le 
	nombre de cellules de la ligne specifiée
=====================================================*/
{
  	var t = document.getElementById(id);
	var tr;
	if(nrow == undefined) tr = t.getElementsByTagName("tr")[0];
	else  tr = t.getElementsByTagName("tr")[nrow];
	var n = getChildElms(tr);
	return n.childNodes.length;
}

function getFilters(id)
/*====================================================
	- les id des filtres (input) sont gardés dans le
	array SearchFlt
=====================================================*/
{
	SearchFlt = new Array;
	var t = document.getElementById(id);
	var tr = t.getElementsByTagName("tr")[0];
	var enfants = tr.childNodes;
	for(var i=0; i<enfants.length; i++)
        {
              SearchFlt.push(enfants[i].firstChild.getAttribute("id"));
        }
}

function getStartRow(id)
/*====================================================
	- renvoie la ligne de réference d'un tableau
=====================================================*/
{
	var r;
	for(j in TblId)
	{
		if(TblId[j] == id) r = StartRow[j];
	}
	return r;
}

function getChildElms(n)
/*====================================================
	- vérifie que le noeud est bien un 
	(ELEMENT_NODE nodeType=1)
	- Enlève les éléments texte 
	(TEXT_NODE nodeType=3)
	- Expres pour firefox qui renvoi tous le childs
	d'un noeud (ELEMENT_NODE+TEXT_NODE+les autres)
=====================================================*/
{
	if(n.nodeType == 1)
	{
		var enfants = n.childNodes;
		for(var i=0; i<enfants.length; i++)
		{
			var child = enfants[i];
			if(child.nodeType == 3) n.removeChild(child);
		}
		return n;	
	}
}

function getCellText(n)
/*====================================================
	- renvoie le texte du noeud et de ses childs
	- au cas où on a des balises dans le td, on 
	récupère quand même leur contenu pour que la 
	recherche ne soit pas faussée
=====================================================*/
{
	var s = "";
	var enfants = n.childNodes;
	for(var i=0; i<enfants.length; i++)
	{
		var child = enfants[i];
		if(child.nodeType == 3) s+= child.data;
		else s+= getCellText(child);
	}
	return s;
}

function DetectKey(e)
{
/*====================================================
	- fonction de detection de la touche 'enter' 
	attaché	un élément défini (l'attribut onkeypress
	dans les inputs)
=====================================================*/
	
                var tblid = this.getAttribute("id").split("_")[1];
                
                Filter(tblid);
		
}
