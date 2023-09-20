//Test data variables
var columns = 10;
var rows = 100;
var alpha = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
var num = ['1','2','3','4','5','6','7','8','9','0'];

var padding = 20;
var tableHeight = 600;
var searchPlaceholder = $("#search");

//GENERATE TEST DATA
function generateData(){
  var data = [];
  var headers = [];
  
  //Create 6 columns
  for(var j=0; j<columns; j++){    
    var titleStr = "";
    var titleLen = getRandomInt(5, 30);
    for(var k=0; k<titleLen; k++){
      titleStr+=alpha[getRandomInt(0,25)];
    }
    headers.push(titleStr);

    //Generally data is around the same amount of characters inside a column.
    //We want to reflect this
    var maxRowCharacters = getRandomInt(5,50);
    var randomType = getRandomInt(0,1);
    switch(randomType){
      case 0: //String
        break;
      case 1: //Number
        break;
      case 2: //Date
        break;
      case 3: //Currency
        break;
    }
    
    //Create rows
    for(var i=0; i<rows; i++){
      var curRow = "";
      offsetRandCharacters = getRandomInt(Math.round(maxRowCharacters*0.75), maxRowCharacters);
      var breakFree = true;
      for(var l=0; l<offsetRandCharacters && breakFree; l++){
        switch(randomType){
          case 0: //String
            curRow += alpha[getRandomInt(0,25)];
            break;
          case 1: //Number
            curRow += num[getRandomInt(0,9)];
            break;
          case 2: //Date
            curRow = new Date(getRandomInt(0, 999999999));
            breakFree = false;
            break;
          case 3: //Currency
            break;
        }
      }
      
      //Change string back to a number
      if(randomType === 1){ curRow = Number(curRow); }
      
      //First iteration, create our 2d structure dynamically
      if(i===0){ 
        data[j] = {
          v: new Array(rows),
          t: randomType
        }
      }
      
      //Add in the datas
      data[j].v[i] = curRow;
    }
  }
  
  return {
    data: data,
    headers: headers,
    footers: headers
  }
}


var sorting = {
  //String
  "sortStringAsc": function (a,b){
    return a[0] < b[0] ? -1 : 1;
  },
  "sortStringDesc": function (a,b){
    return b[0] < a[0] ? -1 : 1;
  },
  //Date
  "sortDateAsc": function (a,b){
    return a[0].getTime() - b[0].getTime();
  },
  "sortDateDesc": function (a,b){
    return b[0].getTime() - a[0].getTime();
  },
  //Number
  "sortNumberAsc": function (a,b) {
    return a[0] - b[0];
  },
  "sortNumberDesc": function (a,b) {
    return b[0] - a[0];
  }
};

//Toggle the sorting on our columns
var sortToggles = [];

