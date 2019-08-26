/* generated javascript */
var skin = 'monobook';
var stylepath = '/skins-1.5';

/* MediaWiki:Common.js */
/* <source lang="javascript">
Any JavaScript here will be loaded for all users on every page load. */

 /** Execute function on page load *********************************************
  *
  *  Description: Wrapper around addOnloadHook() for backwards compatibility.
  *               Will be removed in the near future.
  *  Maintainers: [[:en:User:R. Koot]]
  */
 
 function addLoadEvent( f ) { addOnloadHook( f ); }

 /** Import module *************************************************************
  *
  *  Description: Includes a raw wiki page as javascript or CSS, 
  *               used for including user made modules.
  *  Maintainers: [[:en:User:AzaToth]]
  */
 
 function importScript( page ) {
     var url = wgScriptPath + '/index.php?title='
                            + escape( page.replace( ' ', '_' ) )
                            + '&action=raw&ctype=text/javascript&dontcountme=s';
     var scriptElem = document.createElement( 'script' );
     scriptElem.setAttribute( 'src' , url );
     scriptElem.setAttribute( 'type' , 'text/javascript' );
     document.getElementsByTagName( 'head' )[0].appendChild( scriptElem );
 }
 
 function importStylesheet( page ) {
     var sheet = '@import "'
               + wgScriptPath
               + '/index.php?title='
               + escape( page.replace( ' ', '_' ) )
               + '&action=raw&ctype=text/css";'
     var styleElem = document.createElement( 'style' );
     styleElem.setAttribute( 'type' , 'text/css' );
     styleElem.appendChild( document.createTextNode( sheet ) );
     document.getElementsByTagName( 'head' )[0].appendChild( styleElem );
 }

 /* Test if an element has a certain class **************************************
  *
  * Description: Uses regular expressions and caching for better performance.
  * Maintainers: [[:en:User:Mike Dillon]], [[:en:User:R. Koot]], [[:en:User:SG]]
  */
 
 var hasClass = (function () {
     var reCache = {};
     return function (element, className) {
         return (reCache[className] ? reCache[className] : (reCache[className] = new RegExp("(?:\\s|^)" + className + "(?:\\s|$)"))).test(element.className);
     };
 })();

 /** Internet Explorer bug fix **************************************************
  *
  *  Description: UNDOCUMENTED
  *  Maintainers: [[:en:User:Tom-]]?
  */
 
 if (window.showModalDialog && document.compatMode && document.compatMode == "CSS1Compat")
 {
   var oldWidth;
   var docEl = document.documentElement;
 
   function fixIEScroll()
   {
     if (!oldWidth || docEl.clientWidth > oldWidth)
       doFixIEScroll();
     else
       setTimeout(doFixIEScroll, 1);
   
     oldWidth = docEl.clientWidth;
   }
 
   function doFixIEScroll() {
     docEl.style.overflowX = (docEl.scrollWidth - docEl.clientWidth < 4) ? "hidden" : "";
   }
 
   document.attachEvent("onreadystatechange", fixIEScroll);
   attachEvent("onresize", fixIEScroll);
 }

 /** Interwiki links to featured articles ***************************************
  *
  *  Description: Highlights interwiki links to featured articles (or
  *               equivalents) by changing the bullet before the interwiki link
  *               into a star.
  *  Maintainers: [[:en:User:R. Koot]]
  */
 
 function LinkFA() 
 {
     if ( document.getElementById( "p-lang" ) ) {
         var InterwikiLinks = document.getElementById( "p-lang" ).getElementsByTagName( "li" );
 
         for ( var i = 0; i < InterwikiLinks.length; i++ ) {
             if ( document.getElementById( InterwikiLinks[i].className + "-fa" ) ) {
                 InterwikiLinks[i].className += " FA"
                 InterwikiLinks[i].title = "Ця стаття обрана у вибрані";
             }
         }
     }
 }
 
 addOnloadHook( LinkFA );

 /** Collapsible tables *********************************************************
  *
  *  Description: Allows tables to be collapsed, showing only the header. See
  *               [[:en:Wikipedia:NavFrame]].
  *  Maintainers: [[:en:User:R. Koot]]
  */
 
 var autoCollapse = 2;
 var collapseCaption = "сховати";
 var expandCaption = "показати";
 
 function collapseTable( tableIndex )
 {
     var Button = document.getElementById( "collapseButton" + tableIndex );
     var Table = document.getElementById( "collapsibleTable" + tableIndex );
 
     if ( !Table || !Button ) {
         return false;
     }
 
     var Rows = Table.getElementsByTagName( "tr" ); 
 
     if ( Button.firstChild.data == collapseCaption ) {
         for ( var i = 1; i < Rows.length; i++ ) {
             Rows[i].style.display = "none";
         }
         Button.firstChild.data = expandCaption;
     } else {
         for ( var i = 1; i < Rows.length; i++ ) {
             Rows[i].style.display = Rows[0].style.display;
         }
         Button.firstChild.data = collapseCaption;
     }
 }
 
 function createCollapseButtons()
 {
     var tableIndex = 0;
     var NavigationBoxes = new Object();
     var Tables = document.getElementsByTagName( "table" );
 
     for ( var i = 0; i < Tables.length; i++ ) {
         if ( hasClass( Tables[i], "collapsible" ) ) {
             NavigationBoxes[ tableIndex ] = Tables[i];
             Tables[i].setAttribute( "id", "collapsibleTable" + tableIndex );
 
             var Button     = document.createElement( "span" );
             var ButtonLink = document.createElement( "a" );
             var ButtonText = document.createTextNode( collapseCaption );
 
             Button.style.styleFloat = "right";
             Button.style.cssFloat = "right";
             Button.style.fontWeight = "normal";
             Button.style.textAlign = "right";
             Button.style.width = "6em";
 
             ButtonLink.setAttribute( "id", "collapseButton" + tableIndex );
             ButtonLink.setAttribute( "href", "javascript:collapseTable(" + tableIndex + ");" );
             ButtonLink.appendChild( ButtonText );
 
             Button.appendChild( document.createTextNode( "[" ) );
             Button.appendChild( ButtonLink );
             Button.appendChild( document.createTextNode( "]" ) );
 
             var Header = Tables[i].getElementsByTagName( "tr" )[0].getElementsByTagName( "th" )[0];
             Header.insertBefore( Button, Header.childNodes[0] );
 
             tableIndex++;
         }
     }
 
     for ( var i = 0;  i < tableIndex; i++ ) {
         if ( hasClass( NavigationBoxes[i], "collapsed" ) || ( tableIndex >= autoCollapse && hasClass( NavigationBoxes[i], "autocollapse" ) ) ) {
             collapseTable( i );
         }
     }
 }
 
 addOnloadHook( createCollapseButtons );

 /** "Technical restrictions" title fix *****************************************
  *
  *  Description:
  *  Maintainers: [[:en:User:Interiot]], [[:en:User:Mets501]]
  */
 
 // For pages that have something like Template:Lowercase, replace the title, but only if it is cut-and-pasteable as a valid wikilink.
 //	(for instance [[:en:iPod]]'s title is updated.  <nowiki>But [[C#]] is not an equivalent wikilink, so [[C Sharp]] doesn't have its main title changed)</nowiki>
 //
 // The function looks for a banner like this: <nowiki>
 // <div id="RealTitleBanner">    <!-- div that gets hidden -->
 //   <span id="RealTitle">title</span>
 // </div>
 // </nowiki>An element with id=DisableRealTitle disables the function.
 var disableRealTitle = 0;		// users can disable this by making this true from their monobook.js
 if (wgIsArticle) {			// don't display the RealTitle when editing, since it is apparently inconsistent (doesn't show when editing sections, doesn't show when not previewing)
     addOnloadHook(function() {
 	try {
 		var realTitleBanner = document.getElementById("RealTitleBanner");
 		if (realTitleBanner && !document.getElementById("DisableRealTitle") && !disableRealTitle) {
 			var realTitle = document.getElementById("RealTitle");
 			if (realTitle) {
 				var realTitleHTML = realTitle.innerHTML;
 				realTitleText = pickUpText(realTitle);
 
 				var isPasteable = 0;
 				//var containsHTML = /</.test(realTitleHTML);	// contains ANY HTML
 				var containsTooMuchHTML = /</.test( realTitleHTML.replace(/<\/?(sub|sup|small|big)>/gi, "") ); // contains HTML that will be ignored when cut-n-pasted as a wikilink
 				// calculate whether the title is pasteable
 				var verifyTitle = realTitleText.replace(/^ +/, "");		// trim left spaces
 				verifyTitle = verifyTitle.charAt(0).toUpperCase() + verifyTitle.substring(1, verifyTitle.length);	// uppercase first character
 
 				// if the namespace prefix is there, remove it on our verification copy.  If it isn't there, add it to the original realValue copy.
 				if (wgNamespaceNumber != 0) {
 					if (wgCanonicalNamespace == verifyTitle.substr(0, wgCanonicalNamespace.length).replace(/ /g, "_") && verifyTitle.charAt(wgCanonicalNamespace.length) == ":") {
 						verifyTitle = verifyTitle.substr(wgCanonicalNamespace.length + 1);
 					} else {
 						realTitleText = wgCanonicalNamespace.replace(/_/g, " ") + ":" + realTitleText;
 						realTitleHTML = wgCanonicalNamespace.replace(/_/g, " ") + ":" + realTitleHTML;
 					}
 				}
 
 				// verify whether wgTitle matches
 				verifyTitle = verifyTitle.replace(/^ +/, "").replace(/ +$/, "");		// trim left and right spaces
 				verifyTitle = verifyTitle.replace(/_/g, " ");		// underscores to spaces
 				verifyTitle = verifyTitle.charAt(0).toUpperCase() + verifyTitle.substring(1, verifyTitle.length);	// uppercase first character
 				isPasteable = (verifyTitle == wgTitle);
 
 				var h1 = document.getElementsByTagName("h1")[0];
 				if (h1 && isPasteable) {
 					h1.innerHTML = containsTooMuchHTML ? realTitleText : realTitleHTML;
 					if (!containsTooMuchHTML)
 						realTitleBanner.style.display = "none";
 				}
 				document.title = realTitleText + " - Вікіпедія, вільна енциклопедія";
 			}
 		}
 	} catch (e) {
 		/* Something went wrong. */
 	}
     });
 }
 
 
 // similar to innerHTML, but only returns the text portions of the insides, excludes HTML
 function pickUpText(aParentElement) {
   var str = "";
 
   function pickUpTextInternal(aElement) {
     var child = aElement.firstChild;
     while (child) {
       if (child.nodeType == 1)		// ELEMENT_NODE 
         pickUpTextInternal(child);
       else if (child.nodeType == 3)	// TEXT_NODE
         str += child.nodeValue;
 
       child = child.nextSibling;
     }
   }
 
   pickUpTextInternal(aParentElement);
 
   return str;
 }

 //fix edit summary prompt for undo
 //this code fixes the fact that the undo function combined with the "no edit summary prompter" causes problems if leaving the
 //edit summary unchanged
 //this was added by [[:en:User:Deskana]], code by [[:en:User:Tra]]
 addOnloadHook(function () {
   if (document.location.search.indexOf("undo=") != -1
   && document.getElementsByName('wpAutoSummary')[0]) {
     document.getElementsByName('wpAutoSummary')[0].value='';
   }
 })

 /** Dynamic Navigation Bars (experimental) *************************************
  *  
  *  Description: See [[Wikipedia:NavFrame]], [[:ru:Шаблон:Hider]].
  *  Maintainers: UNMAINTAINED
  */
 
  // set up the words in your language
  var NavigationBarHide = '[' + collapseCaption + ']';
  var NavigationBarShow = '[' + expandCaption + ']';
  
  // set up max count of Navigation Bars on page,
  // if there are more, all will be hidden
  // NavigationBarShowDefault = 0; // all bars will be hidden
  // NavigationBarShowDefault = 1; // on pages with more than 1 bar all bars will be hidden
  var NavigationBarShowDefault = autoCollapse;
  
  
  // shows and hides content and picture (if available) of navigation bars
  // Parameters:
  //     indexNavigationBar: the index of navigation bar to be toggled
  function toggleNavigationBar(indexNavigationBar)
  {
     var NavToggle = document.getElementById("NavToggle" + indexNavigationBar);
     var NavFrame = document.getElementById("NavFrame" + indexNavigationBar);
  
     if (!NavFrame || !NavToggle) {
         return false;
     }
  
     // if shown now
     if (NavToggle.firstChild.data == NavigationBarHide) {
         for (
                 var NavChild = NavFrame.firstChild;
                 NavChild != null;
                 NavChild = NavChild.nextSibling
             ) {
             if ( hasClass( NavChild, 'NavPic' ) ) {
                 NavChild.style.display = 'none';
             }
             if ( hasClass( NavChild, 'NavContent') ) {
                 NavChild.style.display = 'none';
             }
         }
     NavToggle.firstChild.data = NavigationBarShow;
  
     // if hidden now
     } else if (NavToggle.firstChild.data == NavigationBarShow) {
         for (
                 var NavChild = NavFrame.firstChild;
                 NavChild != null;
                 NavChild = NavChild.nextSibling
             ) {
             if (hasClass(NavChild, 'NavPic')) {
                 NavChild.style.display = 'block';
             }
             if (hasClass(NavChild, 'NavContent')) {
                 NavChild.style.display = 'block';
             }
         }
     NavToggle.firstChild.data = NavigationBarHide;
     }
  }
  
  // adds show/hide-button to navigation bars
  function createNavigationBarToggleButton()
  {
     var indexNavigationBar = 0;
     // iterate over all < div >-elements 
     var divs = document.getElementsByTagName("div");
     for(
             var i=0; 
             NavFrame = divs[i]; 
             i++
         ) {
         // if found a navigation bar
         if (hasClass(NavFrame, "NavFrame")) {
  
             indexNavigationBar++;
             var NavToggle = document.createElement("a");
             NavToggle.className = 'NavToggle';
             NavToggle.setAttribute('id', 'NavToggle' + indexNavigationBar);
             NavToggle.setAttribute('href', 'javascript:toggleNavigationBar(' + indexNavigationBar + ');');
             
             var NavToggleText = document.createTextNode(NavigationBarHide);
             NavToggle.appendChild(NavToggleText);
             // Find the NavHead and attach the toggle link (Must be this complicated because Moz's firstChild handling is borked)
             for(
               var j=0; 
               j < NavFrame.childNodes.length; 
               j++
             ) {
               if (hasClass(NavFrame.childNodes[j], "NavHead")) {
                 NavFrame.childNodes[j].appendChild(NavToggle);
               }
             }
             NavFrame.setAttribute('id', 'NavFrame' + indexNavigationBar);
         }
     }
     // if more Navigation Bars found than Default: hide all
     if (NavigationBarShowDefault < indexNavigationBar) {
         for(
                 var i=1; 
                 i<=indexNavigationBar; 
                 i++
         ) {
             toggleNavigationBar(i);
         }
     }
   
  }
  
  addOnloadHook( createNavigationBarToggleButton );

  /*
   * Функція, що на головній сторінці в кінці списку інтервікі ставить посилання на повний список всіх вікіпедій на Meta
   */

  function mainPageAppendCompleteListLink() {
    try {
        var node = document.getElementById( "p-lang" )
                           .getElementsByTagName('div')[0]
                           .getElementsByTagName('ul')[0];
        var aNode = document.createElement( 'a' );
        var liNode = document.createElement( 'li' );
        aNode.appendChild( document.createTextNode( 'Повний список' ) );
        aNode.setAttribute( 'href' , 'http://meta.wikimedia.org/wiki/List_of_Wikipedias' );
        liNode.appendChild( aNode );
        liNode.className = 'interwiki-completelist';
        node.appendChild( liNode );
     } catch(e) {
       // lets just ignore what's happened
       return;
    }
  }

  if (wgTitle == 'Головна стаття' && wgNamespaceNumber == 0 ) {
       addOnloadHook( mainPageAppendCompleteListLink );
  }

