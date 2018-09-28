//--------------------------------------------------------------------------
// Public constructor function
//--------------------------------------------------------------------------
/**
*  ...
*
*  @version    1.0
*  @copyright  Copyright (c) 2017.
*  @license    Creative Commons (BY-NC-SA)
*  @since      Feb 13, 2017
*  @author     Michaela Olausson <michaelaolausson@gmail.com>
*/
var Main = {
count : 0,
//--------------------------------------------------------------------------
// API // URL
//--------------------------------------------------------------------------
url : null,
//--------------------------------------------------------------------------
// API // LIMIT
//--------------------------------------------------------------------------
limit : null,
//--------------------------------------------------------------------------
// Class global object Arrays
//--------------------------------------------------------------------------
m_objArr : null,
//--------------------------------------------------------------------------
// Class global templates - placed in object
//--------------------------------------------------------------------------
m_templates : null,
//--------------------------------------------------------------------------
// page number
//--------------------------------------------------------------------------
m_page : 1, // current page - int
m_pageAmount : null,
//--------------------------------------------------------------------------
// Class global templates - placed in object
//--------------------------------------------------------------------------
m_currentFilter : null,
//--------------------------------------------------------------------------
// global buttons
//--------------------------------------------------------------------------
nextBtn : null,
backBtn : null,
//--------------------------------------------------------------------------
// initiates program. starts ajax request and initiates retrival of html templates.
//--------------------------------------------------------------------------
    init : function() {
        Main.url = "http://localhost/com/arkhamhorrordb/API/";  
        Main.limit = "?limit=4";
        if (Main.m_page == 1) {
            Main.getDocuments( Main.url + Main.limit );
            Main.initEvents(); // add Event listeners to menu
        } 
    },
    initEvents : function () {
        //--------------------------------------------------------------------------
        // menues
        //--------------------------------------------------------------------------
        var dropdownLinks = document.getElementsByClassName("dropdownLink");
        var len = dropdownLinks.length;
        var header = document.getElementById("indexHeader");
        var currentType = header.innerHTML;
        //--------------------------------------------------------------------------
        // search bar
        //--------------------------------------------------------------------------
        var searchBar = document.getElementById("searchbar");
        //--------------------------------------------------------------------------
        // global buttons
        //--------------------------------------------------------------------------
        Main.nextBtn = document.getElementById("forwardBtn");
        Main.backBtn = document.getElementById("backwardBtn");
        //--------------------------------------------------------------------------
        // menu listener
        //--------------------------------------------------------------------------
        for (var i = 0; i < len; i++) {
            Events.addListener(dropdownLinks[i], "click", Main.newCall);
        }
        //--------------------------------------------------------------------------
        // button listener + disabled/enabled
        //--------------------------------------------------------------------------
        Events.addListener(Main.nextBtn, "click", Main.changePage);
        Main.backBtn.className = "pageBtnDisabled";
        //--------------------------------------------------------------------------
        // search bar listener
        //--------------------------------------------------------------------------
        Events.addListener(searchBar,"keydown", Main.search);
    },
    /*
    * creates new call to API depending on menu choices.
    * @return void
    */
    search : function (event) {
        var requestUrl = Main.url + Main.limit + "?search=" + this.value;
        Main.getDocuments(requestUrl);
    },
    /*
    * depending on source btn.
    * @return void
    */
    changePage : function (event) {
        if (this.id == "forwardBtn") { Main.m_page++; } 
        else if (this.id == "backwardBtn") { Main.m_page--; }
            
       if ( Main.m_page <= 1) {
            Main.m_page = 1;
            Main.backBtn.className = "pageBtnDisabled";
            Events.removeListener(Main.backBtn, "click", Main.changePage);
        }
        if ( Main.m_page > 1) {
            Main.backBtn.className = "pageBtn";
            Events.addListener(Main.backBtn, "click", Main.changePage);
        }
        if ( Main.m_page == Main.m_pageAmount ) {
            Main.nextBtn.className = "pageBtnDisabled";
            Events.removeListener(Main.nextBtn, "click", Main.changePage);
        }
        else if (Main.m_page < Main.m_pageAmount) {
            Main.nextBtn.className = "pageBtn";
            Events.addListener(Main.nextBtn, "click", Main.changePage);
        }
        
        Main.limit = "?limit=4" + "+" + Main.m_page;  
        Main.getDocuments( Main.url + Main.limit );
    },

    getDocuments : function ( url ) {
        console.log(url);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open( 'GET', url, true);
        xmlhttp.send(null);
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
                if (xmlhttp.status == 200) {
                    var response = xmlhttp.responseText;
                    Main.parseDocuments(response);
                }
                else {
                    Error("something went wrong");
                } 
            }
        }  
    },
    parseDocuments : function( json ) {
        // Parse into array of JSON objects
        //console.log(json);
        var documents = JSON.parse( json );
        var len = documents.length;
        Main.m_objArr = new Array();
        // Parse into array of JavaScript objects
        for ( var i = 0; i < len; i++ ) {
            documents[i] = JSON.parse( documents[i] );
            if (documents[i].type) {
                Main.m_objArr.push(documents[i]);
            }
            else { Main.showPageCount(documents[i]); }
        }
        Main.renderCards();
    },
    showPageCount(value) {
        var pageCountElem = document.getElementById("pageCount");
        Main.m_pageAmount = Math.ceil(value / 4);
        pageCountElem.innerHTML = "page " + Main.m_page + " of " + Main.m_pageAmount; 
        if ( Main.m_page == Main.m_pageAmount ) {
            Main.nextBtn.className = "pageBtnDisabled";
            Events.removeListener(Main.nextBtn, "click", Main.changePage);
        }
    },
    renderCards : function () {
        if (Main.m_templates == null) {
            Main.m_templates = new Object();
        } 
        //console.log(Main.m_templates);
        //console.log(Main.m_templates);
        var resDiv = document.getElementById("result");
        resDiv.innerHTML = "";
        // loop and call each render with appropriate template
        //console.log(Main.m_objArr);
        if (Main.m_objArr.length != 0) { 
            Main.m_objArr.forEach(function(obj) {
                Main.getTemplate(obj.type).then(function(template) { 
                    //console.log(template);
                    resDiv.innerHTML += Mustache.render( template, obj );
                   // Main.pageScroll();
                }, function(error) {
                    console.error("Failed!", error);
                });
            });
        }
        
    },
    // Tutorial and example followed from:
    // return promise
    // https://developers.google.com/web/fundamentals/getting-started/primers/promises
    getTemplate : function (type) {
        if (Main.m_templates.hasOwnProperty(type)) {
           // return Main.m_templates.hasOwnProperty(type);
        }
        return new Promise(function(resolve, reject) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open( 'GET', "http://localhost/com/arkhamhorrordb/library/templates/" + type + "_template.html", true);
            xmlhttp.onload = function () {
                if (xmlhttp.status == 200) {

                    var template = xmlhttp.responseText;
                    Main.m_templates[type] = template; 
                    resolve(template);
                }
                else {
                    reject(Error(xmlhttp.statusText));
                }
            };
            xmlhttp.onerror = function () {
                reject(Error("Network Error"));
            };
            xmlhttp.send(null);
        }); 
    } 
}
//----------------------------------------------------------------------
// BOOTSTRAP
//----------------------------------------------------------------------
window.addEventListener("load", Main.init);