//Create our table
function setupTable($t){
  var tableData = generateData();
  var headers = tableData.headers;
  var footers = tableData.footers;
  var data = tableData.data;
  
  var thead = $("<thead></thead>").appendTo($t);
  var tbody = $("<tbody></tbody>").appendTo($t);
  
  //Create tr and td for each of our datas  
  for(var i=0; i<data[0].v.length; i++){
    var tr = "<tr>";
    for(var j=0; j<data.length; j++){
      tr += "<td>" + data[j].v[i] + "</td>";
    }
    tr += "</tr>";
    tbody.append(tr);
  }
  
  //Create headers/*
  var thr = "";
  for(var i=0; i<headers.length; i++){
    sortToggles[i] = 0;
    thr+="<th>"+headers[i]+"</th>";
  }
  thead.append("<tr>" + thr + "</tr>");
  
  //footer
  if(footers){
    var tfoot = $("<tfoot></tfoot>").appendTo($t);
    var tfr = "";
    for(var i=0; i<footers.length; i++){
      tfr+="<th>"+footers[i]+"</th>";
    }
    tfoot.append("<tr>" + tfr + "</tr>");
  }
  
  
  //Create the container for all our new stuff
  var t_container = $("<div class='t_container'></div>").insertBefore($t);
  
  //Move the table into our div element
  var tableDiv = $("<div class='tableContainer'></div>").appendTo(t_container);
  tableDiv.height(tableHeight);
  var isSortable = $t.hasClass("sortable");
  $t.detach().appendTo(tableDiv);
  
  
  //=================================================
  //Get the table widths and apply them!
  var newHeader = thead.clone();
  newHeader.css({width: $t.width() + 2});
  var th0 = thead.find("th").eq(0);
  var padding = parseInt(th0.css("padding-left")) + parseInt(th0.css("padding-right"));
  $t.find("th").each(function(){
    var $this = $(this);
    var width = $this.outerWidth() - 1 - padding;
    var index = $this.index();
    
    newHeader.find("th").eq(index).css({
      width: width
    });
  });
  
  var headerContainer = $("<table class='t_header'></table>");
  headerContainer.css({width: tableDiv.width()});
  if(isSortable) headerContainer.addClass("sortable");
  headerContainer.insertBefore(tableDiv);
  newHeader.appendTo(headerContainer);
  
  //Footer
  var newFooter = tfoot.clone();
  newFooter.css({width: $t.width() + 2});
  $t.find("th").each(function(){
    var $this = $(this);
    var width = $this.outerWidth() - 1 - padding;
    var index = $this.index();
    newFooter.find("th").eq(index).css({
      width: width
    });
  });
  
  var footerContainer = $("<table class='t_footer'></table>").insertAfter(tableDiv);
  if(isSortable) footerContainer.addClass("sortable");
  footerContainer.css({width: tableDiv.width()});
  newFooter.appendTo(footerContainer);
  
  //=================================================
  // Search
  searchPlaceholder.addClass("t_search");
  var searchBox = $("<input type='text' placeholder='Search'/>").appendTo(searchPlaceholder);
  
  //=================================================
  
  //Move the header and footer when we scroll
  tableDiv.scroll(function(){
    var $this = $(this);
    var scrollPos = $this.scrollLeft();
    newFooter.css({marginLeft: -scrollPos});
    newHeader.css({marginLeft: -scrollPos});
  });
  
  //=================================================
  // Attach sorting events
  if(isSortable){
    newHeader.find("th").each(function(){
      var $this = $(this);
      $this.click(function(i){
        var $target = $(i.target);
        toggleSort($target);
      });
    });
    
    //Create a sorting table for each column.
    //Caching the order first will reduce lag on sort
    var sortingTableAsc = [];
    var sortingTableDesc = [];
    for(var i=0; i<data.length; i++){
      var sortedDesc, sortedAsc;
      switch(data[i].t){
        case 0:
        default:
          sortedAsc = createSortIndices(data[i].v, "String", "Asc");
          sortedDesc = createSortIndices(data[i].v, "String", "Desc");
          break;
        case 1:
          sortedAsc = createSortIndices(data[i].v, "Number", "Asc");
          sortedDesc = createSortIndices(data[i].v, "Number", "Desc");
          break;
        case 2:
          sortedAsc = createSortIndices(data[i].v, "Date", "Asc");
          sortedDesc = createSortIndices(data[i].v, "Date", "Desc");
          break;
        case 3:
          //sortedAsc = data[i].v.sort(sortCurrency);
          //sortedDesc = data[i].v.sort(sortCurrency).reverse();
          break;
      }

      sortingTableAsc.push(sortedAsc);
      sortingTableDesc.push(sortedDesc);
    }
    console.log(sortingTableAsc);
    console.log(sortingTableDesc);
  }

}

setupTable($("#table"));


//Sort our rows
function toggleSort($target){
  var index = $target.index();
  $target.parent().find("th").removeClass();
  //$target.removeClass();
  
  var curDir = sortToggles[index];
  if(sortToggles[index] <= 0){
    sortToggles[index] = 1;
    $target.addClass("down");
  } else {
    sortToggles[index] = -1;
    $target.addClass("up");
  }
  
}


function createSortIndices(arr, sortFunc, dir) {
  var toSort = arr.concat(); //Clone before sorting
  for (var i = 0; i < toSort.length; i++) {
    toSort[i] = [toSort[i], i];
  }
  var sortArr = sort(toSort, sorting["sort" + sortFunc + dir]);
  return sortArr;
}


function sort(arr, sortFunc){
  return arr.sort(sortFunc);
}



function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
function getRandomBool(){
  return Math.random() >= 0.5;
}