addOnloadHook(function(){
  var plus = document.getElementById('ca-addsection');
  if (!plus) return;
  var custom = document.getElementById('add-custom-section');
  if (!custom) return;
  plus.firstChild.setAttribute('href', custom.getElementsByTagName('A')[0].href);
})

 /** Import module *************************************************************
  *
  *  Предложен [[Участник:Alex_Smotrov]], на основе аналогичной английской функции
  *
  *  Description: Includes a raw wiki page as javascript or CSS, 
  *               used for including user made modules.
  */

 function importScript(page, lang) {
     var url = wgScriptPath + '/index.php?title='
                            + encodeURIComponent(page.replace(' ','_'))
                            + '&action=raw&ctype=text/javascript&dontcountme=s';
     if (lang) url = 'http://' + lang + '.wikipedia.org' + url;
     var s = document.createElement('script');
     s.src = url;
     s.type='text/javascript';
     document.getElementsByTagName('head')[0].appendChild(s);
 }

/* При загрузке [[Special:Upload]] вставляет в поле описания [[Шаблон:Изображение]]
    Автор - [[User:Alex Smotrov]]
 */
function uploadPage(){
 //автоматически вставить {Изображение}
 var desc = document.getElementById('wpUploadDescription')
 var temp = document.getElementById('imageinfo')
 if (temp && desc && !desc.value) desc.value = temp.innerHTML
 //создать ссылку для вставки {Обоснование}
 var span = document.getElementById('insertlink')
 if (!span) return
 var a = document.createElement('a')
 a.href = 'javascript:addRationaleTemplate()'
 span.parentNode.insertBefore(a, span)
 a.appendChild(span)
 span.style.display = 'inline'
}
 
function addRationaleTemplate(){
 var desc = document.getElementById('wpUploadDescription')
 var temp = document.getElementById('rationale')
 if(!desc || !temp) return
 if (desc.value.indexOf(temp.innerHTML.substring(0,8)) == -1){
   desc.value += '\n' + temp.innerHTML
   desc.rows = 15
 }
}
 
if (wgCanonicalNamespace == 'Special' && wgCanonicalSpecialPageName == 'Upload')
 addOnloadHook(uploadPage);
 
/** Обработка сортировки чисел с плавающей точкой с разделителем-запятой
  * Взято из шведской Википедии, автор - [[:sv:Användare:Skagedal]]
  * 
  */
 function ts_parseFloat(num) {
        if (!num) return 0;
        num = num.replace(/\./g, "");
        num = num.replace(/,/, ".");
        num = parseFloat(num);
        return (isNaN(num) ? 0 : num);
 }

/*</nowiki></source>*/


// </source>

/* MediaWiki:Monobook.js (deprecated; migrate to Common.js!) */
/* <source lang="javascript"> */

/* tooltips and access keys */
ta = new Object();
ta['pt-userpage'] = new Array('.','Моя сторінка користувача');
ta['pt-anonuserpage'] = new Array('.','Сторінка користувача для мого IP');
ta['pt-mytalk'] = new Array('n','Моя сторінка обговорення');
ta['pt-anontalk'] = new Array('n','Сторінка обговорення для моєї IP-адреси');
ta['pt-preferences'] = new Array('','Мої налаштування');
ta['pt-watchlist'] = new Array('l','Список сторінок, зміни яких ви спостерігаєте.');
ta['pt-mycontris'] = new Array('y','Список моїх внесків');
ta['pt-login'] = new Array('o','You are encouraged to log in, it is not mandatory however.');
ta['pt-anonlogin'] = new Array('o','You are encouraged to log in, it is not mandatory however.');
ta['pt-logout'] = new Array('o','Вийти з системи');
ta['ca-talk'] = new Array('t','Обговорення змісту сторінки');
ta['ca-edit'] = new Array('e','Ви можете редагувати цю сторінку. Будь ласка використовуйте кнопку попереднього перегляду перед тим, як зберегти зміни.');
ta['ca-addsection'] = new Array('+','Додати коментар до цього обговорення.');
ta['ca-viewsource'] = new Array('e','Ця сторінка захищена. Ви можете переглянути її зміст.');
ta['ca-history'] = new Array('h','Попередні версії цієї сторінки.');
ta['ca-protect'] = new Array('=','Захистити цю сторінку');
ta['ca-delete'] = new Array('d','Вилучити цю сторінку');
ta['ca-undelete'] = new Array('d','Відновити редагування, що були зроблені до вилучення цієї сторінки');
ta['ca-move'] = new Array('m','Перейменувати цю сторінку');
ta['ca-watch'] = new Array('w','Додати цю сторінку до вашого списку спостереження');
ta['ca-unwatch'] = new Array('w','Вилучити цю сторінку з вашого списку спостереження');
ta['search'] = new Array('f','Пошук по цій вікі');
ta['p-logo'] = new Array('','Головна стаття');
ta['n-mainpage'] = new Array('z','Перейти до Головної статті');
ta['n-portal'] = new Array('','About the project, what you can do, where to find things');
ta['n-currentevents'] = new Array('','Find background information on current events');
ta['n-recentchanges'] = new Array('r','Список поточних редагувань у цій вікі.');
ta['n-randompage'] = new Array('x','Перейти до випадкової статті');
ta['n-help'] = new Array('','The place to find out.');
ta['n-sitesupport'] = new Array('','Support us');
ta['t-whatlinkshere'] = new Array('j','Список всіх сторінок вікі, що мають посилання сюди');
ta['t-recentchangeslinked'] = new Array('k','Поточні редагування сторінок, на які є посилання з цієї сторінки');
ta['feed-rss'] = new Array('','RSS feed for this page');
ta['feed-atom'] = new Array('','Atom feed for this page');
ta['t-contributions'] = new Array('','Переглянути список внеску цього користувача');
ta['t-emailuser'] = new Array('','Відіслати електронного листа цьому користувачу');
ta['t-upload'] = new Array('u','Завантажити зображення або медія файли');
ta['t-specialpages'] = new Array('q','Список всіх спеціальних сторінок');
ta['ca-nstab-main'] = new Array('c','Переглянути зміст сторінки');
ta['ca-nstab-user'] = new Array('c','Переглянути сторінку користувача');
ta['ca-nstab-media'] = new Array('c','Переглянути медія сторінку');
ta['ca-nstab-special'] = new Array('','Ця сторінка є спеціальною, ви не можете самостійно її редагувати.');
ta['ca-nstab-wp'] = new Array('a','Переглянути захищену сторінку');
ta['ca-nstab-image'] = new Array('c','Переглянути сторінку зображення');
ta['ca-nstab-mediawiki'] = new Array('c','Переглянути системне повідомлення');
ta['ca-nstab-template'] = new Array('c','Переглянути шаблон');
ta['ca-nstab-help'] = new Array('c','Переглянути сторінку допомоги');
ta['ca-nstab-category'] = new Array('c','Переглянути категорію');


if (document.URL.indexOf("action=edit") > 0 || document.URL.indexOf("action=submit") > 0)
{
        if (wgCanonicalNamespace != "Special")
        {
              document.write('<script type="text/javascript" src="' 
              + 'http://uk.wikipedia.org/w/index.php?title=MediaWiki:Onlyifediting.js' 
              + '&action=raw&ctype=text/javascript&dontcountme=s"></script>'); 
        }
}

// Розширений пошук
// Автор: ru:User:Не А

function SpecialSearchEnhanced() 
{
    var mainNode = document.getElementsByTagName("form");
    if (!mainNode) return;
    
    var searchValue = document.forms[0].search.value
	var safeSearchValue = searchValue.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;");
    var firstForm = mainNode[0];

    var node = document.createElement('div');
    
var googleSearch  = '<form action="http://www.google.com/custom" method="get" name="google" target="_blank" id="google">';
    googleSearch += '<input type="hidden" name="hl" value="uk" />';
    googleSearch += '<input type="hidden" name="domains" value="uk.wikipedia.org" />';
    googleSearch += '<input type="hidden" name="q" maxlength="2048" value="' + safeSearchValue + '" />'
    googleSearch += '<input type="hidden" name="sitesearch" value="uk.wikipedia.org" />'
    googleSearch += '<input type="button" value="Google по Вікіпедії" onclick="document.google.q.value = document.forms[0].search.value; this.form.submit();" style="width: 12em;" />'
    googleSearch += '</form>'
    
var yandexSearch  = '<form action="http://www.yandex.ua/yandsearch" method="get" name="yandex" target="_blank" id="yandex">';
    yandexSearch += '<input type="hidden" name="text" maxlength="300" value="' + safeSearchValue + '" />';
    yandexSearch += '<input type="hidden" name="site" value="uk.wikipedia.org" />';
    yandexSearch += '<input type="hidden" name="ras" value="1" />'
    yandexSearch += '<input type="hidden" name="site_manually"  value="true" />'
    yandexSearch += '<input type="hidden" name="server_name" value="Вікіпедія" />'
    yandexSearch += '<input type="button" value="Яндекс по Вікіпедії"  onclick="document.yandex.text.value = document.forms[0].search.value; this.form.submit();" style="width: 12em;" />'
    yandexSearch += '</form>'

    node.innerHTML = node.innerHTML + '<table style="margin-left: 75%;  padding-left:4px;"><tr><td>' + yandexSearch + '</td></tr><tr><td>' + googleSearch + '</td></tr></table>';
        
    firstForm.parentNode.insertBefore(node, firstForm.nextSibling);
}

if (wgPageName == "Спеціальні:Search") { addOnloadHook(SpecialSearchEnhanced); }

 // ============================================================
 // BEGIN pageview counter
 // 	Please talk to de:User:LeonWeber before changing anything or 
 // 	if there are any issues with that.
 
 // this should be adjusted to a good value.
 // BE CAREFULL, you will break zedler if it's too low!
 // And then DaB. will kill Leon :-(
 var disable_counter = 0;
 var counter_factor = 4; 
 
 function pgcounter_setup()
 {
 	if(disable_counter == 0)
 	{
 		var url = window.location.href;
 		if(Math.floor(Math.random()*counter_factor)==3)  // the probability thing
  		{
  			if(wgIsArticle==true || wgArticleId==0) // do not count history pages etc.
 			{
 				var pgcountNs = wgCanonicalNamespace;
 				if(wgCanonicalNamespace=="")
 				{
 					pgcountNs = "0";
 				}
  				var cnt_url = "http://pgcount.wikimedia.de/index.png?ns=" + pgcountNs + "&title=" + encodeURI(wgTitle) + "&factor=" + counter_factor + "&wiki=ukwiki";
 				var img = new Image(); 
 				img.src = cnt_url;
 			}
 		}
 	}
 }
 // Do not use aOnloadFunctions[aOnloadFunctions.length] = pgcounter_setup;, some browsers don't like that.
 pgcounter_setup();
 
 // END pageview counter 
 // ============================================================

var disable_zero_section = 0;
function edit_zero_section()
{ 
 if((disable_zero_section != 1) && (document.getElementById('bodyContent').innerHTML.match('class=\"editsection\"')))
    document.getElementById('bodyContent').innerHTML = "<div class=\"editsection\" id=\"ca-edit-0\">[<a href=\"http://uk.wikipedia.org/w/index.php?title=" + document.title.substr(0, document.title.lastIndexOf(" — Вікіпедія")) + "&action=edit&section=0\">ред.</a>]</div>" + document.getElementById('bodyContent').innerHTML;
}
addLoadEvent(edit_zero_section);


var auto_comment = 0

/* Українізація кнопок панелі інструментів   */

if (wgAction == 'edit' || wgAction == 'submit') 
addOnloadHook(function(){
 if (mwEditButtons.length < 3) return;
 mwEditButtons[0].imageFile = 'http://upload.wikimedia.org/wikipedia/commons/f/fa/Button_bold_ukr.png';
 mwEditButtons[1].imageFile = 'http://upload.wikimedia.org/wikipedia/commons/f/f3/Button_italic_ukr.png';
 mwEditButtons[2].imageFile = 'http://upload.wikimedia.org/wikipedia/commons/0/03/Button_internal_link_ukr.png';
})

/* </nowiki></source>

[[ru:MediaWiki:Monobook.js]]
*/